<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Ship\Parents\Enums\ConsumerPayment\ConsumerPaymentStatus;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Parents\Models\ConsumerPayment;
use App\Ship\Parents\Models\ConsumerPurchase;
use App\Ship\Parents\Models\Model;

/**
 * Class: ProductFactory.
 *
 * @see Factory
 */
class ConsumerPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = ConsumerPayment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email(),
            'consumer_purchase_id' => null, /* Специально, чтобы ошибку выбило, если не создана */
            'order_id' => $this->faker->uuid(),
            'product_id' => 1,
            'amount' => 0,
            'status' => ConsumerPaymentStatus::New,
        ];
    }
}

