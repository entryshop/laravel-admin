<?php

namespace Entryshop\Admin\Components\Form\Fields;

/**
 * @method self|string placeholder($value = null)
 */
class Json extends Field
{
    public $view = 'admin::form.fields.json';

    public function getValueFromRequest($request = null)
    {
        $value = parent::getValueFromRequest($request);
        return to_json($value);
    }

    public function setupJson()
    {
        admin()->js('https://cdn.jsdelivr.net/npm/jsoneditor@10.2.0/dist/jsoneditor-minimalist.min.js');
        admin()->css('https://cdn.jsdelivr.net/npm/jsoneditor@10.2.0/dist/jsoneditor.min.css');
    }
}
