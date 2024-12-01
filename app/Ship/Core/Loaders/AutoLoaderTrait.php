<?php

declare(strict_types=1);

namespace App\Ship\Core\Loaders;

use App\Ship\Core\Foundation\Facades\Porto;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

trait AutoLoaderTrait
{
    use CommandsLoaderTrait;
    // Using each component loader trait
    use ConfigsLoaderTrait;
    // use AliasesLoaderTrait;
    use HelpersLoaderTrait;
    // use LocalizationLoaderTrait;
    use MigrationsLoaderTrait;
    use ProvidersLoaderTrait;
    use ViewsLoaderTrait;

    /**
     * To be used from the `boot` function of the main service provider.
     */
    public function runLoadersBoot(): void
    {
        $cache = (new CacheHelper())->get('porto_schema');

        if ($cache !== null) {
            $this->loadBootFromCache($cache);
        } else {
            $this->loadMigrationsFromShip();
            $this->loadCommandsFromShip();
            $this->loadCommandsFromCore();
        }
    }

    /**
     * @return void
     */
    public function runLoaderRegister(): void
    {
        $cache = (new CacheHelper())->get('porto_schema');

        if ($cache !== null) {
            $this->loadRegisterFromCache($cache);
        } else {
            $this->loadHelpersFromShip();
            $this->loadConfigsFromShip();
            $this->loadOnlyShipProviderFromShip();

            foreach (Porto::getAllContainerPaths() as $containerPath) {
                $this->loadConfigsFromContainers($containerPath);
                $this->loadOnlyMainProvidersFromContainers($containerPath);
                $this->loadViewsFromContainers($containerPath);
                $this->loadCommandsFromContainers($containerPath);
            }
        }
    }

    /**
     * @return void
     * @param mixed $cache
     */
    private function loadBootFromCache($cache): void
    {
        if ($cache !== null && json_validate($cache)) {
            $cacheData = json_decode($cache);

            if (isset($cacheData->ship->migrations)) {
                $this->loadMigrationsFrom($cacheData->ship->migrations);
            } else {
                $this->loadMigrationsFromShip();
            }

            if (isset($cacheData->ship->views)) {
                if (!empty($cacheData->ship->views)) {
                    foreach ($cacheData->ship->views as $path => $sectionName) {
                        $this->loadViewsFrom($path, $sectionName);
                    }
                }
            } else {
                $this->loadViewsFromShip();
            }

            if (isset($cacheData->ship->commands)) {
                $this->commands($cacheData->ship->commands);
            } else {
                $this->loadCommandsFromShip();
                $this->loadCommandsFromCore();
            }

        }
    }

    /**
     * @return void
     * @param mixed $cache
     */
    private function loadRegisterFromCache($cache): void
    {
        $notCacheModules = [];

        if ($cache !== null && json_validate($cache)) {
            $cacheData = json_decode($cache);

            if (isset($cacheData->ship->helpers)) {
                foreach ($cacheData->ship->helpers as $helper) {
                    require_once $helper;
                }
            } else {
                $this->loadHelpersFromShip();
            }

            // load ship configs
            if (isset($cacheData->ship->configs)) {
                if (!blank($cacheData->ship->configs)) {
                    foreach ($cacheData->ship->configs as $name => $path) {
                        $this->mergeConfigFrom($path, $name);
                    }
                }
            } else {
                $this->loadConfigsFromShip();
            }

            $this->loadOnlyShipProviderFromShip();

            // load containers configs
            if (isset($cacheData->containers->configs)) {
                foreach ($cacheData->containers->configs as $name => $path) {
                    $this->mergeConfigFrom($path, $name);
                }
            } else {
                $notCacheModules[] = 'configs';
            }

            // load containers providers
            if (isset($cacheData->containers->providers)) {
                foreach ($cacheData->containers->providers as $provider) {
                    App::register($provider);
                }
            } else {
                $notCacheModules[] = 'providers';
            }

            // load containers views
            if (isset($cacheData->containers->views)) {
                foreach ($cacheData->containers->views as $path => $sectionName) {
                    $this->loadViewsFrom($path, $sectionName);
                }
            } else {
                $notCacheModules[] = 'views';
            }

            if (isset($cacheData->containers->commands)) {
                $this->commands($cacheData->containers->commands);
            } else {
                $notCacheModules[] = 'commands';
            }
        }

        if (!empty($notCacheModules)) {
            foreach (Porto::getAllContainerPaths() as $containerPath) {
                if (array_key_exists('configs', $notCacheModules)) { /* @phpstan-ignore-line */
                    Log::alert('Configs not cached');
                    $this->loadConfigsFromContainers($containerPath);
                }

                if (array_key_exists('providers', $notCacheModules)) { /* @phpstan-ignore-line */
                    Log::alert('Providers not cached');
                    $this->loadOnlyMainProvidersFromContainers($containerPath);
                }

                if (array_key_exists('views', $notCacheModules)) { /* @phpstan-ignore-line */
                    Log::alert('Views not cached');
                    $this->loadViewsFromContainers($containerPath);
                }

                if (array_key_exists('commands', $notCacheModules)) { /* @phpstan-ignore-line */
                    Log::alert('Commands not cached');
                    $this->loadCommandsFromContainers($containerPath);
                }
            }
        }
    }
}
