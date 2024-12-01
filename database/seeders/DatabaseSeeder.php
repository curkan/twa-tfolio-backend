<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Ship\Core\Loaders\SeederLoaderTrait;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    use SeederLoaderTrait;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {

        $this->call([
        ]);

        $this->runLoadingSeeders();
    }
}
