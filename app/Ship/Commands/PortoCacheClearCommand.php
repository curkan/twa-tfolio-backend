<?php

declare(strict_types=1);

namespace App\Ship\Commands;

use App\Ship\Core\Loaders\CacheHelper;
use App\Ship\Parents\Commands\ConsoleCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'porto:clear')]
class PortoCacheClearCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'porto:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Porto flush cache';

    /**
     * @return void
     */
    public function handle(): void
    {
        $cacheHelper = new CacheHelper();
        $cache = $cacheHelper->get('porto_schema');

        if ($cache !== null) {
            $cacheHelper->delete('porto_schema');
        }

        $this->components->info('Porto cache cleared successfully.');
    }
}
