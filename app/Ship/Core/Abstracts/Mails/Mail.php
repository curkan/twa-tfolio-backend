<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\Mails;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class: Mail.
 *
 * @see Mailable
 * @abstract
 */
abstract class Mail extends Mailable
{
    use SerializesModels;
}
