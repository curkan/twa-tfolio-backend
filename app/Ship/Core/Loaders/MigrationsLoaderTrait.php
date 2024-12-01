<?php

declare(strict_types=1);

namespace App\Ship\Core\Loaders;

use Illuminate\Support\Facades\File;

trait MigrationsLoaderTrait
{
    /**
     * @return void
     */
    public function loadMigrationsFromShip(): void
    {
        $shipMigrationDirectory = base_path('app/Ship/Migrations');
        $directories = glob($shipMigrationDirectory . '/*', GLOB_ONLYDIR);
        $paths = array_merge([$shipMigrationDirectory], $directories);

        $this->loadMigrationsFrom($paths);
    }

    /**
     * @param string $directory
     * @return void
     */
    private function loadMigrations(string $directory): void
    {
        if (File::isDirectory($directory)) {
            $this->loadMigrationsFrom($directory);
        }
    }
}
