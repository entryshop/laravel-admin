<?php

namespace Entryshop\Admin\Components\Filters;

use Carbon\Carbon;

class Date extends Filter
{
    public function getDefaultOperators()
    {
        return [
            [
                'name'  => 'before',
                'label' => '早于',
            ],
            [
                'name'  => 'after',
                'label' => '晚于',
            ],
            [
                'name'  => 'between',
                'label' => '范围内',
            ],
        ];
    }

    public function apply($models, $query)
    {
        $field = $query['field'];
        switch ($query['operator']) {
            case 'before':
                return $models->where($field, '<', Carbon::parse($query['value']));
            case 'after':
                return $models->where($field, '>', Carbon::parse($query['value']));
            case 'between':
                $dates = explode(',', $query['value']);
                $from  = Carbon::parse($dates[0]);
                $to    = Carbon::parse($dates[1]);
                return $models->where(function ($query) use ($field, $from, $to) {
                    $query->where($field, '>=', $from)->where($field, '<=', $to);
                });
            default:
                break;
        }
        return $models;
    }
}
