<?php

declare(strict_types=1);

namespace App\Ship\Core\Loaders;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

trait HelpersLoaderTrait
{
    /**
     * @param string $containerPath
     * @return void
     */
    public function loadHelpersFromContainers(string $containerPath): void
    {
        $containerHelpersDirectory = $containerPath . '/Helpers';
        $this->loadHelpers($containerHelpersDirectory);
    }

    /**
     * @return void
     */
    public function loadHelpersFromShip(): void
    {
        $shipHelpersDirectory = base_path('app/Ship/Helpers');
        $this->loadHelpers($shipHelpersDirectory);
    }

    /**
     * @param string $helpersFolder
     * @return void
     */
    private function loadHelpers(string $helpersFolder): void
    {
        if (File::isDirectory($helpersFolder)) {
            $files = File::files($helpersFolder);

            foreach ($files as $file) {
                try {
                    require $file;
                } catch (FileNotFoundException $e) {
                }
            }
        }
    }
}
