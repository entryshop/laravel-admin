<?php

namespace Entryshop\Admin\Components\Form\Fields;

use Entryshop\Admin\Components\Cell;

/**
 * @method static|array rules($value = null)
 * @method static|array readonly($value = null)
 */
abstract class Field extends Cell
{
    public function getValueFromRequest($request = null)
    {
        $request = $request ?: request();
        return $request->get($this->name());
    }
}
