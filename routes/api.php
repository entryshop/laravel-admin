<?php

use Entryshop\Admin\Components\Form\Form;
use Entryshop\Admin\Components\Widgets\Ajax;

admin()->group(function () {
    Route::post('render-element', function () {
        $element    = request('element');
        $payload    = request('payload');
        $renderable = app($element);
        $renderable->payload($payload ?? []);
        $container = Ajax::make();
        $container->child($renderable);
        return $container->render();
    })->name('admin.api.render.element');

    Route::post('form-submit', function () {
        $form = request('_form');
        $form = app($form)->payload(request()->all());
        if ($form instanceof Form) {
            return $form->handle();
        }
        return 'content not found';
    })->name('admin.api.form.submit');
});

