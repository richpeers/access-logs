<?php

namespace App\Filters\AccessLogs;

use App\Filters\AccessLogs\Ordering\OrderFilter;
use App\Filters\FiltersAbstract;

class AccessLogFilters extends FiltersAbstract
{
    /**
     * Default filters.
     * @var array
     */
    protected $filters = [
        'ip' => IpFilter::class,
        'response_type' => ResponseTypeFilter::class,
        'response_time_greater_than' => ResponseTimeGreaterThanFilter::class,
        'response_time_less_than' => ResponseTimeLessThanFilter::class,
        'country_of_origin' => CountryOfOriginFilter::class,
        'path' => PathFilter::class,
        'order' => OrderFilter::class
    ];

    /**
     * Mappings for course filter values.
     *
     * @return array
     */
    public static function mappings()
    {
        $map = [

        ];

        return $map;
    }
}
