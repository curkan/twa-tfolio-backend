<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Ship\Parents\Factories\Factory as ParentFactory;
use App\Ship\Parents\Models\ConsumerAccessToken;

/**
 * Class: ConsumerAccessTokenFactory.
 *
 * @see ParentFactory
 */
final class ConsumerAccessTokenFactory extends ParentFactory
{
    protected $model = ConsumerAccessToken::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'consumer_has_product_id' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'token' => $this->faker->text(),
        ];
    }
}
