<?php

declare(strict_types=1);

namespace App\Ship\Core\Loaders;

use App\Ship\Core\Foundation\Facades\Porto;
use Illuminate\Support\Facades\File;
use SplFileInfo;

trait CommandsLoaderTrait
{
    /**
     * @param string $containerPath
     *
     * @return void
     */
    public function loadCommandsFromContainers(string $containerPath): void
    {
        $containerCommandsDirectory = $containerPath . '/UI/Cli/Commands';
        $this->loadTheConsoles($containerCommandsDirectory);
    }

    /**
     * @return void
     */
    public function loadCommandsFromShip(): void
    {
        $shipCommandsDirectory = base_path('app/Ship/Commands');
        $this->loadTheConsoles($shipCommandsDirectory);
    }

    /**
     * @return void
     */
    public function loadCommandsFromCore(): void
    {
        $coreCommandsDirectory = __DIR__ . '/../Commands';
        $this->loadTheConsoles($coreCommandsDirectory);
    }

    /**
     * @param string $directory
     *
     * @return void
     */
    private function loadTheConsoles(string $directory): void
    {
        if (File::isDirectory($directory)) {
            $files = File::allFiles($directory);

            foreach ($files as $consoleFile) {
                // Do not load route files
                if (!$this->isRouteFile($consoleFile)) {
                    $consoleClass = Porto::getClassFullNameFromFile($consoleFile->getPathname());
                    // When user from the Main Service Provider, which extends Laravel
                    // service provider you get access to `$this->commands`
                    $this->commands([$consoleClass]);
                }
            }
        }
    }

    /**
     * @param SplFileInfo $consoleFile
     *
     * @return bool
     */
    private function isRouteFile(SplFileInfo $consoleFile): bool
    {
        return $consoleFile->getFilename() === 'closures.php';
    }
}
