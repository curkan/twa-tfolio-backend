<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as LaravelBaseController;

/**
 * Class: Controller.
 *
 * @see LaravelBaseController
 * @abstract
 */
abstract class Controller extends LaravelBaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
}
