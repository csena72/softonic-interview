<?php

namespace App\Console\Commands;

use App\Services\AppInfoService;
use Illuminate\Console\Command;

class AppInfoCommand extends Command
{
    protected $signature = 'app:info {id}';
    protected $description = 'Retrieve app information by ID';

    protected AppInfoService $appInfoService;

    public function __construct(AppInfoService $appInfoService)
    {
        parent::__construct();
        $this->appInfoService = $appInfoService;
    }

    public function handle()
    {
        $appId = $this->argument('id');
        $appInfo = $this->appInfoService->getAppInfo($appId);

        if (!$appInfo) {
            $this->error('App not found');
            return;
        }

        $this->info('App Information:');
        $this->line("ID: {$appInfo['id']}");
        $this->line("Title: {$appInfo['title']}");
        $this->line("Version: {$appInfo['version']}");
        $this->line("URL: {$appInfo['url']}");
        $this->line("Short Description: {$appInfo['short_description']}");
        $this->line("License: {$appInfo['license']}");
        $this->line("Thumbnail: {$appInfo['thumbnail']}");
        $this->line("Rating: {$appInfo['rating']}");
        $this->line("Total Downloads: {$appInfo['total_downloads']}");
        $this->line("Compatible: {$appInfo['compatible']}");
        $this->line("Author: {$appInfo['author_info']['name']}");
        $this->line("Author URL: {$appInfo['author_info']['url']}");
    }
}
