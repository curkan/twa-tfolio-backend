<?php

declare(strict_types=1);

namespace App\Ship\Parents\Models;

use App\Ship\Core\Abstracts\Models\UserModel;
use App\Ship\Parents\Factories\UserFactory;

/**
 * @see UserModel
 */
class User extends UserModel
{
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
     * @return UserFactory|null
     */
    protected static function newFactory(): ?UserFactory
    {
        return UserFactory::new();
    }
}
