<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\Controllers;

use App\Ship\Services\Responses\ResourceResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Class: ApiController.
 *
 * @see Controller
 * @abstract
 */
abstract class ApiController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ResourceResponses;
    use ValidatesRequests;

    /**
     * The type of this controller. This will be accessibly mirrored in the Actions.
     * Giving each Action the ability to modify it's internal business logic based on the UI type that called it.
     */
    public string $ui = 'api';
}
