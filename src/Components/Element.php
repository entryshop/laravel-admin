<?php

namespace Entryshop\Admin\Components;

use Entryshop\Admin\Concerns\CanCallMethods;
use Entryshop\Admin\Concerns\HasAttributes;
use Entryshop\Admin\Concerns\HasVariables;
use Entryshop\Admin\Concerns\Makeable;
use Illuminate\Support\Traits\Tappable;

/**
 * @method self display($value = null)
 * @method self|string id($value = null)
 * @method self|string scripts($value = null)
 * @method self|string styles($value = null)
 * @method self|string view($value = null)
 */
class Element
{
    use Makeable;
    use CanCallMethods;
    use HasVariables;
    use Tappable;
    use HasAttributes;

    private $_id;
    public $view = '';

    public function __construct(...$args)
    {
        if (array_is_list($args) === false) {
            foreach ($args as $key => $value) {
                $this->set($key, $value);
            }
        }

        if (isset($args[0]) && is_array($args[0])) {
            $this->set($args[0]);
        }

        $this->callMethods('register');
        $this->callMethods('boot');
    }

    public function __call($method, $parameters)
    {
        return $this->callHasVariables($method, $parameters);
    }

    public function class($value = null)
    {
        return $this->withAttributes(['class' => $value]);
    }

    public function getDefaultId()
    {
        if (empty($this->_id)) {
            $this->_id = 'element_' . uniqid();
        }
        return $this->_id;
    }

    public function render()
    {
        $this->callMethods('setup');

        if ($display = $this->get('display')) {
            if (is_callable($display)) {
                return call_user_func($display, $this);
            }
            return $display;
        }

        return view($this->get('view', $this->view), [
            '_this' => $this,
        ]);
    }
}
