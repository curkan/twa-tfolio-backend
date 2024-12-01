<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\ConsumerPurchase;
use App\Ship\Parents\Models\Model;

class ConsumerPurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = ConsumerPurchase::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email(),
            'order_id' => $this->faker->uuid(),
            'product_id' => 1,
            'purchase_price' => 0,
            'fair_price' => null,
            'status' => 'init',
        ];
    }
}

