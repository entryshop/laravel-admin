<?php

namespace Entryshop\Admin\Http\Controllers;

use Entryshop\Admin\Components\Form\Form;

class FormSubmitController
{
    public function __invoke()
    {
        $form = request('_form');
        $form = app($form)->payload(request()->all());
        if ($form instanceof Form) {
            return $form->handle();
        }
        return 'content not found';
    }
}
