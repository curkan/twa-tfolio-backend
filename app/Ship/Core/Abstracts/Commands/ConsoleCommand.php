<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\Commands;

use Illuminate\Console\Command as LaravelCommand;

/**
 * Class: ConsoleCommand.
 *
 * @see LaravelCommand
 * @abstract
 */
abstract class ConsoleCommand extends LaravelCommand
{
    /**
     * The type of this controller. This will be accessibly mirrored in the Actions.
     * Giving each Action the ability to modify it's internal business logic based on the UI type that called it.
     */
    public string $ui = 'cli';
}
