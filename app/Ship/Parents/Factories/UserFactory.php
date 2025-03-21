<?php

declare(strict_types=1);

namespace App\Ship\Parents\Factories;

use App\Ship\Parents\Factories\Factory as FactoriesFactory;
use App\Ship\Parents\Models\User;

final class UserFactory extends FactoriesFactory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'username' => fake()->unique()->userName(),
            'language_code' => fake()->languageCode(),
            'allows_write_to_pm' => true,
            'photo_url' => fake()->url(),
            'display_name' => fake()->firstName(),
            'biography' => fake()->text(100),
        ];
    }
}
