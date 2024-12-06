<?php

declare(strict_types=1);

use App\Containers\Common\Auth\Middlewares\AuthMiddleware;
use App\Containers\Common\UploadFiles\UI\Api\Controllers\UploadFilesController;
use Illuminate\Support\Facades\Route;

Route::middleware(AuthMiddleware::class)->prefix('common')->name('common.')->group(function (): void {
    Route::post('upload-files', UploadFilesController::class)->name('upload-files');
});
