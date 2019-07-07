<?php

namespace App\Services\CsvImport;

interface CsvImport
{
    public function setDelimiter(string $delimiter);

    public function import(string $path);

    public function store(string $model, array $columns);
}
