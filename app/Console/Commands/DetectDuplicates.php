<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DetectDuplicates extends Command
{
    protected $signature = 'detect:duplicates {sourceFile} {catalogFile} {outputFile}';
    protected $description = 'Detect duplicates based on publisher_url similarity and generate an output file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Actualizamos las rutas de los archivos
        $sourceFile = storage_path('app/data_dumps/' . $this->argument('sourceFile'));
        $catalogFile = storage_path('app/data_dumps/' . $this->argument('catalogFile'));
        $outputFile = storage_path('app/data_dumps/' . $this->argument('outputFile'));

        // Verificar si los archivos existen
        if (!File::exists($sourceFile) || !File::exists($catalogFile)) {
            $this->error('One or more input files do not exist.');
            return;
        }

        // Llamamos al script de Python para hacer la comparación
        $this->info('Comparing publisher URLs...');
        $this->compareWithPythonScript($sourceFile, $catalogFile, $outputFile);

        $this->info('Duplicate detection complete.');
    }

    private function compareWithPythonScript($sourceFile, $catalogFile, $outputFile)
    {
        // Ejecutar el script en Python
        $command = "python3 " . base_path('scripts/compare_duplicates.py') . " $sourceFile $catalogFile $outputFile";
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->error('Error executing Python script.');
        } else {
            $this->info("Output saved to $outputFile");
        }
    }
}
