<?php

declare(strict_types=1);

namespace App\Ship\Commands;

use App\Ship\Core\Foundation\Facades\Porto;
use App\Ship\Core\Loaders\CacheHelper;
use App\Ship\Parents\Commands\ConsoleCommand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'porto:cache')]
class PortoCacheCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'porto:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Porto cache architecture';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $cache = (new CacheHelper())->get('porto_schema');
        $cacheData = [];

        if ($cache !== null) {
            $cacheData = json_decode($cache, true);
        }

        // migrations
        $shipMigrationDirectory = base_path('app/Ship/Migrations');
        $directories = glob($shipMigrationDirectory . '/*', GLOB_ONLYDIR);
        $paths = array_merge([$shipMigrationDirectory], $directories);

        // configs
        $shipConfigsDirectory = base_path('app/Ship/Configs');
        $shipConfigs = $this->getClassNames($shipConfigsDirectory);

        // commands
        $shipCommandsDirectory = base_path('app/Ship/Commands');
        $coreCommandsDirectory = base_path('app/Ship/Core/Commands');

        $commandShipClasses = array_merge(
            $this->getClassNames($coreCommandsDirectory),
            $this->getClassNames($shipCommandsDirectory)
        );

        // views
        $viewsShip = $this->getViews(base_path('app/Ship/Mails/Templates/'), 'ship');

        // metrics
        $shipMetrics = base_path('app/Ship/Metrics/');
        $merticsShipClasess = $this->getClassNames($shipMetrics);

        // helpers
        $shipHelpersDirectory = base_path('app/Ship/Helpers');
        $helpersShipFiles = $this->getFiles($shipHelpersDirectory);

        // viewsContainers
        $viewsContainers = [];
        $providersContainers = [];
        $configsContainers = [];
        $metricsContainers = [];
        $commandsContainers = [];

        foreach (Porto::getAllContainerPaths() as $containerPath) {
            $viewsFromContainer = $this->getViewsFromContainers($containerPath);
            $providersFromContainer = $this->getOnlyMainProvidersFromContainers($containerPath);
            $configsFromContainers = $this->getConfigs($containerPath . '/Configs');
            $metricsFromContainers = $this->getClassNames($containerPath . '/Metrics');
            $commandsFromConrainers = $this->getClassNames($containerPath . '/UI/Cli/Commands');

            if (!blank($viewsFromContainer)) {
                $viewsContainers = array_merge($viewsContainers, $viewsFromContainer);
            }

            if (!blank($providersFromContainer)) {
                $providersContainers = array_merge($providersContainers, $providersFromContainer);
            }

            if (!blank($configsFromContainers)) {
                foreach ($configsFromContainers as $config) {
                    $configsContainers = array_merge($configsContainers, $config);
                }
            }

            if (!blank($metricsFromContainers)) {
                $metricsContainers = array_merge($metricsContainers, $metricsFromContainers);
            }

            if (!blank($commandsFromConrainers)) {
                $commandsContainers = array_merge($commandsContainers, $commandsFromConrainers);
            }

            unset(
                $viewsFromContainer,
                $providersFromContainer,
                $configsFromContainers,
                $metricsFromContainers,
                $commandsFromConrainers
            );
        }

        $cacheData['ship']['migrations'] = $paths;
        $cacheData['ship']['commands'] = $commandShipClasses;
        $cacheData['ship']['metrics'] = $merticsShipClasess;
        $cacheData['ship']['helpers'] = $helpersShipFiles;
        $cacheData['ship']['configs'] = $shipConfigs;
        $cacheData['ship']['views'] = $viewsShip;

        $cacheData['containers']['views'] = $viewsContainers;
        $cacheData['containers']['providers'] = $providersContainers;
        $cacheData['containers']['configs'] = $configsContainers;
        $cacheData['containers']['metrics'] = $metricsContainers;
        $cacheData['containers']['commands'] = $commandsContainers;

        (new CacheHelper())->set('porto_schema', json_encode($cacheData));

        $this->components->info('Porto cached successfully.');
    }

    /**
     * @param string $containerPath
     *
     * @return array
     */
    public function getViewsFromContainers(string $containerPath): array
    {
        $containerViewDirectory = $containerPath . '/UI/Web/Views/';
        $containerMailTemplatesDirectory = $containerPath . '/Mails/Templates/';

        $containerName = basename($containerPath);
        $pathParts = explode(\DIRECTORY_SEPARATOR, $containerPath);
        $sectionName = $pathParts[count($pathParts) - 2];

        $viewDirectory = $this->getViews($containerViewDirectory, $containerName, $sectionName);
        $viewMailTemplateDirectory = $this->getViews($containerMailTemplatesDirectory, $containerName, $sectionName);

        return array_merge($viewDirectory, $viewMailTemplateDirectory);
    }

    /**
     * @param string $containerPath
     *
     * @return array
     */
    public function getOnlyMainProvidersFromContainers(string $containerPath): array
    {
        $containerProvidersDirectory = $containerPath . '/Providers';

        return $this->getProviders($containerProvidersDirectory);
    }

    /**
     * @param string $directory
     *
     * @return array
     */
    private function getClassNames(string $directory): array
    {
        if (File::isDirectory($directory)) {
            $files = File::allFiles($directory);

            $commandClasses = [];
            foreach ($files as $consoleFile) {
                if (!$this->isRouteFile($consoleFile) && ($consoleFile->getExtension() === 'php')) {
                    $consoleClass = Porto::getClassFullNameFromFile($consoleFile->getPathname());
                    $commandClasses[] = $consoleClass;
                }
            }

            return $commandClasses;
        }

        return [];
    }

    /**
     * @param string $helpersFolder
     *
     * @return array
     */
    private function getFiles(string $helpersFolder): array
    {
        $filesPathnames = [];
        if (File::isDirectory($helpersFolder)) {
            $files = File::files($helpersFolder);

            foreach ($files as $file) {
                $filesPathnames[] = $file->getPathname();
            }
        }

        return $filesPathnames;
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

    /**
     * @return array
     * @param mixed $directory
     * @param mixed $containerName
     * @param mixed|null $sectionName
     */
    private function getViews($directory, $containerName, $sectionName = null): array
    {
        if (File::isDirectory($directory)) {
            return [$directory => $this->buildViewNamespace($sectionName, $containerName)];
        }

        return [];
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

    /**
     * @param string $directory
     * @return array
     */
    private function getProviders(string $directory): array
    {
        $mainServiceProviderNameStartWith = 'Main';

        if (File::isDirectory($directory)) {
            $files = File::allFiles($directory);

            $providers = [];
            foreach ($files as $file) {
                if (File::isFile($file)) { /* @phpstan-ignore-line */
                    // Check if this is the Main Service Provider
                    if (Str::startsWith($file->getFilename(), $mainServiceProviderNameStartWith)) {
                        $serviceProviderClass = Porto::getClassFullNameFromFile($file->getPathname());

                        $providers[] = $serviceProviderClass;
                    }
                }
            }

            return $providers;
        }

        return [];
    }

    /**
     * @param string $configFolder
     *
     * @return array
     */
    private function getConfigs(string $configFolder): array
    {
        if (File::isDirectory($configFolder)) {
            $files = File::files($configFolder);

            $configFiles = [];
            foreach ($files as $file) {
                $name = File::name($file); /* @phpstan-ignore-line */
                $path = $configFolder . '/' . $name . '.php';

                $configFiles[] = [$name => $path];
            }

            return $configFiles;
        }

        return [];
    }
}
