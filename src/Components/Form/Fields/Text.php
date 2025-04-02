<?php

namespace Entryshop\Admin\Components\Form\Fields;

use Illuminate\Support\Facades\Hash;

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

    public function email()
    {
        return $this->nativeType('email');
    }

    public function password($value = true)
    {
        $this->set('require_hash', true);
        return $this->nativeType('password');
    }

    public function getValueFromRequest($request = null)
    {
        $request = $request ?: request();

        if (!$this->get('require_hash', false)) {
            return parent::getValueFromRequest($request);
        }

        $value = $request->get($this->name());

        // check if need hash
        if (!Hash::isHashed($value)) {
            return bcrypt($value);
        }

        return $value;
    }
}
