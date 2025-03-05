<?php

namespace Entryshop\Admin\Components;

use Entryshop\Admin\Components\Form\Form as BaseForm;
use Entryshop\Admin\Concerns\HasChildren;
use Illuminate\Database\Eloquent\Model;

/**
 * @method self|BaseForm form($value = null)
 * @method self|array fields($value = null)
 * @method self|Model model($value = null)
 * @method self|bool editing($value = null)
 * @method self|string route($value = null)
 */
class Form extends Element
{
    use HasChildren;

    public $view = 'admin::form';

    /**
     * @var BaseForm
     */
    public $form;

    public function registerForm()
    {
        $this->form = BaseForm::make();
    }

    public function save($request = null)
    {
        $this->setupForm();
        $this->form->validate($request);
        $model = $this->model();
        foreach ($this->fields() ?? [] as $field) {
            $field->model($model);
            $model->{$field->name()} = $field->getValueFromRequest($request);
        }
        $model->save();
        return $model;
    }

    public function setupForm()
    {
        $this->form->fields($this->fields());
        $this->form->model($this->model());

        if ($model_id = data_get($this->model(), 'id')) {
            $this->form->put(admin()->url($this->route() . '/' . $model_id));
        } else {
            $this->form->post(admin()->url($this->route()));
        }
    }

    public function flex($flex = true)
    {
        $this->form->flex($flex);
        return $this;
    }

}
