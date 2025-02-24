<?php

namespace Entryshop\Admin\Components\Widgets;

use Entryshop\Admin\Components\Grid;

class TableSelector extends Grid
{
    public $view = 'admin::widgets.table_selector';

    public function setupTableSelector()
    {
        $this->perPage(10);
        $this->selectable(true);
    }
}
