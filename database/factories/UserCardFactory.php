<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Containers\Payments\Gateway\Data\Enums\CardStatus;
use App\Containers\Payments\Gateway\Data\Enums\CardType;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Models\UserCard;

class UserCardFactory extends Factory
{
    protected $model = UserCard::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'card_id' => $this->faker->numberBetween(1000000, 2000000),
            'pan' => $this->faker->creditCardNumber(),
            'status' => CardStatus::Active,
            'rebill_id' => null,
            'card_type' => CardType::RechargeCard,
            'exp_date' => $this->faker->creditCardExpirationDate()->format('my'),
        ];
    }
}

