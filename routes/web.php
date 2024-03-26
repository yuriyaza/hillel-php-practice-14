<?php

use App\Http\Controllers\MinimizeUrlController;
use App\Http\Controllers\RestoreUrlController;
use App\Http\Middleware\MinimizeUrlValidation;
use Illuminate\Support\Facades\Route;

Route::get('/minimize', [MinimizeUrlController::class, 'index'])
    ->middleware([MinimizeUrlValidation::class]);

Route::get('/{shortUrl}', [RestoreUrlController::class, 'index']);
