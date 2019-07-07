# Access Logs

Excercise in parsing CSV and displaying in paginated datatable, with filters.

Pagination and filters when applied, query the data using ajax to return json formatted response.

Demo [https://access-logs.richpeers.co.uk]

[Download .csv with specified columns](https://access-logs.richpeers.co.uk/testdata.csv)

##### CSV Import Service Class
Automatically detects the encoding of the csv and converts it to UTF-8 for import.

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

##### Pagination and filters
Pagination and filters call classes extending abstract filter classes, and passed through a transformer AccessLogResource to format and return the json. 
```
public function __invoke(Request $request, AccessLog $accessLog)
    {
        $accessLogs = $accessLog->filter($request)->paginate(10);

        return AccessLogResource::collection($accessLogs);
    }
```
