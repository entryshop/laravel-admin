<?php

namespace Entryshop\Admin\Components\Form\Fields;

/**
 * @method self|string from($value = null) Table class
 * @method self|bool multiple($value = null) Support multiple selection
 */
class TableSelector extends Field
{
    public $view = 'admin::form.fields.table_selector';
}
