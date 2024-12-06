<?php

declare(strict_types=1);

use App\Containers\Common\Auth\Middlewares\AuthMiddleware;
use App\Containers\Common\Users\UI\Api\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(AuthMiddleware::class)->prefix('common')->name('common.')->group(function (): void {
    Route::get('users/{id}', UserController::class);
});
