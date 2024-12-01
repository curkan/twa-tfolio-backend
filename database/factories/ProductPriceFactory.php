<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Models\Product;
use App\Ship\Parents\Models\ProductPrice;

class ProductPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = ProductPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'price' => $this->faker->numberBetween(0, 100),
        ];
    }
}

