<?php

use App\Http\Controllers\AppInfoController;
use Illuminate\Support\Facades\Route;

Route::get('/apps/{id}', [AppInfoController::class, 'show']);
