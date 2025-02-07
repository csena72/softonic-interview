<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use Mockery;

class AppInfoControllerTest extends TestCase
{
    public function test_show_success()
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

        // Realizamos la petición al controlador
        $response = $this->getJson('/api/apps/21824');

        // Verificamos que la respuesta sea correcta
        $response->assertStatus(200)
            ->assertJson([
                'id' => '21824',
                'title' => 'Ares',
                'author_info' => [
                    'name' => 'AresGalaxy'
                ]
            ]);
    }



    public function test_show_app_not_found()
    {
        // Simulamos que los archivos JSON no existen
        File::shouldReceive('exists')
            ->with(storage_path('app/source-api-outputs/app.json'))
            ->andReturn(false);

        File::shouldReceive('exists')
            ->with(storage_path('app/source-api-outputs/developer.json'))
            ->andReturn(false);

        // Realizamos la petición al controlador
        $response = $this->getJson('/api/apps/99999');

        // Verificamos que la respuesta sea un error 404
        $response->assertStatus(404)
            ->assertJson([
                'error' => 'App not found'
            ]);
    }
}
