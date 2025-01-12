<?php

namespace Entryshop\Admin\Concerns;

use Illuminate\View\ComponentAttributeBag;

trait HasAttributes
{
    /**
     * @var ComponentAttributeBag
     */
    public $attributes;

    public function withAttributes(array $attributes)
    {
        $this->attributes = $this->getAttributes()->merge($attributes);
        return $this;
    }

    public function getAttributes(): ComponentAttributeBag
    {
        if (empty($this->attributes)) {
            $this->attributes = new ComponentAttributeBag();
        }
        return $this->attributes;
    }
}
