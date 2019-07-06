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
     * test uploaded csv is saved to temp folder.
     *
     * @return void
     */
    public function testUploadedCsvIsSavedToTempFolder()
    {
        Storage::fake('local');

        $response = $this->json('POST', '/api/access-logs/csv', [
            'csv' => $file = UploadedFile::fake()->create('temp/testdata.csv', '2')
        ]);

        // Assert the file was stored
        Storage::disk('local')->assertExists('temp/' . $file->hashName());

        $response->assertStatus(200);
    }

    /**
     * test csv required validation.
     *
     * @return void
     */
    public function testCsvRequiredValidation()
    {
        // submit the form without the csv field
        $response = $this->json('POST', '/api/access-logs/csv', []);

        // assert validation fails
        $response->assertStatus(422);

        $response->assertJsonFragment([
            'csv' => ['The csv field is required.']
        ]);
    }

    /**
     * test csv must be a file validation.
     *
     * @return void
     */
    public function testCsvMustBeAfileValidation()
    {
        // submit the form with csv field as text
        $response = $this->json('POST', '/api/access-logs/csv', [
            'csv' => 'this is text, not a file'
        ]);

        // assert validation fails
        $response->assertStatus(422);

        $response->assertJsonFragment([
            'csv' => ['The csv must be a file.']
        ]);
    }

    /**
     * test csv must be correct mime type
     *
     * @return void
     */
    public function testCsvMustBeCorrectMimeType()
    {
        $response = $this->json('POST', '/api/access-logs/csv', [
            'csv' => UploadedFile::fake()->create('temp/testdata.pdf', '2')
        ]);

        // assert validation fails
        $response->assertStatus(422);

        $response->assertJsonFragment([
            'csv' => ['The csv must be a file of type: csv, txt.']
        ]);
    }

    /**
     * test csv must not be greater than 5000 kilobytes.
     *
     * @return void
     */
    public function testCsvMustNotBeGreaterThan5000Kilobytes()
    {
        $response = $this->json('POST', '/api/access-logs/csv', [
            'csv' => UploadedFile::fake()->create('temp/testdata.csv', '5001')
        ]);

        // assert validation fails
        $response->assertStatus(422);

        $response->assertJsonFragment([
            'csv' => ['The csv may not be greater than 5000 kilobytes.']
        ]);
    }
}
