<?php

namespace Entryshop\Admin\Http\Middlewares;

use Entryshop\Admin\Events\ServingAdmin;

class ServeAdmin
{
    public function handle($request, $next)
    {
        ServingAdmin::dispatch($request);
        return $next($request);
    }
}
