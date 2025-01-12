<?php

namespace Entryshop\Admin\Components\Widgets;

use Entryshop\Admin\Components\Element;
use Entryshop\Admin\Concerns\LazyLoad;

/**
 * @method self button($value = null)
 * @method self title($value = null)
 * @method self dialog($value = null)
 */
class Modal extends Element
{
    use LazyLoad;

    public $view = 'admin::widgets.modal';
}
