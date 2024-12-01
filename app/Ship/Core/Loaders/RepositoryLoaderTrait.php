<?php

declare(strict_types=1);

namespace App\Ship\Core\Loaders;

use App\Ship\Core\Foundation\Facades\Porto;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use SplFileInfo;
use Symfony\Component\HttpFoundation\Request;

trait RepositoryLoaderTrait
{
    /**
     * Register all the containers routes files in the framework.
     */
    public function runRepositoryAutoLoader(): void
    {
        $allContainerPaths = Porto::getAllContainerPaths();

        foreach ($allContainerPaths as $containerPath) {
            $this->loadContainerRepository($containerPath);
        }
    }

    /**
     * @param string $containerPath
     * @return void
     */
    private function loadContainerRepository(string $containerPath): void
    {
        $repositoryPath = $this->getPathForContainer($containerPath);

        if (File::isDirectory($repositoryPath)) {
            $files = $this->getFilesSortedByName($repositoryPath);
            foreach ($files as $file) {
                $this->registerRepositories($this->getNamespaceWithClassForClassFile($file));
            }
        }

    }

    private function getPathForContainer(string $containerPath): string
    {
        return $containerPath . \DIRECTORY_SEPARATOR . 'Data' . \DIRECTORY_SEPARATOR . 'Repositories';
    }

    /**
     * @param string $repositoryPath
     * @return array
     */
    private function getFilesSortedByName(string $repositoryPath): array
    {
        $files = File::allFiles($repositoryPath);

        return Arr::sort($files, function ($file) {
            return $file->getFilename();
        });
    }

    /**
     * @param SplFileInfo $file
     * @return string
     */
    private function getNamespaceWithClassForClassFile(SplFileInfo $file): string
    {
        $namespace = str_replace([app_path(), '/'], ['App', '\\'], $file->getPath()) . '\\';
        $nameWithoutExtension = str_replace('.' . $file->getExtension(), '', $file->getFilename());

        return $namespace . $nameWithoutExtension;
    }

    /**
     * @param string $repositorySinglePath
     * @return void
     */
    private function registerRepositories(string $repositorySinglePath): void
    {
        $this->app->bind($repositorySinglePath, function ($app) use ($repositorySinglePath) {
            return new $repositorySinglePath(new Request());
        });
    }
}
