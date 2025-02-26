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

    public function email()
    {
        return $this->nativeType('email');
    }

    public function password()
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
        return bcrypt($request->get($this->name()));
    }
}
