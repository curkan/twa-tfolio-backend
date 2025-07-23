<?php

declare(strict_types=1);

namespace App\Ship\Parents\Factories;

use App\Ship\Parents\Factories\Factory as FactoriesFactory;
use App\Ship\Parents\Models\Image;
use App\Ship\Parents\Models\User;

final class ImageFactory extends FactoriesFactory
{
    protected $model = Image::class;

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
            'original' => fake()->imageUrl(),
            'md' => fake()->imageUrl(),
            'sm' => fake()->imageUrl(),
            'xs' => fake()->imageUrl(),
        ];
    }
}
