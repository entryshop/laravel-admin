<?php

namespace Entryshop\Admin\Http\Controllers;

use Entryshop\Admin\Components\Widgets\Ajax;

class RenderElementController
{
    public function __invoke()
    {
        $element    = request('element');
        $payload    = request('payload');
        $renderable = app($element);
        $renderable->payload($payload ?? []);
        $container = Ajax::make();
        $container->child($renderable);
        return $container->render();
    }
}
