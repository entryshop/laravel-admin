<?php

namespace Entryshop\Admin\Components;

use Illuminate\Support\Str;

/**
 * @method static|string name($value = null)
 * @method static|string label($value = null)
 * @method static|mixed model($value = null)
 * @method static|mixed value($value = null)
 * @method static|bool full($value = null)
 */
class Cell extends Element
{
    public function __construct(...$args)
    {
        if (isset($args[0]) && is_string($args[0])) {
            $this->set('name', $args[0]);
        }

        if (isset($args[1]) && is_string($args[1])) {
            $this->set('label', $args[1]);
        }

        parent::__construct(...$args);
    }

    public function getDefaultLabel()
    {
        return Str::of($this->name())->snake()->replace('_', ' ')->ucfirst();
    }

    public function getDefaultValue()
    {
        return data_get($this->model(), $this->name());
    }
}
