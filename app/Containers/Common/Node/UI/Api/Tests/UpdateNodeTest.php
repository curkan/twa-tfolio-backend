<?php

declare(strict_types=1);

namespace App\Containers\Common\Node\UI\Api\Tests;

use App\Ship\Parents\Enums\Nodes\NodeTypeEnum;
use App\Ship\Parents\Models\Node;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Tests\PHPUnit\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

final class UpdateNodeTest extends TestCase
{
    /**
     * @return void
     */
    public function test_update_success(): void
    {
        $user = $this->authByUser();

        $node = Node::factory([
            'user_id' => $user->getKey(),
            'type' => NodeTypeEnum::Image,
            'description' => null,
        ])->createQuietly();

        $response = $this->putJson(route('common.node.update', [
            'id' => $node->getKey(),
        ]), ['description' => 'test-asd']);

        $response
            ->assertOk()
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
                    ->where('data.description', 'test-asd')
                    ->etc()
            );
    }

    /**
     * @return void
     */
    public function test_update_forbidden(): void
    {
        $user = $this->authByUser();

        $node = Node::factory([
            'type' => NodeTypeEnum::Image,
            'user_id' => User::factory(),
            'description' => null,
        ])->createQuietly();

        $response = $this->putJson(route('common.node.update', [
            'id' => $node->getKey(),
        ]), ['description' => 'test-asd']);

        $response->assertForbidden();
    }
}
