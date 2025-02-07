<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DetectDuplicatesCommand extends Command
{
    protected $signature = 'detect:duplicates';
    protected $description = 'Detectar y listar los programas no duplicados en el catálogo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Ruta del script en el contenedor
        $scriptPath = base_path('scripts/compare_urls.sh');

        // Ejecutamos el script Bash desde el contenedor
        $this->info('Ejecutando comparación de URLs...');

        // Usamos el contenedor de Sail para ejecutar el script
        $output = shell_exec("bash $scriptPath");

        // Mostrar el resultado
        $this->info($output);
    }
}
