<?php

declare(strict_types=1);

namespace App\Ship\Core\Loaders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait ViewsLoaderTrait
{
    /**
     * @return void
     * @param mixed $containerPath
     */
    public function loadViewsFromContainers($containerPath): void
    {
        $containerViewDirectory = $containerPath . '/UI/Web/Views/';
        $containerMailTemplatesDirectory = $containerPath . '/Mails/Templates/';

        $containerName = basename($containerPath);
        $pathParts = explode(\DIRECTORY_SEPARATOR, $containerPath);
        $sectionName = $pathParts[count($pathParts) - 2];

        $this->loadViews($containerViewDirectory, $containerName, $sectionName);
        $this->loadViews($containerMailTemplatesDirectory, $containerName, $sectionName);
    }

    /**
     * @return void
     */
    public function loadViewsFromShip(): void
    {
        $shipMailTemplatesDirectory = base_path('app/Ship/Mails/Templates/');
        $this->loadViews($shipMailTemplatesDirectory, 'ship'); // Ship views accessible via `ship::`.
    }

    /**
     * @return void
     * @param mixed $directory
     * @param mixed $containerName
     * @param mixed|null $sectionName
     */
    private function loadViews($directory, $containerName, $sectionName = null): void
    {
        if (File::isDirectory($directory)) {
            $this->loadViewsFrom($directory, $this->buildViewNamespace($sectionName, $containerName));
        }
    }

    /**
     * @param string $sectionName
     * @param string $containerName
     *
     * @return string
     */
    private function buildViewNamespace(?string $sectionName, string $containerName): string
    {
        return $sectionName ? (Str::camel($sectionName) . '@' . Str::camel($containerName)) : Str::camel($containerName);
    }
}
