<?php

namespace Entryshop\Admin;

use Entryshop\Admin\Components\Layout;
use Entryshop\Admin\Components\Widgets\Container;
use Entryshop\Admin\Concerns\HasToasts;
use Entryshop\Admin\Concerns\HasVariables;
use Entryshop\Admin\Concerns\InteractsWithEvents;
use Entryshop\Admin\Http\Controllers\AuthController;
use Entryshop\Admin\Http\Controllers\FormSubmitController;
use Entryshop\Admin\Http\Controllers\RenderElementController;
use Entryshop\Admin\Http\Middlewares\ServeAdmin;
use Route;
use Str;

/**
 * @method self|string home($value = null) home page
 */
class Admin
{
    use InteractsWithEvents;
    use HasVariables;
    use HasToasts;

    protected Layout $layout;

    public function __call($method, $parameters)
    {
        return $this->callHasVariables($method, $parameters);
    }

    public function getDefaultHome()
    {
        return $this->url('/');
    }

    public function getDefaultUsername()
    {
        return 'username';
    }

    public function getDefaultUsernameLabel()
    {
        return __('admin::auth.username');
    }

    public function url($path)
    {
        if (Str::startsWith($path, '/')) {
            $path = Str::replaceFirst('/', '', $path);
        }
        return url(config('admin.prefix') . '/' . $path);
    }

    public function container($element = null, $attributes = [])
    {
        $container = Container::make();
        $container->withAttributes($attributes);
        if (!empty($element)) {
            $container->child($element);
        }
        return $container;
    }

    public function layout()
    {
        if (empty($this->layout)) {
            $this->layout = Layout::make();
        }
        return $this->layout;
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
            'middleware' => [ServeAdmin::class],
        ];
        if (is_array($args[0])) {
            $params   = array_merge($params, $args[0]);
            $callback = $args[1];
        } else {
            $callback = $args[0];
        }
        Route::group($params, $callback);
    }

    public function routes($auth = true, $api = true)
    {
        if ($api) {
            Route::post('render-element', RenderElementController::class)->name('admin.api.render.element');
            Route::post('form-submit', FormSubmitController::class)->name('admin.api.form.submit');
        }

        if ($auth) {
            Route::get('login', [AuthController::class, 'login'])->name('login');
            Route::post('login', [AuthController::class, 'submitLogin'])->name('admin.login.submit');
            Route::any('logout', [AuthController::class, 'logout'])->name('admin.logout');
        }
    }

    public function response($action)
    {
        return response()->json($action);
    }
}
