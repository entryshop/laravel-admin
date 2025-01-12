<?php

namespace Entryshop\Admin\Components;

use Entryshop\Admin\Components\Form\Fields;
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

    public static $availableFields = [
        'text'  => Fields\Text::class,
        'image' => Fields\Image::class,
    ];

    public function save($request = null)
    {
        $this->setupForm();
        $this->form()->validate($request);
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
        $original_form = $this->getOriginal('form');
        if ($original_form instanceof BaseForm) {
            $_form = $original_form;
        } else {
            $_form = BaseForm::make();
            $_form->flex(true);
            $_form->fields($this->fields());
            if ($model_id = data_get($this->model(), 'id')) {
                $_form->put(admin()->url($this->route() . '/' . $model_id));
            } else {
                $_form->post(admin()->url($this->route()));
            }
            $_form->model($this->model());
        }

        if (is_callable($original_form)) {
            call_user_func($original_form, $_form);
        }

        $this->form($_form);
    }

}
