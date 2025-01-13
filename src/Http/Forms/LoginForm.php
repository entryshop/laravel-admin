<?php

namespace Entryshop\Admin\Http\Forms;

use Entryshop\Admin\Components\Form\Fields;
use Entryshop\Admin\Components\Form\Form;

class LoginForm extends Form
{
    public function setupFields()
    {
        $this->fields([
            Fields\Text::make('username', __('admin::auth.username'))->rules('required'),
            Fields\Text::make('password', __('admin::auth.password'))->rules('required')
                ->nativeType('password'),
        ]);
    }

    public function handle()
    {
        $this->setupFields();
        $this->validate();

        if (auth('admin')->attempt([
            'username' => request('username'),
            'password' => request('password'),
        ])) {
            return redirect()->intended('/admin/users');
        }

        return back();
    }
}
