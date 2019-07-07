# Access Logs

Exercise in parsing a CSV file with PHP and displaying a paginated datatable. With filters and ordering.

Pagination and filters, when applied, query the data via ajax for json response.

Demo [https://access-logs.richpeers.co.uk]

[Download .csv with specified columns](https://access-logs.richpeers.co.uk/testdata.csv)

### CSV Import Service Class
Automatically detects the encoding of the csv and converts it to UTF-8 for import.

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

### Pagination and filters
Filters extend abstract filter classes and build the query.

Passed to pagination and returned via a transformer to format and return the json.
```
    public function __invoke(Request $request, AccessLog $accessLog)
    {
        $accessLogs = $accessLog->filter($request)->paginate(10);

        return AccessLogResource::collection($accessLogs);
    }
```
