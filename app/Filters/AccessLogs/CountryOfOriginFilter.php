<?php

namespace App\Filters\AccessLogs;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class CountryOfOriginFilter extends FilterAbstract
{
    /**
     * Mappings for database values.
     *
     * @return array
     */
    public function mappings()
    {
        return [];
    }

    /**
     * Filter by course access type (free, premium).
     *
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function filter(Builder $builder, $value)
    {
        if ($value === null) {
            return $builder;
        }

        return $builder->where('country_of_origin', 'like', '%' . $value . '%');
    }

}
