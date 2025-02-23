<?php

namespace Entryshop\Admin\Http\Controllers;

class IndexController
{
    public function __invoke()
    {
        if (admin()->home() !== admin()->url('/')) {
            return redirect(admin()->home());
        }
        return admin()->layout()->child("Welcome to " . admin()->name());
    }

}
