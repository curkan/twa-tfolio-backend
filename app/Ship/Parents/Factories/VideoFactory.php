<?php

declare(strict_types=1);

namespace App\Ship\Parents\Factories;

use App\Ship\Parents\Factories\Factory as FactoriesFactory;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Models\Video;

final class VideoFactory extends FactoriesFactory
{
    protected $model = Video::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fn () => User::factory(),
            'bucket' => null,
            'link' => fake()->url(),
        ];
    }
}
