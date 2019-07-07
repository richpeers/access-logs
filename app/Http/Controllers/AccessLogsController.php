<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccessLogsController extends Controller
{
    /**
     * @param Request $request
     * @param AccessLog $accessLog
     * @return View
     */
    public function __invoke(Request $request, AccessLog $accessLog)
    {
        return view('index');
    }
}
