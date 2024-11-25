<?php

namespace App\enum;

class ExpenditureDocEnum
{
    const ADHAR = 'Adhar';
    const PAN = 'PAN';
    const ELECTOR = 'Elector';
    

    public static function values(): array
    {
        return [
            self::ADHAR,
            self::PAN,
            self::ELECTOR,
        ];
    }
}
