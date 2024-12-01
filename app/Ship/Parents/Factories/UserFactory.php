<?php

declare(strict_types=1);

namespace App\Ship\Parents\Factories;

use App\Ship\Parents\Factories\Factory as FactoriesFactory;
use App\Ship\Parents\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class: UserFactory.
 *
 * @see FactoriesFactory
 * @final
 */
final class UserFactory extends FactoriesFactory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => fake()->unique()->userName(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified' => true,
            'phone_verified' => true,
            'picture' => fake()->url(),
            'phone' => '798197' . fake()->unique()->numberBetween(10000, 99999),
            'email_verified_at' => now(),
            'ip_register' => fake()->ipv4(),
            'password' => Hash::make($this->faker->unique()->password()),
            'remember_token' => Str::random(10),
            'status' => 1,
            'seller_key' => null,
            'created_at' => Carbon::now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
