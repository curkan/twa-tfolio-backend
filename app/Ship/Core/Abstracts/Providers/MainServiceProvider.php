<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\Providers;

use App\Ship\Core\Loaders\AliasesLoaderTrait;
use App\Ship\Core\Loaders\ProvidersLoaderTrait;
use Illuminate\Support\ServiceProvider as LaravelAppServiceProvider;

abstract class MainServiceProvider extends LaravelAppServiceProvider
{
    use AliasesLoaderTrait;
    use ProvidersLoaderTrait;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadServiceProviders();
        $this->loadAliases();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void {}
}
