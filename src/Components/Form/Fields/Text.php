<?php

namespace Entryshop\Admin\Components\Form\Fields;

/**
 * @method self|string placeholder($value = null)
 * @method self|string nativeType($value = null)
 */
class Text extends Field
{
    public $view = 'admin::form.fields.text';

    public function getDefaultNativeType()
    {
        return 'text';
    }
}
