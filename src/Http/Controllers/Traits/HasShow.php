<?php

namespace Entryshop\Admin\Http\Controllers\Traits;

use Entryshop\Admin\Components\Show;
use Entryshop\Admin\Components\Table\Columns\Actions;

trait HasShow
{
    public function show(...$args)
    {
        $id   = array_pop($args);
        $show = $this->detail($id);
        $this->layout()
            ->title($this->getlabel() . ' ' . __('admin::base.detail'))
            ->back(admin()->url($this->getRoute()));
        return $this->layout()->child($show);
    }

    protected function detail($id)
    {
        $model   = $this->model($id);
        $show    = Show::make()->model($model);
        $details = [];
        foreach ($this->infolist($model) as $name => $column) {
            if (is_string($column)) {
                $column = [
                    'type' => 'text',
                    'name' => $column,
                ];
            }
            if (is_string($name)) {
                $column['name'] = $name;
            }

            $details[] = $this->getColumn($column);
        }

        $show->details($details);

        if (!empty($actions = $this->actions('show'))) {
            $show->actions(Actions::make()
                ->children($actions));
        }

        return $show;
    }

    protected function infolist($model)
    {
        $crud = $this->crud();
        return $crud['infolist'] ?? ($crud['columns'] ?? []);
    }
}
