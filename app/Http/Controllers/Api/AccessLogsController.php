<?php

namespace App\Http\Controllers\Api;

use App\Models\AccessLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccessLog as AccessLogResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AccessLogsController extends Controller
{

    /**
     * @param Request $request
     * @param AccessLog $accessLog
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request, AccessLog $accessLog)
    {
        $logs = $accessLog->filter($request)->paginate(10);

        return AccessLogResource::collection($logs);
    }
}
