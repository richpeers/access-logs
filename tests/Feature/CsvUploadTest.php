<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CsvUploadTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUploadedCsvIsSavedToTempFolder()
    {
        Storage::fake('local');

        $response = $this->json('POST', '/api/access-logs/csv', [
            'csv' => UploadedFile::fake()->create('temp/testdata.csv', '2')
        ]);

        // Assert the file was stored
        Storage::disk('local')->assertExists('temp/access-logs.csv');

        $response->assertStatus(200);
    }
}
