<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Ship\Parents\Enums\PaymentWithdraw\PaymentWithdrawStatus;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Models\PaymentDeal;
use App\Ship\Parents\Models\PaymentWithdraw;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Models\UserCard;

class PaymentWithdrawFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = PaymentWithdraw::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory();

        return [
            'id' => $this->faker->numberBetween(100000, 600000),
            'user_id' => $user,
            'deal_id' => PaymentDeal::factory(),
            'card_id' => UserCard::factory(['user_id' => $user]),
            'card_id_external' => $this->faker->randomNumber(5),
            'amount' => $this->faker->numberBetween(1000, 20000),
            'payment_id' => $this->faker->randomDigitNotNull(),
            'status' => PaymentWithdrawStatus::Init,
        ];
    }
}

