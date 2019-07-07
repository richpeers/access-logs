<?php

namespace App\Services\CsvImport;

use voku\helper\UTF8;

/**
 * Class CsvImportManager
 * @package App\Services\CsvImport
 */
class CsvImportManager implements CsvImport
{
    protected $filePath;
    protected $delimiter = ',';
    protected $columns = [];

    /**
     * Set the csv delimiter
     *
     * @param string $delimiter
     * @return $this
     */
    public function setDelimiter(string $delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * Prepare for parsing
     *
     * @param string $path
     * @return $this
     */
    public function import(string $path)
    {
        $this->path = $this->convertNoneUTF8($path);

        return $this;
    }

    /**
     * Store the contents to the database
     * Using the array mapping headers to database columns
     *
     * @param string $model
     * @param array $columns
     * @return array
     * @throws CsvImportException
     */
    public function store(string $model, array $columns)
    {
        $this->columns = $columns;

        $model = new $model;

        $data = $this->getArray();

        $model->truncate();

        foreach ($data as $row) {
            $model->create($row);
        }

        return $data;
    }

    /**
     * Convert none UTF-8 encoded content to UTF-8
     */
    protected function convertNoneUTF8($path)
    {
        $fileContents = \file_get_contents($path);

        // Determine the file's encoding
        $encoding = UTF8::str_detect_encoding($fileContents);

        if ($encoding === 'UTF-8') {
            return $path;
        }

        // Open file for overwriting with UTF-8 encoded content
        $file = \fopen($path, 'w');

        // Encode content to UTF-8
        $utf8Contents = UTF8::encode('UTF-8', $fileContents);

        $utf8Contents = UTF8::remove_bom($utf8Contents);

        // Overwrite the original file
        \fwrite($file, $utf8Contents);

        return $path;
    }

    /**
     * Parse the file contents to an array
     * Returns associative array for database insert
     *
     * @return array
     * @throws CsvImportException
     */
    protected function getArray()
    {
        $data = [];
        $header = null;

        // Open the file
        if (($file = \fopen($this->path, 'r')) !== false) {

            // Iterate each row of the csv file
            while (($row = \fgetcsv($file, 1000, \nl2br($this->delimiter))) !== false) {

                // If $header still null, it is the first row
                if (!$header) {
                    // Check headers match, and replace with database column names
                    $header = $this->headersToDatabaseColumns($row);
//                    $header = $row;
                } else {
                    // Build associative array
                    $data[] = \array_combine($header, $row);
                }
            }

            \fclose($file);
        }

        return $data;
    }

    /**
     * Maps the csv headers to database columns
     *
     * @param $row
     * @return mixed
     * @throws CsvImportException
     */
    protected function headersToDatabaseColumns($row)
    {
        foreach ($row as $key => $csvHeader) {
            // trim whitespace
            $csvHeader = \trim($csvHeader);
            if (false === $csvHeader) {
                throw new Exception('Input string could not be converted.');
            }
            // check column headers match
            if (!isset($this->columns[$csvHeader])) {
                throw new CsvImportException('CSV column headers must match: ' . $csvHeader);
            }

            // replace the csv header with the database column
            $row[$key] = $this->columns[$csvHeader];
        }

        return $row;
    }
}
