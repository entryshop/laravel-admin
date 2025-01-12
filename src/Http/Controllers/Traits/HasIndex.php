<?php

namespace Entryshop\Admin\Http\Controllers\Traits;

use Entryshop\Admin\Components\Grid;
use Entryshop\Admin\Components\Table\Columns\Actions;
use Entryshop\Admin\Components\Widgets\Action;

trait HasIndex
{
    public function index()
    {
        $grid = $this->grid();
        $this->layout()->title($this->getlabel());
        return $this->layout()->child($grid)->render();
    }

    public function grid()
    {
        $grid = Grid::make();

        $grid->models($this->models());

        $columns = $this->columns();
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

    public function searches()
    {
        return [];
    }

    public function filters()
    {
        return [];
    }

    public function tools()
    {
        return [
            Action::make('create')
                ->href(admin()->url($this->route . '/create'))
                ->label(__('admin::base.create')),
        ];
    }

    public function actions($view = 'index')
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

    public function columns()
    {
        $crud    = $this->crud();
        $columns = [];
        foreach ($crud as $name => $column) {
            if (is_string($column)) {
                $column = [
                    'type' => 'text',
                    'name' => $column,
                ];
            }
            if (is_string($name)) {
                $column['name'] = $name;
            }

            if (!($column['index'] ?? true)) {
                continue;
            }

            $cell = $this->getColumn($column);

            if (!empty($cell)) {
                $columns[] = $cell;
            }
        }
        return $columns;
    }
}
