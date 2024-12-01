<?php

declare(strict_types=1);

namespace App\Ship\Core\Loaders;

use App\Ship\Core\Foundation\Facades\Porto;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\SplFileInfo;

trait RoutesLoaderTrait
{
    /**
     * Register all the containers routes files in the framework.
     */
    public function runRoutesAutoLoader(): void
    {
        if (!$this->shouldRegisterRoutes()) {
            return;
        }

        $allContainerPaths = Porto::getAllContainerPaths();

        foreach ($allContainerPaths as $containerPath) {
            $this->loadApiContainerRoutes($containerPath);
            $this->loadWebContainerRoutes($containerPath);
        }
    }

    /**
     * @param SplFileInfo|string $endpointFileOrPrefixString
     * @return array
     */
    public function getApiRouteGroup(SplFileInfo|string $endpointFileOrPrefixString): array
    {
        return [
            'middleware' => $this->getMiddlewares(),
            // 'domain' => $this->getApiUrl(),
            // If $endpointFileOrPrefixString is a string, use that string as prefix
            // else, if it is a file then get the version name from the file name, and use it as prefix
            'prefix' => is_string($endpointFileOrPrefixString) ? $endpointFileOrPrefixString : $this->getApiVersionPrefix($endpointFileOrPrefixString),
        ];
    }

    /**
     * @return bool
     */
    private function shouldRegisterRoutes(): bool
    {
        if ($this->app->routesAreCached()) {
            return false;
        }

        return true;
    }

    /**
     * Register the Containers API routes files.
     * @param string $containerPath
     */
    private function loadApiContainerRoutes(string $containerPath): void
    {
        $apiRoutesPath = $this->getRoutePathsForUI($containerPath, 'Api');

        if (File::isDirectory($apiRoutesPath)) {
            $files = $this->getFilesSortedByName($apiRoutesPath);
            foreach ($files as $file) {
                $this->loadApiRoute($file);
            }
        }
    }

    /**
     * @param string $containerPath
     * @param string $ui
     * @return string
     */
    private function getRoutePathsForUI(string $containerPath, string $ui): string
    {
        return $this->getUIPathForContainer($containerPath, $ui) . \DIRECTORY_SEPARATOR . 'Routes';
    }

    /**
     * @param string $containerPath
     * @param string $ui
     * @return string
     */
    private function getUIPathForContainer(string $containerPath, string $ui): string
    {
        return $containerPath . \DIRECTORY_SEPARATOR . 'UI' . \DIRECTORY_SEPARATOR . $ui;
    }

    /**
     * @param string $apiRoutesPath
     * @return array|SplFileInfo[]
     */
    private function getFilesSortedByName(string $apiRoutesPath): array
    {
        $files = File::allFiles($apiRoutesPath);

        return Arr::sort($files, function ($file) {
            return $file->getFilename();
        });
    }

    /**
     * @param SplFileInfo $file
     * @return void
     */
    private function loadApiRoute(SplFileInfo $file): void
    {
        $routeGroupArray = $this->getApiRouteGroup($file);

        Route::group($routeGroupArray, function ($router) use ($file): void {
            require $file->getPathname();
        });
    }

    /**
     * @return array
     */
    private function getMiddlewares(): array
    {
        return array_filter([
            'api',
            $this->getRateLimitMiddleware(), // Returns NULL if feature disabled. Null will be removed form the array.
        ]);
    }

    /**
     * @return string|null
     */
    private function getRateLimitMiddleware(): ?string
    {
        $rateLimitMiddleware = null;

        if (Config::get('porto.api.throttle.enabled')) {
            RateLimiter::for('api', function (Request $request) {
                return Limit::perMinutes(Config::get('porto.api.throttle.expires'), Config::get('porto.api.throttle.attempts'))->by($request->user()?->id ?: $request->ip());
            });

            $rateLimitMiddleware = 'throttle:api';
        }

        return $rateLimitMiddleware;
    }

    /**
     * @return string
     */
    private function getApiUrl(): string
    {
        return Config::get('porto.api.url');
    }

    /**
     * @param SplFileInfo $file
     * @return string
     */
    private function getApiVersionPrefix(SplFileInfo $file): string
    {
        return Config::get('porto.api.prefix') . (Config::get('porto.api.enable_version_prefix') ? $this->getRouteFileVersionFromFile($file) : '');
    }

    /**
     * @param SplFileInfo $file
     * @return string
     */
    private function getRouteFileVersionFromFile(SplFileInfo $file): string
    {
        return '/' . $file->getRelativePath();
    }

    /**
     * @param SplFileInfo $file
     * @return string
     */
    private function getRouteFileNameWithoutExtension(SplFileInfo $file): string
    {
        return pathinfo($file->getFilename(), PATHINFO_FILENAME);
    }

    /**
     * Register the Containers WEB routes files.
     *
     * @param string $containerPath
     */
    private function loadWebContainerRoutes(string $containerPath): void
    {
        $webRoutesPath = $this->getRoutePathsForUI($containerPath, 'Web');

        if (File::isDirectory($webRoutesPath)) {
            $files = $this->getFilesSortedByName($webRoutesPath);
            foreach ($files as $file) {
                $this->loadWebRoute($file);
            }
        }
    }

    /**
     * @param SplFileInfo $file
     * @return void
     */
    private function loadWebRoute(SplFileInfo $file): void
    {
        Route::group([
            'middleware' => ['web'],
        ], function ($router) use ($file): void {
            require $file->getPathname();
        });
    }
}
