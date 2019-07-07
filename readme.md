# Access Logs

Exercise in parsing a CSV file with PHP and displaying a paginated data table. With filters and ordering.

Pagination and filters request the data via AJAX for a JSON response.

Demo [https://access-logs.richpeers.co.uk]

[Download CSV with specified columns](https://access-logs.richpeers.co.uk/testdata.csv)

### CsvImport Service Class
Automatically detects the encoding of the CSV and converts it to UTF-8 for import.

Usage:
```
    public function __invoke(CsvImportFormRequest $request, CsvImport $csv)
    {
        $filePath = $request->file('csv')->getPathName();

        $csv->setDelimiter("\t")
            ->import($filePath)
            ->store(AccessLog::class, [
                'IP' => 'ip',
                'Response Type' => 'response_type',
                'Response Time' => 'response_time',
                'Country Of Origin' => 'country_of_origin',
                'Path' => 'path'
            ]);
    }
```

### Pagination and Filters
Filters extend abstract filter classes and build the query.

Passed to pagination and returned via a transformer to format and return JSON.
```
    public function __invoke(Request $request, AccessLog $accessLog)
    {
        $logs = $accessLog->filter($request)->paginate(10);

        return AccessLogResource::collection($logs);
    }
```
