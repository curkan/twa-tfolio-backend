<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Containers\UserPanel\Messages\Models\MessageTemplate;
use App\Ship\Parents\Factories\Factory;

class MessageTemplateFactory extends Factory
{
    protected $model = MessageTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $body = [
            'time' => 1701598883144,
            'blocks' => [
                [
                    'data' => [
                        'text' => $this->faker->text(100),
                    ],
                    'type' => 'paragraph',
                ],
            ],
            'version' => '2.20',
        ];

        return [
            'key' => $this->faker->unique()->word(),
            'title' => $this->faker->title(),
            'body' => $body,
        ];
    }
}
