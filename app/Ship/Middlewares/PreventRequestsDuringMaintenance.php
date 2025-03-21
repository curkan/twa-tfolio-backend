<?php

declare(strict_types=1);

namespace App\Ship\Middlewares;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

final class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
