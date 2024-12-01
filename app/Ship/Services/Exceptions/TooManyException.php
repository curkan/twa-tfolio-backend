<?php

declare(strict_types=1);

namespace App\Ship\Services\Exceptions;

use App\Ship\Parents\Exceptions\BusinessLogicException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

final class TooManyException extends BusinessLogicException
{
    protected $code = ResponseAlias::HTTP_TOO_MANY_REQUESTS;
}
