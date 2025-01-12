<?php

namespace Entryshop\Admin\Components\Table;

use Entryshop\Admin\Components\Element;

/**
 * @method self|array models($value = null)
 * @method self|bool selectable($value = null)
 */
class Table extends Element
{
    public $view = 'admin::table.table';

    public function sortUrl($name)
    {
        $sort_type = request('sort_type');
        $sort_by   = request('sort_by');

        if ($sort_by === $name) {
            switch ($sort_type) {
                case 'desc':
                    $sort_type = 'asc';
                    break;
                case 'asc':
                    $sort_type = '';
                    $sort_by   = '';
                    break;
                default:
                    $sort_type = 'desc';
                    break;
            }
        } else {
            $sort_by   = $name;
            $sort_type = 'desc';
        }

        return request()->fullUrlWithQuery([
            'sort_by'   => $sort_by,
            'sort_type' => $sort_type,
        ]);
    }
}
