<?php

namespace Entryshop\Admin\Http\Controllers\Traits;

use Entryshop\Admin\Components\Cell;
use Entryshop\Admin\Components\Grid;
use Entryshop\Admin\Components\Table\Columns\Actions;
use Entryshop\Admin\Components\Widgets\Action;

trait HasIndex
{
    public function index()
    {
        admin()->title($this->getLabelPlural());
        $grid = Grid::make();
        $grid->models($this->models());
        $grid = $this->grid($grid);
        $this->layout()->title($this->getLabelPlural());
        return $this->layout()->child($grid)->render();
    }

    protected function grid($grid)
    {
        $columns = [];

        foreach ($this->columns() as $name => $column) {
            if (is_string($column)) {
                $column = [
                    'type' => 'text',
                    'name' => $column,
                ];
            }

            if (is_string($name)) {
                $column['name'] = $name;
            }

            if (is_array($column)) {
                $column = $this->getColumn($column);
            }

            if (!empty($column)) {
                $columns[] = $column;
            }
        }

        if (!empty($actions = $this->actions('index'))) {
            $columns[] = Actions::make()
                ->label(__('admin::base.actions'))
                ->children($actions);
        }

        $grid->columns($columns);

        if (!empty($searches = $this->searches())) {
            $grid->searches($searches);
        }

        $filters = [];

        foreach ($this->filters() as $name => $filter) {
            if (is_string($filter)) {
                $filter = [
                    'type' => 'text',
                    'name' => $filter,
                ];
            }

            if (is_string($name)) {
                $filter['name'] = $name;
            }

            if (is_array($filter)) {
                $filter = $this->getFilter($filter);
            }

            if (!empty($filter)) {
                $filters[] = $filter;
            }
        }

        if (!empty($filters)) {
            $grid->filters($filters);
        }

        if (!empty($tools = $this->tools())) {
            $grid->tools($tools);
        }

        if (!empty($batches = $this->batches())) {
            $grid->batch($batches);
        }

        if (!empty($order = $this->order())) {
            $grid->models()->orderBy($order[0] ?? null, $order[1] ?? null);
        }

        return $grid;
    }

    protected function order()
    {
        return $this->crud()['order'] ?? [];
    }

    protected function searches()
    {
        return $this->crud()['searches'] ?? [];
    }

    protected function filters()
    {
        return $this->crud()['filters'] ?? [];
    }

    protected function tools()
    {
        return $this->crud()['tools'] ?? [
            Action::make('create')
                ->icon('ri-add-line')
                ->class('btn btn-primary')
                ->href(admin()->url($this->getRoute() . '/create'))
                ->label(__('admin::base.create')),
        ];
    }

    protected function batches()
    {
        return $this->crud()['batches'] ?? [];
    }

    protected function columns()
    {
        return $this->crud()['columns'] ?? [];
    }

    protected function getColumn($column)
    {
        $column['label'] ??= $this->getLang($column['name']);

        /**
         * @var Cell $cellClass
         */
        $cellClass = Grid::$availableColumns[$column['type'] ?? 'text'];

        return $cellClass::make($column);
    }

    protected function getFilter($filter)
    {
        $filter['label'] ??= $this->getLang($filter['name']);

        /**
         * @var Cell $cellClass
         */
        $cellClass = Grid::$availableFilters[$filter['type'] ?? 'text'];

        return $cellClass::make($filter);
    }
}
