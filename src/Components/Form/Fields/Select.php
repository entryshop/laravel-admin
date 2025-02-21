<?php

namespace Entryshop\Admin\Components\Form\Fields;

use Entryshop\Admin\Components\Concerns\Refreshable;

/**
 * @method self|array options($value = null)
 */
class Select extends Field
{
    use Refreshable;

    public $view = 'admin::form.fields.select';

    public function getDefaultNullable()
    {
        return true;
    }
}
