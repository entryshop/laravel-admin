<?php

namespace Entryshop\Admin\Components\Widgets;

use Entryshop\Admin\Components\Element;

/**
 * @method self icon($value = null)
 * @method self label($value = null)
 * @method self href($value = null)
 * @method self target($value = null)
 * @method self color($value = null)
 * @method self reload($value = null)
 * @method self action($value = null)
 * @method self method($value = null)
 * @method self confirm($value = null)
 * @method self dialog($value = null)
 * @method self dom($value = null)
 */
class Action extends Element
{
    public $view = 'admin::widgets.action';

    const DIALOG_SIZE_LG                 = 'lg';
    const DIALOG_SIZE_SM                 = 'sm';
    const DIALOG_SIZE_XL                 = 'xl';
    const DIALOG_SIZE_FULLSCREEN         = 'fullscreen';
    const DIALOG_SIZE_FULLSCREEN_SM_DOWN = 'fullscreen-sm-down';

    public function post($action = null)
    {
        $this->set('method', 'POST')
            ->set('action', $action);
        return $this;
    }

}
