<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\Controllers;

/**
 * Class: WebController.
 *
 * @see Controller
 * @abstract
 */
abstract class WebController extends Controller
{
    /**
     * The type of this controller. This will be accessibly mirrored in the Actions.
     * Giving each Action the ability to modify it's internal business logic based on the UI type that called it.
     */
    public string $ui = 'web';
}
