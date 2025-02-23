<?php

namespace Entryshop\Admin\Components;

use Closure;
use Entryshop\Admin\Components\Filters\Filter;
use Entryshop\Admin\Components\Form\Fields\Text;
use Entryshop\Admin\Components\Form\Form;
use Entryshop\Admin\Components\Table\Columns;
use Entryshop\Admin\Components\Table\Table;
use Entryshop\Admin\Concerns\HasChildren;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Str;

/**
 * @method self|array|Builder models($value = null)
 * @method self|array search($value = null)
 * @method self|array columns($value = null)
 * @method self|array batch($value = null)
 * @method self|array tools($value = null)
 * @method self|array filters($value = null)
 * @method self|number perPage($value = null)
 * @method self table(Closure $value)
 */
class Grid extends Element
{
    use HasChildren;

    public $view = 'admin::grid';

    protected $models;

    public static $availableColumns = [
        'text'  => Columns\Text::class,
        'image' => Columns\Image::class,
    ];

    public static $availableFilters = [
        'text' => Filters\Text::class,
        'date' => Filters\Date::class,
    ];

    public function __call($method, $parameters)
    {
        if (in_array($method, array_keys(static::$availableColumns))) {
            /** @var Columns\Column $columnClass */
            $columnClass = static::$availableColumns[$method];
            $column      = $columnClass::make(...$parameters);
            $this->column($column);
            return $this;
        }

        if (Str::endsWith($method, '_filter')) {
            $method = Str::beforeLast($method, '_filter');
            if (in_array($method, array_keys(static::$availableFilters))) {
                /** @var Filter $filterClass */
                $filterClass = static::$availableFilters[$method];
                $filter      = $filterClass::make(...$parameters);
                $this->filter($filter);
                return $this;
            }
        }

        return parent::__call($method, $parameters);
    }

    public function column($column)
    {
        $columns   = $this->get('columns', []);
        $columns[] = $column;
        $this->columns($columns);
        return $this;
    }

    public function filter($filter)
    {
        $filters   = $this->get('filters', []);
        $filters[] = $filter;
        $this->filters($filters);
        return $this;
    }

    protected function applySort()
    {
        if ($sort_by = request('sort_by')) {
            $this->models->orderBy($sort_by, request('sort_type'));
        }
    }

    protected function applySearch()
    {
        $search = $this->get('search');
        if (!empty($search)) {
            $search_keyword = request('search');

            $search_form = Form::make()->fields([
                Text::make('search')->placeholder(__('admin::base.search')),
            ])->plain()
                ->model([
                    'search' => $search_keyword,
                ]);

            $this->set('search_form', $search_form);

            if (!empty($search_keyword)) {
                $this->models->where(function ($query) use ($search, $search_keyword) {
                    foreach ($search as $field) {
                        if ($field === '*') {
                            $columns        = Schema::getColumnListing($query->from);
                            $columns_string = implode(',', $columns);
                            $field          = DB::raw('CONCAT(' . $columns_string . ')');
                        }
                        $query->orWhere($field, 'like', "%{$search_keyword}%");
                    }
                });
            }
        }
    }

    protected function applyFilters()
    {
        $filters = $this->filters();

        $queries = request('filter');
        if (empty($queries)) {
            return;
        }

        $queries = to_json($queries);
        foreach ($queries as $query) {
            $active_filter = null;

            foreach ($filters as $filter) {
                if ($filter->name() == $query['field']) {
                    $active_filter = $filter;
                }
            }

            if (empty($active_filter)) {
                continue;
            }

            $this->models = $active_filter->apply($this->models, $query);
        }
    }

    public function render()
    {
        $this->models = $this->get('models');

        $this->applySearch();
        $this->applyFilters();
        $this->applySort();

        $this->set('models', $this->models->paginate($this->get('perPage', 10)));

        /**
         * @var Table $_table
         */
        $_table = Table::make()->models($this->models());

        if (is_callable($table = $this->getOriginal('table'))) {
            call_user_func($table, $_table);
        }

        if ($columns = $this->get('columns')) {
            $_table->columns($columns);
        }

        $_table->selectable(!empty($this->batch()));

        $this->set('table', $_table);

        return parent::render();
    }
}
