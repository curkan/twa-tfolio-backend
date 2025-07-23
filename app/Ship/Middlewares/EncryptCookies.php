<?php

declare(strict_types=1);

namespace App\Ship\Middlewares;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

final class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var list<string>
     */
    protected $except = [
        //
    ];
}
