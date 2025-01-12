<?php

namespace Entryshop\Admin\Components\Widgets;

use Entryshop\Admin\Components\Element;
use Entryshop\Admin\Concerns\HasChildren;

class Container extends Element
{
    use HasChildren;

    public $view = 'admin::widgets.container';
}
