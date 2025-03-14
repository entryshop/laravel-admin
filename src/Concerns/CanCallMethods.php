<?php

namespace Entryshop\Admin\Concerns;

use Illuminate\Support\Str;

trait CanCallMethods
{
    public function callMethods($startWith, $endWith = '', ...$args)
    {
        $self = static::class;

        $endWith = Str::studly($endWith);
        $methods = array_filter(get_class_methods($self), function ($method) use ($startWith, $endWith) {
            return (Str::startsWith($method, $startWith) || empty($startWith)) && (Str::endsWith($method, $endWith) || empty($endWith));
        });

        foreach ($methods as $method) {
            $this->$method(...$args);
        }
    }
}
