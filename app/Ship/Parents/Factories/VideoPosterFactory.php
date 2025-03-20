<?php

declare(strict_types=1);

namespace App\Ship\Parents\Factories;

use App\Ship\Parents\Factories\Factory as FactoriesFactory;
use App\Ship\Parents\Models\Video;
use App\Ship\Parents\Models\VideoPoster;

final class VideoPosterFactory extends FactoriesFactory
{
    protected $model = VideoPoster::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'video_id' => fn () => Video::factory(),
            'bucket' => null,
            'original' => fake()->imageUrl(),
            'md' => fake()->imageUrl(),
            'sm' => fake()->imageUrl(),
            'xs' => fake()->imageUrl(),
        ];
    }
}
