<?php

namespace App\Http\Controllers\Api;

use App\Models\AccessLog;
use App\Http\Controllers\Controller;
use App\Services\CsvImport\CsvImport;
use App\Http\Requests\CsvImportFormRequest;

class CsvImportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param CsvImportFormRequest $request
     * @param CsvImport $csv
     * @return void
     */
    public function __invoke(CsvImportFormRequest $request, CsvImport $csv)
    {
        $filePath = $request->file('csv')->getPathName();

        $data = $csv->setDelimiter("\t")
            ->import($filePath)
            ->store(AccessLog::class, [
                'IP' => 'ip',
                'Response Type' => 'response_type',
                'Response Time' => 'response_time',
                'Country Of Origin' => 'country_of_origin',
                'Path' => 'path'
            ]);

        return response()->json([
            'count' => count($data)
        ], 200);
    }
}
