<?php

namespace Entryshop\Admin\Concerns;

use Entryshop\Admin\Events\ResolvingAdmin;
use Entryshop\Admin\Events\ServingAdmin;
use Illuminate\Support\Facades\Event;

trait InteractsWithEvents
{
    public static function serving($callback)
    {
        Event::listen(ServingAdmin::class, $callback);
    }

    public static function resolving($callback)
    {
        Event::listen(ResolvingAdmin::class, $callback);
    }
}
