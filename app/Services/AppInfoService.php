<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AppInfoService
{
    public function getAppInfo(string $appId): ?array
    {
        // Ruta de los archivos JSON simulados
        $appsFile = storage_path('app/source-api-outputs/app.json');
        $developersFile = storage_path('app/source-api-outputs/developer.json');

        // Verificar si los archivos existen
        if (!File::exists($appsFile) || !File::exists($developersFile)) {
            return null;
        }

        // Leer y decodificar JSON
        $apps = json_decode(File::get($appsFile), true);
        $developers = json_decode(File::get($developersFile), true);

        // Buscar la app por ID
        $app = collect($apps)->firstWhere('id', $appId);
        if (!$app) {
            return null;
        }

        // Buscar información del autor
        $author = collect($developers)->firstWhere('id', $app['developer_id']);

        // Convertir 'compatible' de array a string separado por '|'
        if (isset($app['compatible']) && is_array($app['compatible'])) {
            $app['compatible'] = implode('|', $app['compatible']);
        }

        // Construir respuesta
        return [
            'id' => $app['id'],
            'author_info' => [
                'name' => $author['name'] ?? 'Unknown',
                'url' => $author['url'] ?? null,
            ],
            'title' => $app['title'],
            'version' => $app['version'],
            'url' => $app['url'],
            'short_description' => $app['short_description'],
            'license' => $app['license'],
            'thumbnail' => $app['thumbnail'],
            'rating' => $app['rating'],
            'total_downloads' => $app['total_downloads'],
            'compatible' => $app['compatible'],
        ];
    }

}
