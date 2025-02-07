<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class DetectDuplicatesTest extends TestCase
{
    public function test_detect_duplicates_command()
    {
        // Crear archivos de prueba en la ubicación correcta
        $sourceFile = storage_path('app/data_dumps/source_publisher-url.csv');
        $catalogFile = storage_path('app/data_dumps/catalog_publisher-url.csv');
        $outputFile = storage_path('app/data_dumps/output_test.csv');

        // Crear el contenido de los archivos
        File::put($sourceFile, "1,http://example.com/app1\n2,http://example.com/app2");
        File::put($catalogFile, "http://example.com/app1\nhttp://example.com/app3");

        // Ejecutar el comando
        $this->artisan('detect:duplicates', [
            'sourceFile' => 'source_publisher-url.csv',
            'catalogFile' => 'catalog_publisher-url.csv',
            'outputFile' => 'output_test.csv'
        ])
        ->assertExitCode(0);

        // Verificar que el archivo de salida existe y contiene el resultado esperado
        $this->assertFileExists($outputFile);
        $outputContent = File::get($outputFile);
        $this->assertStringContainsString('2', $outputContent);
    }
}
