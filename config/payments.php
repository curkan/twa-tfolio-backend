<?php

declare(strict_types=1);

return [
    'withdraws' => [
        'auto_withdraws_enabled' => env('AUTO_WITHDRAWS_ENABLED', false),
        'minimun_withdraw_amount' => env('MINIMUN_WITHDRAW_AMOUNT', 150000),
        'total_percent' => env('TOTAL_PERCENT', 10),
        'tinkoff_payment_precent' => env('TINKOFF_PAYMENT_PRECENT', 1.2),
        'tinkoff_withdraw_precent' => env('TINKOFF_PAYMENT_PRECENT', 2.5),
    ],
];
