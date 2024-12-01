<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Models\ProductCategory;

class ProductCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = ProductCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'alias' => $this->faker->word(),
            'icon' => $this->faker->url(),
            'description' => $this->faker->sentence(),
        ];
    }
}
