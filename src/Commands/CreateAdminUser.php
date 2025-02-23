<?php

namespace EntryShop\Admin\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:user';
    protected $description = 'Create admin user';

    public function handle()
    {
        $name     = $this->ask('Name');
        $email    = $this->ask('Email address');
        $password = $this->ask('Password');

        $user = config('admin.auth.providers.admin_users.model')::create([
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::make($password),
        ]);
        $this->info('Create user success:' . $user->id);
    }
}
