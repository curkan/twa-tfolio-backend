<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Ship\Parents\Factories\Factory as ParentFactory;
use App\Ship\Parents\Models\ConsumerHasProduct;
use App\Ship\Parents\Models\Product;

/**
 * Class: ConsumerAccessTokenFactory.
 *
 * @see ParentFactory
 */
final class ConsumerHasProductFactory extends ParentFactory
{
    protected $model = ConsumerHasProduct::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'product_id' => Product::factory(),
            'consumer_purchase_id' => $this->faker->unique()->randomNumber(4),
            'email' => $this->faker->safeEmail(),
        ];
    }
}
