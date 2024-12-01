<?php

declare(strict_types=1);

namespace App\Ship\Core\Loaders;

use Illuminate\Support\Facades\File;

trait ConfigsLoaderTrait
{
    /**
     * @return void
     */
    public function loadConfigsFromShip(): void
    {
        $shipConfigsDirectory = base_path('app/Ship/Configs');
        $this->loadConfigs($shipConfigsDirectory);
    }

    /**
     * @return void
     * @param mixed $containerPath
     */
    public function loadConfigsFromContainers($containerPath): void
    {
        $containerConfigsDirectory = $containerPath . '/Configs';
        $this->loadConfigs($containerConfigsDirectory);
    }

    /**
     * @return void
     * @param mixed $configFolder
     */
    private function loadConfigs($configFolder): void
    {
        if (File::isDirectory($configFolder)) {
            $files = File::files($configFolder);

            foreach ($files as $file) {
                $name = File::name($file); /* @phpstan-ignore-line */
                $path = $configFolder . '/' . $name . '.php';

                $this->mergeConfigFrom($path, $name);
            }
        }
    }
}
