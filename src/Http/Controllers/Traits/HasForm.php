<?php

namespace Entryshop\Admin\Http\Controllers\Traits;

use Entryshop\Admin\Components\Form;
use Entryshop\Models\Member;

trait HasForm
{
    public function edit(...$args)
    {
        $id    = array_pop($args);
        $model = $this->model($id);
        $form  = $this->form(
            Form::make()
                ->route($this->getRoute())
                ->editing(true)
                ->model($model)
        );

        return $this->layout()
            ->title(__('admin::base.edit') . ' ' . $this->getlabel())
            ->back(admin()->url($this->getRoute()))
            ->child($form)
            ->render();
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
        $form = $this->form(
            Form::make()
                ->route($this->getRoute())
                ->editing(false)
        );

        return $this->layout()
            ->title(__('admin::base.create') . ' ' . $this->getlabel())
            ->back(admin()->url($this->getRoute()))
            ->child($this->form($form))
            ->render();
    }

    public function store()
    {
        $this->save();
        admin()->success(__('admin::base.saved_success'));
        return redirect(admin()->url($this->getRoute()));
    }

    protected function form($form)
    {
        $form->flex();

        $fields = Form\Form::toFields($this->fields($form));

        foreach ($fields as $field) {
            if (!$field->getOriginal('label')) {
                $field->label($this->getLang($field->name()));
            }
        }
        $form->fields($fields);
        return $form;
    }

    protected function fields($form)
    {
        return $this->crud()['fields'] ?? [];
    }

    protected function save($id = null, $request = null)
    {
        $form  = Form::make();
        $model = $this->model($id);
        $form->model($model);
        $form  = $this->form($form);
        $model = $form->save($request);
        $model->save();
    }
}
