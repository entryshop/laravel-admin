<?php

namespace Entryshop\Admin\Components\Form;

use Entryshop\Admin\Components\Element;
use Illuminate\Database\Eloquent\Model;

/**
 * @method self|array fields($value = null)
 * @method self|string action($value = null)
 * @method self|string flex($value = null)
 * @method self|string row($value = null)
 * @method self|string method($value = null)
 * @method self|Model model($value = null)
 * @method self|boolean hideLabel($value = null)
 * @method self|bool ajax($value = null)
 * @method self|bool hideSubmitButton($value = null)
 */
class Form extends Element
{
    public $view = 'admin::form.form';

    public function getDefaultMethod()
    {
        return 'post';
    }

    public function put($action = null)
    {
        return $this->method('put')->action($action);
    }

    public function post($action = null)
    {
        return $this->method('post')->action($action);
    }

    public function getDefaultAction()
    {
        return route('admin.api.form.submit', array_merge([
            '_form' => get_class($this),
        ], $this->get('payload', [])));
    }

    public function getDefaultSubmitButton()
    {
        return '<button class="btn btn-primary">' . __('admin::base.submit') . '</button>';
    }

    public function validate($request = null)
    {
        $request = $request ?: request();
        $fields  = $this->fields() ?? [];
        $rules   = [];

        foreach ($fields as $field) {
            if ($rule = $field->get('rules', null)) {
                $rules[$field->name()] = $rule;
            }
        }

        if (!empty($rules)) {
            $request->validate($rules);
        }
    }

    public function save()
    {
        if ($model = $this->model()) {
            foreach ($this->fields() ?? [] as $field) {
                $model->{$field->name()} = $field->getValueFromRequest();
            }
            $model->save();
            return $model;
        }
        return null;
    }

    public function handle()
    {
        $this->callMethods('setup');
        $this->validate();
        $this->save();
        return $this->response();
    }

    public function response()
    {
        return back();
    }

    public function plain()
    {
        return $this->method('get')
            ->action('')
            ->flex(true)
            ->hideLabel(true)
            ->hideSubmitButton(true);
    }
}
