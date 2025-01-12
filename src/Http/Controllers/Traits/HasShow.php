<?php

namespace Entryshop\Admin\Http\Controllers\Traits;

use Entryshop\Admin\Components\Show;

trait HasShow
{
    public function show($id)
    {
        $model   = $this->model($id);
        $show    = Show::make()->model($model);
        $details = $this->detail();
        $show->details($details);
        $this->layout()
            ->title($this->getlabel() . ' ' . __('admin::base.detail'))
            ->back(admin()->url($this->route));
        return $this->layout()->child($show)->render();
    }

    public function detail()
    {
        $crud    = $this->crud('show');
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

            if (!($column['show'] ?? true)) {
                continue;
            }

            $columns[] = $this->getColumn($column);
        }
        return $columns;
    }

}
