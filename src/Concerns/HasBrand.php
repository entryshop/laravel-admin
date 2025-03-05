<?php

namespace Entryshop\Admin\Concerns;

/**
 * @method self|string name($value = null) Application name
 * @method self|string logo($value = null) Application logo url
 * @method self|string miniLogo($value = null) Application short logo url
 * @method self|string favicon($value = null) Application fav icon url
 */
trait HasBrand
{

    public function getDefaultName()
    {
        return config('app.name');
    }

    public function getDefaultLogo()
    {
        return admin()->asset('images/logo-dark.png');
    }

    public function getDefaultMiniLogo()
    {
        return admin()->asset('images/logo-dark-sm.png');
    }
}
