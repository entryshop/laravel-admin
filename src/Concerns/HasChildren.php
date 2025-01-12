<?php

namespace Entryshop\Admin\Concerns;

trait HasChildren
{
    public $children = [];

    public function child($value)
    {
        $this->children[] = $value;
        return $this;
    }

    public function children($children = null)
    {
        if ($children === null) {
            return $this->children;
        }

        $this->children = $children;
        return $this;
    }
}
