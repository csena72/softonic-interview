<?php

namespace Tests\Feature;

use App\Services\AppInfoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class AppInfoServiceTest extends TestCase
{
    public function test_get_app_info_success()
    {
        // Simulamos la existencia de los archivos JSON
        File::shouldReceive('exists')
            ->with(storage_path('app/source-api-outputs/app.json'))
            ->andReturn(true);
        File::shouldReceive('exists')
            ->with(storage_path('app/source-api-outputs/developer.json'))
            ->andReturn(true);

        // Simulamos el contenido de los archivos
        File::shouldReceive('get')
            ->with(storage_path('app/source-api-outputs/app.json'))
            ->andReturn(json_encode([
                [
                    "id" => "21824",
                    "developer_id" => "23",
                    "title" => "Ares",
                    "version" => "2.4.0",
                    "url" => "http://ares.en.softonic.com",
                    "short_description" => "Fast and unlimited P2P file sharing",
                    "license" => "Free (GPL)",
                    "thumbnail" => "https://screenshots.en.sftcdn.net/en/scrn/21000/21824/ares-14-100x100.png",
                    "rating" => 8,
                    "total_downloads" => "4741260",
                    "compatible" => [
                        "Windows 2000",
                        "Windows XP",
                        "Windows Vista",
                        "Windows 7",
                        "Windows 8"
                    ]
                ]
            ]));

        File::shouldReceive('get')
            ->with(storage_path('app/source-api-outputs/developer.json'))
            ->andReturn(json_encode([
                [
                    "id" => 23,
                    "name" => "AresGalaxy",
                    "url" => "https://aresgalaxy.io/"
                ]
            ]));

        // Creación del servicio
        $service = new AppInfoService();

        // Llamada al servicio
        $result = $service->getAppInfo('21824');

        // Verificar que la respuesta sea correcta
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals('21824', $result['id']);
        $this->assertEquals('Ares', $result['title']);
        $this->assertEquals('AresGalaxy', $result['author_info']['name']);
    }

    public function test_get_app_info_not_found()
    {
        // Simulamos la existencia de los archivos JSON
        File::shouldReceive('exists')
            ->with(storage_path('app/source-api-outputs/app.json'))
            ->andReturn(true);
        File::shouldReceive('exists')
            ->with(storage_path('app/source-api-outputs/developer.json'))
            ->andReturn(true);

        // Simulamos el contenido de los archivos vacíos
        File::shouldReceive('get')
            ->with(storage_path('app/source-api-outputs/app.json'))
            ->andReturn(json_encode([]));
        File::shouldReceive('get')
            ->with(storage_path('app/source-api-outputs/developer.json'))
            ->andReturn(json_encode([]));

        // Creación del servicio
        $service = new AppInfoService();

        // Llamada al servicio
        $result = $service->getAppInfo('99999');

        // Verificar que la respuesta sea null
        $this->assertNull($result);
    }
}
