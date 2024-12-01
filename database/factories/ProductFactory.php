<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Ship\Parents\Enums\Product\ProductTypeEnum;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Models\Product;
use App\Ship\Parents\Models\User;

/**
 * Class: ProductFactory.
 *
 * @see Factory
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->slug(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(300),
            'published_at' => $this->faker->boolean() ? $this->faker->dateTime() : null,
            'icon' => $this->faker->url(),
            'user_id' => User::factory(),
            'sales' => 0,
            'income' => 0,
            'type' => ProductTypeEnum::Digital,
        ];
    }
}

