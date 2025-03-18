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

final class NodeTest extends TestCase
{
    /**
     * @return void
     */
    public function test_show_data(): void
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

        $response = $this->getJson(route('common.grid.show', $node));

        $response
            ->assertOk()
            ->dump()
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->has('data')
                    ->where('data.id', $node->getKey())
                    ->where('data.sort', $node->sort)
                    ->where('data.x', $node->x)
                    ->where('data.y', $node->y)
                    ->where('data.w', $node->w)
                    ->where('data.h', $node->h)
                    ->where('data.type', $node->type)
                    ->has('data.image')
                    ->where('data.image.original', $node->video->poster->pictureOriginal)
                    ->where('data.image.md', $node->video->poster->pictureMd)
                    ->where('data.image.sm', $node->video->poster->pictureSm)
                    ->where('data.image.xs', $node->video->poster->pictureXs)
                    ->etc()
            );
    }
}

