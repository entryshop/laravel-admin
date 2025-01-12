<?php

namespace Entryshop\Admin\Components\Filters;

use Entryshop\Admin\Components\Cell;

class Filter extends Cell
{
    public function apply($models, $query)
    {
        return $models->where($query['field'], $query['value']);
    }
}
