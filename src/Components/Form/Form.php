<?php

namespace Entryshop\Admin\Components\Form;

use Entryshop\Admin\Components\Element;
use Entryshop\Admin\Components\Form\Fields\Field;
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
 * @method self|string submitButtonLabel($value = null)
 * @method self|string submitButtonColor($value = null)
 */
class Form extends Element
{
    public $view = 'admin::form.form';

    public static $availableFields = [
        'text'           => Fields\Text::class,
        'json'           => Fields\Json::class,
        'image'          => Fields\Image::class,
        'select'         => Fields\Select::class,
        'table_selector' => Fields\TableSelector::class,
    ];

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
        return '<button class="btn-submit btn btn-' . $this->get('submitButtonColor',
                'primary') . '">' . $this->get('submitButtonLabel', __('admin::base.submit')) . '</button>';
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

    public function submit()
    {
        $this->save();
        return $this->response();
    }

    public function handle()
    {
        $this->callMethods('setup');
        $this->validate();
        return $this->submit();
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

    public static function toFields(array $fields)
    {
        $result = [];

        foreach ($fields as $name => $field) {
            if (is_string($field)) {
                $field = [
                    'name' => $field,
                    'type' => 'text',
                ];
            }

            if (is_string($name)) {
                if (is_array($field)) {
                    $field['name'] = $name;
                }
            }

            if (is_array($field)) {
                $fieldClass = static::$availableFields[$field['type'] ?? 'text'];
                $field      = new $fieldClass($field);
            }

            if ($field instanceof Field) {
                $result[] = $field;
            }
        }

        return $result;
    }
}
