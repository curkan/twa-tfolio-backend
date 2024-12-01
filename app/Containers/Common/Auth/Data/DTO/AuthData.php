<?php

declare(strict_types=1);

namespace App\Containers\Common\Auth\Data\DTO;

use Illuminate\Support\Carbon;

class AuthData
{
    public string $queryId;
    public User $user;
    public Carbon $authData;
    public string $hash;

    public function __construct() {}
}
