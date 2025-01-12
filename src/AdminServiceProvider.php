<?php

namespace Entryshop\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/admin.php', 'admin');
        $this->app->scoped(Admin::class);
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'admin');
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../resources/assets' => public_path('vendor/admin')], 'admin-assets');
        }
    }
}
