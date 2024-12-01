<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\Product;
use App\Ship\Parents\Models\ProductRating;
use Random\RandomException;

final class ProductRatingFactory extends Factory
{
    protected $model = ProductRating::class;

    /**
     * @return array
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->email(),
            'product_id' => Product::factory(),
            'rating' => random_int(1, 5),
        ];
    }
}
