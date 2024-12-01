<?php

declare(strict_types=1);

namespace App\Ship\Parents\Enums\ConsumerPayment;

use BenSampo\Enum\Enum;

final class ConsumerPaymentStatus extends Enum
{
    public const New = 'new';
    public const Authorized = 'authorized';
    public const Paid = 'paid';
    public const Failed = 'failed';
    public const Refunded = 'refunded';
    public const Withdrawn = 'withdrawn';
}
