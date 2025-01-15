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
        admin()->title($this->getlabel());
        $grid = $this->grid();
        $this->layout()->title($this->getlabel());
        return $this->layout()->child($grid)->render();
    }

    protected function grid()
    {
        $grid = Grid::make();

        $grid->models($this->models());

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

            $cell = $this->getColumn($column);

            if (!empty($cell)) {
                $columns[] = $cell;
            }
        }

        if (!empty($actions = $this->actions())) {
            $columns[] = Actions::make()
                ->label(__('admin::base.actions'))
                ->children($actions);
        }

        $grid->columns($columns);

        if (!empty($searches = $this->searches())) {
            $grid->search($searches);
        }

        if (!empty($filters = $this->filters())) {
            $grid->filters($filters);
        }

        if (!empty($tools = $this->tools())) {
            $grid->tools($tools);
        }
        return $grid;
    }

    protected function searches()
    {
        return ['id'];
    }

    protected function filters()
    {
        return [];
    }

    protected function tools()
    {
        return [
            Action::make('create')
                ->href(admin()->url($this->route . '/create'))
                ->label(__('admin::base.create')),
        ];
    }

    protected function actions($view = 'index')
    {
        $actions = [];
        if ($view === 'index') {
            if ($this->index_actions['view']) {
                $actions[] = Action::make(label: __('admin::base.view'))
                    ->href(admin()->url($this->route . '/{model.id}'));
            }

            if ($this->index_actions['edit']) {
                $actions[] = Action::make(label: __('admin::base.edit'))
                    ->href(admin()->url($this->route . '/{model.id}/edit'));
            }

            if ($this->index_actions['delete']) {
                $actions[] = Action::make(label: __('admin::base.delete'))
                    ->action(admin()->url($this->route . '/{model.id}'))
                    ->danger()
                    ->confirm('你确定要删除吗?')
                    ->method('delete');
            }
        }
        return $actions;
    }

    protected function columns()
    {
        return [];
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
}
