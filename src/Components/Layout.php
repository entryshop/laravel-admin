<?php

namespace Entryshop\Admin\Components;

use Entryshop\Admin\Components\Widgets\Menu;
use Entryshop\Admin\Concerns\HasChildren;

/**
 * @method self|string title($value = null)
 * @method self|string back($value = null)
 * @method self|array menus($value = null)
 */
class Layout extends Element
{
    use HasChildren;

    public $view = 'admin::layouts.app';

    public function guest($as_guest = true)
    {
        if ($as_guest) {
            $this->view = 'admin::layouts.guest';
        } else {
            $this->view = 'admin::layouts.app';
        }
        return $this;
    }

    public function getDefaultUserMenus()
    {
        return [
            Menu::make('logout', 'Logout')->link(route('admin.logout'))->icon('ri-logout-box-r-line'),
        ];
    }
}
