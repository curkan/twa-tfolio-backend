<?php

declare(strict_types=1);

use App\Containers\Common\Auth\Middlewares\AuthMiddleware;
use App\Containers\Common\UploadVideo\UI\Api\Controllers\UploadVideoController;
use Illuminate\Support\Facades\Route;

Route::middleware(AuthMiddleware::class)->prefix('common')->name('common.')->group(function (): void {
    Route::post('upload-video', UploadVideoController::class)->name('upload-video');
});
