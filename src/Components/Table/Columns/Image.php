<?php

namespace Entryshop\Admin\Components\Table\Columns;

/**
 * @method self|number size($value = null)
 * @method self|number width($value = null)
 * @method self|number height($value = null)
 */
class Image extends Column
{
    public $view = 'admin::table.columns.image';

    public function render()
    {
        if ($size = $this->get('size')) {
            $this->set('width', $size)->set('height', $size);
        }

        if ($this->width()) {
            $this->withAttributes(['width' => $this->width()]);
        }

        if ($this->height()) {
            $this->withAttributes(['height' => $this->height()]);
        }

        return parent::render();
    }
}
