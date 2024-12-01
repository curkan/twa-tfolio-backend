<?php

declare(strict_types=1);

namespace App\Ship\Parents\External;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Class: AbstractClient.
 *
 * @abstract
 */
abstract class AbstractClient
{
    /**
     * @param string $path
     * @param ?array $params
     * @return Response
     */
    public function postAsJson(string $path, ?array $params = []): Response
    {
        return Http::asJson()->withoutVerifying()->post($path, $params);
    }
}
