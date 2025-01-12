<?php

namespace Entryshop\Admin\Http\Controllers\Traits;

use Entryshop\Admin\Components\Form;

trait HasForm
{
    public function edit($id)
    {
        $this->layout()
            ->title(__('admin::base.edit') . ' ' . $this->getlabel())
            ->back(admin()->url($this->route));
        return $this->layout()->child($this->form($id))->render();
    }

    public function create()
    {
        $this->layout()
            ->title(__('admin::base.create') . ' ' . $this->getlabel())
            ->back(admin()->url($this->route));
        return $this->layout()->child($this->form())->render();
    }

    public function form($id = null)
    {
        $model  = $this->model($id);
        $form   = Form::make()
            ->model($model)
            ->route($this->route)
            ->editing(true);
        $fields = $this->fields($id);
        $form->fields($fields);
        return $form;
    }

    public function fields($id = null)
    {
        $editing = (bool)$id;
        $crud    = $this->crud();
        $fields  = [];
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

            if (!($column['form'] ?? true)) {
                continue;
            }

            if ($editing && ($column['edit'] ?? true == false)) {
                continue;
            }

            if (!$editing && ($column['create'] ?? true == false)) {
                continue;
            }

            $fields[] = $this->getField($column);
        }
        return $fields;
    }

    public function save($id = null, $request = null)
    {
        $form  = $this->form($id);
        $model = $form->save($request);
        $model->save();
    }

    public function update($id)
    {
        $this->save($id);
        return back();
    }

    public function store()
    {
        $this->save();
        return $this->index();
    }

}
