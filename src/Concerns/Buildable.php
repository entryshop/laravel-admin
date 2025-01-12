<?php

namespace Entryshop\Admin\Concerns;

use Closure;

trait Buildable
{
    protected $built = false;
    protected $builder;
    protected $buildingCallbacks = [];

    public function building(Closure $callback)
    {
        $this->buildingCallbacks[] = $callback;
        return $this;
    }

    public function callBuildingCallbacks()
    {
        if (!empty($this->buildingCallbacks)) {
            foreach ($this->buildingCallbacks as $callback) {
                call_user_func($callback, $this);
            }
        }
    }

    public function callBuilder($force = false)
    {
        if (!$this->built || $force) {
            $this->callBuildingCallbacks();
            if (is_callable($this->builder)) {
                call_user_func($this->builder, $this);
            }
        }

        $this->built = true;
    }
}
