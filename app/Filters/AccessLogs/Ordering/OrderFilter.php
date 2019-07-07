<?php

namespace App\Filters\AccessLogs\Ordering;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends FilterAbstract
{
    /**
     * Mappings for database values.
     *
     * @return array
     */
    public function mappings()
    {
        return [
            'ip' => 'ip',
            'response_type' => 'response_type',
            'response_time' => 'response_time',
            'country_of_origin' => 'country_of_origin',
            'path' => 'path'
        ];
    }

    /**
     * Order by
     * @param Builder $builder
     * @param $value
     * @return Builder
     */
    public function filter(Builder $builder, $value)
    {
        $parts = explode(',', $value);
        $column = $this->resolveFilterValue($parts[0]);
        $direction = $this->resolveOrderDirection($parts[1]);

        return $builder->orderBy($column, $direction);
    }
}
