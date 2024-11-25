<?php

namespace App\enum;

class ExpenditureCategoryEnum
{
    const DONATION = 'Donation';
    const SALARY = 'Salary';
    const MEMBER_PAYMENT = 'Member Payment';

    public static function values(): array
    {
        return [
            self::DONATION,
            self::SALARY,
            self::MEMBER_PAYMENT
        ];
    }
}
