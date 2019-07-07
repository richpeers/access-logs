<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CsvImportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Services\CsvImport\CsvImport',
            'App\Services\CsvImport\CsvImportManager'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
