<?php

namespace Entryshop\Admin\Concerns;

use Entryshop\Admin\Http\Middlewares\ServeAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

trait HasRoutes
{
    protected static $canAccessUsing;

    public static function canAccessUsing(callable $canAccessUsing)
    {
        static::$canAccessUsing = $canAccessUsing;
    }

    public static function canAccess($user)
    {
        if (!static::$canAccessUsing) {
            return !app()->isProduction();
        }

        return call_user_func(static::$canAccessUsing, $user);
    }

    public function url($path)
    {
        if (Str::startsWith($path, '/')) {
            $path = Str::replaceFirst('/', '', $path);
        }
        return url(config('admin.prefix') . '/' . $path);
    }

    public function asset($path)
    {
        if (Str::isUrl($path)) {
            return $path;
        }

        if (Str::startsWith($path, '/')) {
            $path = Str::replaceFirst('/', '', $path);
        }

        return asset('/vendor/admin/' . $path);
    }

    public function group(...$args)
    {
        $params = [
            'prefix'     => config('admin.prefix'),
            'as'         => config('admin.as'),
            'middleware' => ['web', ServeAdmin::class],
        ];

        if (is_array($args[0])) {
            $params   = array_merge($params, $args[0]);
            $callback = $args[1];
        } else {
            $callback = $args[0];
        }
        Route::group($params, $callback);
    }

    public function getDefaultHome()
    {
        return $this->url('/');
    }

    public function getDefaultUsername()
    {
        return 'email';
    }

    public function getDefaultUsernameLabel()
    {
        return __('admin::auth.username');
    }

    public function getDefaultLoginUrl()
    {
        return route('admin.login');
    }
}
