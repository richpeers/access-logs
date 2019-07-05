<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UploadCsvFormRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CsvUploadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param UploadCsvFormRequest $request
     * @return JsonResponse
     */
    public function __invoke(UploadCsvFormRequest $request)
    {
        $csvFile = $request->file('csv')->storeAs('temp', 'access-logs.csv', 'local');
    }
}
