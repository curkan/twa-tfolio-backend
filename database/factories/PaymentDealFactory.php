<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Ship\Parents\Enums\PaymentDeal\PaymentDealStatus;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Models\PaymentDeal;
use App\Ship\Parents\Models\User;

class PaymentDealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = PaymentDeal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->numberBetween(100000, 600000),
            'user_id' => User::factory(),
            'founder_order_id' => $this->faker->uuid(),
            'amount' => $this->faker->numberBetween(1000, 20000),
            'status' => PaymentDealStatus::Accumulation,
        ];
    }
}

