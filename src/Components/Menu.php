<?php

namespace Entryshop\Admin\Components;

use Entryshop\Admin\Concerns\HasChildren;

/**
 * @method self|string link($value = null)
 * @method self|string icon($value = null)
 */
class Menu extends Cell
{
    use HasChildren;

    public $view = 'admin::menu';
}
