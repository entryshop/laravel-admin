<?php

namespace Entryshop\Admin\Components\Form\Fields;

use Illuminate\Support\Facades\Storage;

/**
 * @method self|string placeholder($value = null)
 */
class File extends Field
{
    public $view = 'admin::form.fields.file';

    public function getValueFromRequest($request = null)
    {
        $request = $request ?: request();

        if (!empty($request->get($this->name() . '_remove'))) {
            return '';
        } elseif ($request->hasFile($this->name())) {
            return Storage::url($request->file($this->name())->store('images'));
        }

        return $this->value();
    }
}
