<?php

namespace Entryshop\Admin\Components\Widgets;

use Entryshop\Admin\Components\Element;

/**
 * @method self icon($value = null)
 * @method self label($value = null)
 * @method self href($value = null)
 * @method self target($value = null)
 * @method self color($value = null)
 * @method self form($value = null)
 * @method self reload($value = null)
 * @method self action($value = null)
 * @method self method($value = null)
 * @method self confirm($value = null)
 * @method self dom($value = null)
 */
class Action extends Element
{
    public $view = 'admin::widgets.action';

    public function button()
    {
        $this->dom('button');
        $this->withAttributes(['class' => 'btn btn-primary']);
        return $this;
    }

    public function post($action = null)
    {
        $this->set('method', 'POST')
            ->set('action', $action);
        return $this;
    }

    public function asLink()
    {
        $this->dom('a');
        return $this;
    }

    public function danger()
    {
        if ($this->dom() == 'button') {
            $this->withAttributes(['class' => 'btn-danger']);
        } else {
            $this->withAttributes(['class' => 'text-danger']);
        }
        return $this;
    }
}
