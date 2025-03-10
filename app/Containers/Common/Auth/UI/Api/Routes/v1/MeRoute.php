<?php

declare(strict_types=1);

use App\Containers\Common\Auth\Middlewares\AuthMiddleware;
use App\Containers\Common\Auth\UI\Api\Controllers\MeController;
use App\Containers\Common\Auth\UI\Api\Controllers\MeUpdateController;
use Illuminate\Support\Facades\Route;

Route::middleware(AuthMiddleware::class)->prefix('common')->name('common.')->group(function (): void {
    Route::get('me', MeController::class);
    Route::put('me', MeUpdateController::class);
});
