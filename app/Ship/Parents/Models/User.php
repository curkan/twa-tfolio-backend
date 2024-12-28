<?php

declare(strict_types=1);

namespace App\Ship\Parents\Models;

use App\Ship\Core\Abstracts\Models\UserModel;
use App\Ship\Parents\Factories\UserFactory;
use Npabisz\LaravelSettings\Traits\HasSettings;

/**
 * @see UserModel
 */
class User extends UserModel
{
    use HasSettings;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'username',
        'language_code',
        'allows_write_to_pm',
        'photo_url',
        'display_name',
        'biography',
    ];

    /**
     * @return array
     */
    public static function getSettingsDefinitions(): array
    {
        return [
            [
                'name' => 'enabled_send_me_button',
                'cast' => 'bool',
                'default' => true,
            ],
        ];
    }

    /**
     * @return UserFactory|null
     */
    protected static function newFactory(): ?UserFactory
    {
        return UserFactory::new();
    }
}
