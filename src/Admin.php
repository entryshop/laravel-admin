<?php

namespace Entryshop\Admin;

use Entryshop\Admin\Components\Layout;
use Entryshop\Admin\Components\Widgets\Container;
use Entryshop\Admin\Concerns\CanCallMethods;
use Entryshop\Admin\Concerns\HasAssets;
use Entryshop\Admin\Concerns\HasAttributes;
use Entryshop\Admin\Concerns\HasBrand;
use Entryshop\Admin\Concerns\HasRoutes;
use Entryshop\Admin\Concerns\HasToasts;
use Entryshop\Admin\Concerns\HasVariables;
use Entryshop\Admin\Concerns\InteractsWithEvents;

/**
 * @method self|string home($value = null) home page
 */
class Admin
{
    use CanCallMethods;
    use InteractsWithEvents;
    use HasVariables;
    use HasToasts;
    use HasRoutes;
    use HasAttributes;
    use HasAssets;
    use HasBrand;

    protected Layout $layout;

    public function __call($method, $parameters)
    {
        return $this->callHasVariables($method, $parameters);
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

    public function menus(array $menus)
    {
        $exist_menus = $this->layout()->menus() ?? [];
        $menus = array_merge($exist_menus, $menus);
        $this->layout()->menus($menus);
        return $this;
    }

    public function menu($menu, $append = true)
    {
        $menus = $this->layout()->menus() ?? [];

        if ($append) {
            $menus[] = $menu;
        } else {
            array_unshift($menus, $menu);
        }

        $this->layout()->menus($menus);
        return $this;
    }

    public function response($action)
    {
        return response()->json($action);
    }
}
