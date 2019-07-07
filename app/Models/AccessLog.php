<?php

namespace App\Models;

use App\Filters\AccessLogs\AccessLogFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AccessLog extends Model
{
    protected $table = 'access_logs';

    protected $fillable = [
        'ip',
        'response_type',
        'response_time',
        'country_of_origin',
        'path'
    ];

    public $timestamps = false;

    public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    {
        return (new AccessLogFilters($request))->add($filters)->filter($builder);
    }
}
