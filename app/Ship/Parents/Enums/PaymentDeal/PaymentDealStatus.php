<?php

declare(strict_types=1);

namespace App\Ship\Parents\Enums\PaymentDeal;

use BenSampo\Enum\Enum;

// У пользователя может быть только одна сделка накапливаемая
final class PaymentDealStatus extends Enum
{
    public const Accumulation = 'accumulation'; // Накапливается
    public const Checked = 'checked'; // Направлена на выплату
    public const Closed = 'closed'; // Выплачена и закрыта
}
