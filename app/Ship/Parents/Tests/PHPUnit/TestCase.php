<?php

declare(strict_types=1);

namespace App\Ship\Parents\Tests\PHPUnit;

use App\Ship\Core\Abstracts\Tests\PHPUnit\TestCase as AbstractTestCase;
use App\Ship\Parents\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\CreatesApplication;

abstract class TestCase extends AbstractTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @var User|null
     */
    protected ?User $user = null;

    /**
     * setUp.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Notification::fake();

        Http::fake([
            '*' => Http::response([]),
        ]);
    }

    /**
     * @return static
     */
    protected function clearExistingFakes(): static
    {
        app()->forgetInstance(Factory::class);

        Http::swap(
            app(Factory::class)
        );

        return $this;
    }

    /**
     * authByUser.
     *
     * @param mixed $user
     * @return User|null
     */
    protected function authByUser($user = null): ?User
    {
        $user = $user ?: User::factory()->createQuietly();

        $this->actingAs($user);

        $this->user = $user;

        return $user;
    }
}
