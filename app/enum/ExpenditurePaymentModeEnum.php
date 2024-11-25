<?php

namespace App\enum;

class ExpenditurePaymentModeEnum
{
    const UPI = 'UPI';
    const CASH = 'Cash';
    const CARD = 'Card';
    const NETBANKING = 'Net banking';

    public static function values(): array
    {
        return [
            self::UPI,
            self::CASH,
            self::CARD,
            self::NETBANKING
        ];
    }
}
