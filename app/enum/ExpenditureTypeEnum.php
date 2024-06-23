<?php

namespace App\enum;

class ExpenditureTypeEnum
{
    const CREDIT = 'Credit';
    const DEBIT = 'Debit';

    public static function values(): array
    {
        return [
            self::CREDIT,
            self::DEBIT,
        ];
    }
}
