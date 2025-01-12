<?php

namespace Entryshop\Admin\Components\Filters;

class Text extends Filter
{
    public function getDefaultOperators()
    {
        return [
            [
                'name'  => 'equals',
                'label' => '等于',
            ],
            [
                'name'  => 'not_equals',
                'label' => '不等于',
            ],
            [
                'name'  => 'contains',
                'label' => '包含',
            ],
            [
                'name'  => 'not_contains',
                'label' => '不包含',
            ],
            [
                'name'  => 'start_with',
                'label' => '以...开头',
            ],
            [
                'name'  => 'end_with',
                'label' => '以...结尾',
            ],
            [
                'name'  => 'empty',
                'label' => '为空',
            ],
            [
                'name'  => 'not_empty',
                'label' => '不为空',
            ],
        ];
    }

    public function apply($models, $query)
    {
        $field = $query['field'];
        switch ($query['operator']) {
            case 'equals':
                return $models->where($field, $query['value']);
            case 'start_with':
                return $models->where($field, 'like', "{$query['value']}%");
            case 'end_with':
                return $models->where($field, 'like', "%{$query['value']}");
            case 'contains':
                return $models->where($field, 'like', "%{$query['value']}%");
            case 'not_equals':
                return $models->where($field, '!=', $query['value']);
            case 'not_contains':
                return $models->where($field, 'not like', "%{$query['value']}%");
            case 'empty':
                return $models->whereNull($field);
            case 'not_empty':
                return $models->whereNotNull($field);
            default:
                break;
        }
        return $models;
    }

}
