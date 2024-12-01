<?php

declare(strict_types=1);

namespace App\Ship\Core\Loaders;

use App\Ship\Core\Foundation\Facades\Porto;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Trait: ProvidersLoaderTrait.
 */
trait ProvidersLoaderTrait
{
    /**
     * Loads only the Main Service Providers from the Containers.
     * All the Service Providers (registered inside the main), will be
     * loaded from the `boot()` function on the parent of the Main
     * Service Providers.
     *
     * @param string $containerPath
     */
    public function loadOnlyMainProvidersFromContainers(string $containerPath): void
    {
        $containerProvidersDirectory = $containerPath . '/Providers';
        $this->loadProviders($containerProvidersDirectory);
    }

    /**
     * Load the all the registered Service Providers on the Main Service Provider.
     */
    public function loadServiceProviders(): void
    {
        foreach ($this->serviceProviders ?? [] as $provider) { /* @phpstan-ignore-line */
            if (class_exists($provider)) {
                $this->loadProvider($provider);
            }
        }
    }

    /**
     * @return void
     */
    public function loadOnlyShipProviderFromShip(): void
    {
        $this->loadProvider('App\Ship\Providers\ShipProvider');
    }

    /**
     * @param string $directory
     * @return void
     */
    private function loadProviders(string $directory): void
    {
        $mainServiceProviderNameStartWith = 'Main';

        if (File::isDirectory($directory)) {
            $files = File::allFiles($directory);

            foreach ($files as $file) {
                if (File::isFile($file)) { /* @phpstan-ignore-line */
                    // Check if this is the Main Service Provider
                    if (Str::startsWith($file->getFilename(), $mainServiceProviderNameStartWith)) {
                        $serviceProviderClass = Porto::getClassFullNameFromFile($file->getPathname());
                        $this->loadProvider($serviceProviderClass);
                    }
                }
            }
        }
    }

    /**
     * @param string $providerFullName
     * @return void
     */
    private function loadProvider(string $providerFullName): void
    {
        App::register($providerFullName);
    }
}
