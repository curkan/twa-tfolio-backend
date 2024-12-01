<?php

declare(strict_types=1);

namespace App\Ship\Parents\Jobs;

use App\Ship\Core\Abstracts\Jobs\Job as AbstractJob;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class: Job.
 *
 * @see ShouldQueue
 * @see AbstractJob
 * @abstract
 */
abstract class Job extends AbstractJob implements ShouldQueue {}
