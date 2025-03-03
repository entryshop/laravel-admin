<?php

namespace Entryshop\Admin\Components\Widgets;

use Entryshop\Admin\Components\Grid;

/**
 * @method self|bool multiple(bool $value = null)
 */
class TableSelector extends Grid
{
    public $view = 'admin::widgets.table_selector';

    public function setupTableSelector()
    {
        $this->selectable(true);
    }
}
