<?php

namespace Entryshop\Admin\Http\Controllers;

use Entryshop\Admin\Components\Element;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function login()
    {
        $page = Element::make()->view('admin::pages.login');
        return admin()->layout()->guest()->child($page)->render();
    }

    public function submitLogin()
    {
        $username = admin()->username();

        request()->validate([
            $username  => 'required',
            'password' => 'required',
        ]);

        if (auth('admin')->attempt(request()->only($username, 'password'))) {
            return redirect()->intended(admin()->home());
        }

        throw ValidationException::withMessages([
            $username => __('admin::auth.failed'),
        ]);
    }

    public function logout()
    {
        auth('admin')->logout();
        return back();
    }
}
