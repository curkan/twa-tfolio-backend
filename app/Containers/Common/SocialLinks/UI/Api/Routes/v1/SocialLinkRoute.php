<?php

declare(strict_types=1);

use App\Containers\Common\Auth\Middlewares\AuthMiddleware;
use App\Containers\Common\SocialLinks\UI\Api\Controllers\GetSocialLinksController;
use Illuminate\Support\Facades\Route;

Route::middleware(AuthMiddleware::class)->prefix('common')->name('common.')->group(function (): void {
    Route::get('social-links', GetSocialLinksController::class);
});
