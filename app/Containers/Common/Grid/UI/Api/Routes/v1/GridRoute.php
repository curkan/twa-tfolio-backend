<?php

declare(strict_types=1);

use App\Containers\Common\Auth\Middlewares\AuthMiddleware;
use App\Containers\Common\Grid\UI\Api\Controllers\GetGridController;
use App\Containers\Common\Grid\UI\Api\Controllers\GetNodeController;
use App\Containers\Common\Grid\UI\Api\Controllers\UpdateGridController;
use Illuminate\Support\Facades\Route;

Route::middleware(AuthMiddleware::class)->prefix('common')->name('common.')->group(function (): void {
    Route::get('grid', GetGridController::class)->name('grid.index');
    Route::get('grid/{id}', GetNodeController::class)->whereNumber('id')->name('grid.show');
    Route::put('grid', UpdateGridController::class)->name('grid.update');
});
