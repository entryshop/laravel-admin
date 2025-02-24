<?php

namespace Entryshop\Admin\Http\Controllers\Traits;

use Entryshop\Admin\Components\Form;

trait HasForm
{
    public function edit(...$args)
    {
        $id = array_pop($args);

        $this->layout()
            ->title(__('admin::base.edit') . ' ' . $this->getlabel())
            ->back(admin()->url($this->getRoute()));
        return $this->layout()->child($this->form($id))->render();
    }

    public function update(...$args)
    {
        $id = array_pop($args);
        $this->save($id);
        admin()->success(__('admin::base.update_success'));
        return back();
    }

    public function create()
    {
        $this->layout()
            ->title(__('admin::base.create') . ' ' . $this->getlabel())
            ->back(admin()->url($this->getRoute()));
        return $this->layout()->child($this->form())->render();
    }

    public function store()
    {
        $this->save();
        admin()->success(__('admin::base.saved_success'));
        return $this->index();
    }

    protected function form($id = null)
    {
        $model  = $this->model($id);
        $form   = Form::make()
            ->model($model)
            ->route($this->getRoute())
            ->editing(true);
        $fields = Form\Form::toFields($this->fields($id));
        foreach ($fields as $field) {
            if (!$field->getOriginal('label')) {
                $field->label($this->getLang($field->name()));
            }
        }
        $form->fields($fields);
        return $form;
    }

    protected function fields($id = null)
    {
        return [];
    }

    protected function save($id = null, $request = null)
    {
        $form  = $this->form($id);
        $model = $form->save($request);
        $model->save();
    }
}
