<?php

namespace Entryshop\Admin\Http\Controllers;

use Entryshop\Admin\Components\Element;

class AuthController
{
    public function login()
    {
        $page = Element::make()->view('admin::pages.login');
        return admin()->layout()->guest()->child($page)->render();
    }

    public function submitLogin()
    {
        request()->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (auth('admin')->attempt([
            'username' => request('username'),
            'password' => request('password'),
        ])) {
            return redirect()->intended(admin()->home());
        }

        return back();
    }

    public function logout()
    {
        auth('admin')->logout();
        return back();
    }
}
