<?php

declare(strict_types=1);

namespace App\Ship\Parents\Factories;

use App\Ship\Parents\Enums\Nodes\NodeTypeEnum;
use App\Ship\Parents\Factories\Factory as FactoriesFactory;
use App\Ship\Parents\Models\Image;
use App\Ship\Parents\Models\Node;
use App\Ship\Parents\Models\User;

final class NodeFactory extends FactoriesFactory
{
    protected $model = Node::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sort' => fake()->randomNumber(),
            'user_id' => fn () => User::factory(),
            'x' => fake()->randomNumber(),
            'y' => fake()->randomNumber(),
            'w' => fake()->randomNumber(),
            'h' => fake()->randomNumber(),
            'type' => NodeTypeEnum::Image,
            'image_id' => fn () => Image::factory(),
            'video_id' => null,
        ];
    }
}
