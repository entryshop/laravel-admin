<?php

namespace Entryshop\Admin\Components;

use Entryshop\Admin\Components\Table\Columns;
use Entryshop\Admin\Components\Table\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @method Columns\Text text(...$args) Add text column
 * @method self|string title($value = null) Set table title
 * @method self|string|Model|array|iterable models($value = null) Set models
 * @method self|float perPage($value = null) Set per page
 * @method self|array filters($value = []) Set filters
 * @method self|array tools($value = []) Set tool buttons
 * @method self|array batches($value = []) Set batch actions
 * @method self|array columns($value = []) Set tool buttons
 * @method self|array searches($value = []) Set search columns
 */
class Grid extends Element
{
    public $view = 'admin::grid';

    /**
     * @var Table
     */
    public $table;

    /**
     * @var string|Model|array|iterable
     */
    public $models;

    public static $availableColumns = [
        'text'  => Columns\Text::class,
        'image' => Columns\Image::class,
    ];

    public function registerGrid()
    {
        $this->table = Table::make();
    }

    public function __call($method, $parameters)
    {
        if (in_array($method, array_keys(static::$availableColumns))) {
            /** @var Columns\Column $columnClass */
            $columnClass = static::$availableColumns[$method];
            $column      = $columnClass::make(...$parameters);
            $columns     = $this->get('columns', []);
            $columns[]   = $column;
            $this->columns($columns);
            return $column;
        }

        return parent::__call($method, $parameters);
    }

    protected function buildModels()
    {
        $this->models = $this->models ?: $this->models();

        if (is_string($this->models)) {
            $this->models = app($this->models);
        }

        $this->applySearch();

        // apply filters
        $this->applyFilters();

        // apply sort
        $this->applySort();

        $this->models = $this->models->paginate($this->perPage())->withQueryString();
    }

    protected function applyFilters()
    {
        $filters = $this->filters();

        if (empty($filters)) {
            return;
        }

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

    protected function applySearch()
    {
        if (!empty($search = $this->searches())) {
            $search_keyword = request('search');
            if (!empty($search_keyword)) {
                $this->models = $this->models->where(function (Builder $query) use ($search, $search_keyword) {
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

    protected function applySort()
    {
        if ($sort_by = request('sort_by')) {
            $this->models = $this->models->orderBy($sort_by, request('sort_type'));
        }
    }

    public function setupGrid()
    {
        $this->buildModels();
        $this->table->models($this->models);
        $this->table->columns($this->columns());
        if (!empty($this->batches())) {
            $this->table->selectable(true);
        }
    }

    public function table($callable)
    {
        call_user_func($callable, $this->table);
        return $this;
    }

    public function getDefaultPerPage()
    {
        return 10;
    }

}
