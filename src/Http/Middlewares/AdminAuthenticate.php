<?php

namespace Entryshop\Admin\Http\Middlewares;

use Entryshop\Admin\Admin;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;

class AdminAuthenticate extends Authenticate
{
    protected function authenticate($request, array $guards)
    {
        $guards = ['admin'];

        parent::authenticate($request, $guards);

        if (!Admin::canAccess(auth()->user())) {
            abort(403);
        }
    }

    protected function redirectTo(Request $request)
    {
        return admin()->loginUrl();
    }
}
