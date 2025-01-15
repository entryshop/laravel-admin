<?php

namespace Entryshop\Admin;

use Entryshop\Admin\Components\Layout;
use Entryshop\Admin\Components\Widgets\Container;
use Entryshop\Admin\Concerns\HasVariables;
use Entryshop\Admin\Concerns\InteractsWithEvents;
use Route;
use Str;

/**
 * @method self|string home($value = null) home page
 */
class Admin
{
    use InteractsWithEvents;
    use HasVariables;

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
        $params = ['prefix' => config('admin.prefix'), 'middleware' => 'web'];
        if (is_array($args[0])) {
            $params   = array_merge($params, $args[0]);
            $callback = $args[1];
        } else {
            $callback = $args[0];
        }
        Route::group($params, $callback);
    }

    public function response($action)
    {
        return response()->json($action);
    }
}
