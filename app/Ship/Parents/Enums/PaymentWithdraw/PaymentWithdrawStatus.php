<?php

declare(strict_types=1);

namespace App\Ship\Parents\Enums\PaymentWithdraw;

use BenSampo\Enum\Enum;

// У пользователя может быть только одна сделка накапливаемая
final class PaymentWithdrawStatus extends Enum
{
    public const Init = 'init'; // Инициализирована
    public const Checked = 'checked'; // Ждет подтверждения
    public const Completed = 'completed'; // Выплачена и закрыта
    public const Error = 'error'; // Ошибка
}
