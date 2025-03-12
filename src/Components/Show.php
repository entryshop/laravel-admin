<?php

namespace Entryshop\Admin\Components;

use Entryshop\Admin\Concerns\HasChildren;
use Illuminate\Database\Eloquent\Model;

/**
 * @method self|array details($value = null)
 * @method self|array actions($value = null)
 * @method self|Model model($value = null)
 */
class Show extends Element
{
    use HasChildren;

    public $view = 'admin::show';
}
