<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\AppInfoService;

class AppInfoController extends Controller
{
    protected AppInfoService $appInfoService;

    public function __construct(AppInfoService $appInfoService)
    {
        $this->appInfoService = $appInfoService;
    }

    public function show(string $id): JsonResponse
    {
        $appInfo = $this->appInfoService->getAppInfo($id);

        if (!$appInfo) {
            return response()->json(['error' => 'App not found'], 404);
        }

        return response()->json($appInfo);
    }
}
