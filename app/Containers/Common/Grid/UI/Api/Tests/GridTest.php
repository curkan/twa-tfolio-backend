<?php

declare(strict_types=1);

namespace App\Containers\Common\Grid\UI\Api\Tests;

use App\Ship\Parents\Enums\Nodes\NodeTypeEnum;
use App\Ship\Parents\Models\Image;
use App\Ship\Parents\Models\Node;
use App\Ship\Parents\Models\Video;
use App\Ship\Parents\Models\VideoPoster;
use App\Ship\Parents\Tests\PHPUnit\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class GridTest extends TestCase
{
    /**
     * @return void
     */
    public function test_index_ok(): void
    {
        $this->authByUser();

        $this->getJson(route('common.grid.index'))->assertOk();
    }

    /**
     * @return void
     */
    public function test_index_unauth(): void
    {
        $this->getJson(route('common.grid.index'))->assertUnauthorized();
    }

    /**
     * @return void
     */
    public function test_index_data_if_empty(): void
    {
        $user = $this->authByUser();

        $response = $this->getJson(route('common.grid.index'));

        $response
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->has('data')
                    ->where('data.user', $user->getKey())
                    ->where('data.grid', [])
                    ->etc()
            );
    }

    /**
     * @return void
     */
    public function test_index_data_if_not_empty_images(): void
    {
        $user = $this->authByUser();

        $image = Image::factory([
            'user_id' => $user->getKey(),
        ])->createQuietly();

        $node = Node::factory([
            'user_id' => $user->getKey(),
            'image_id' => $image->getKey(),
            'type' => NodeTypeEnum::Image,
        ])->createQuietly();

        $response = $this->getJson(route('common.grid.index'));

        $response
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->has('data')
                    ->where('data.user', $user->getKey())
                    ->has('data.grid', 1)
                    ->where('data.grid.0.id', $node->getKey())
                    ->where('data.grid.0.sort', $node->sort)
                    ->where('data.grid.0.x', $node->x)
                    ->where('data.grid.0.y', $node->y)
                    ->where('data.grid.0.w', $node->w)
                    ->where('data.grid.0.h', $node->h)
                    ->where('data.grid.0.type', $node->type)
                    ->has('data.grid.0.image')
                    ->where('data.grid.0.image.original', $node->image->pictureOriginal)
                    ->where('data.grid.0.image.md', $node->image->pictureMd)
                    ->where('data.grid.0.image.sm', $node->image->pictureSm)
                    ->where('data.grid.0.image.xs', $node->image->pictureXs)
                    ->etc()
            );
    }

    /**
     * @return void
     */
    public function test_index_data_if_not_empty_videos(): void
    {
        $user = $this->authByUser();

        $video = Video::factory([
            'user_id' => $user->getKey(),
        ])->createQuietly();

        $videoPoster = VideoPoster::factory([
            'video_id' => $video->getKey(),
        ])->createQuietly();

        $node = Node::factory([
            'user_id' => $user->getKey(),
            'video_id' => $video->getKey(),
            'type' => NodeTypeEnum::Video,
        ])->createQuietly();

        $response = $this->getJson(route('common.grid.index'));

        $response
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->has('data')
                    ->where('data.user', $user->getKey())
                    ->has('data.grid', 1)
                    ->where('data.grid.0.id', $node->getKey())
                    ->where('data.grid.0.sort', $node->sort)
                    ->where('data.grid.0.x', $node->x)
                    ->where('data.grid.0.y', $node->y)
                    ->where('data.grid.0.w', $node->w)
                    ->where('data.grid.0.h', $node->h)
                    ->where('data.grid.0.type', $node->type)
                    ->has('data.grid.0.image')
                    ->where('data.grid.0.image.original', $node->video->poster->pictureOriginal)
                    ->where('data.grid.0.image.md', $node->video->poster->pictureMd)
                    ->where('data.grid.0.image.sm', $node->video->poster->pictureSm)
                    ->where('data.grid.0.image.xs', $node->video->poster->pictureXs)
                    ->etc()
            );
    }

    /**
     * @return void
     */
    public function test_update(): void
    {
        $user = $this->authByUser();

        $nodes = Node::factory([
            'user_id' => $user->getKey(),
            'type' => NodeTypeEnum::Image,
        ])->count(3)->createQuietly();

        $newNodes = Node::factory([
            'user_id' => $user->getKey(),
            'type' => NodeTypeEnum::Image, ])->count(2)->make();

        $nodeUpdates = [];

        foreach ($newNodes as $node) {
            $nodeUpdates[] = [
                'x' => fake()->randomNumber(1),
                'y' => fake()->randomNumber(1),
                'w' => fake()->randomNumber(1),
                'h' => fake()->randomNumber(1),
                'id' => (string) fake()->randomNumber(5),
                'sort' => 'w_' . fake()->randomNumber(5),
            ];
        }
        $response = $this->putJson(route('common.grid.update'), [
            'nodes' => $nodeUpdates,
        ]);

        $response
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->has('data', 2)
                    ->where('data.user', $user->getKey())
                    ->where('data.grid', [])
                    ->etc()
            );
    }
}
