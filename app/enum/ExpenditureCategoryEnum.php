<?php

namespace App\enum;

class ExpenditureCategoryEnum
{
    const DONATION = 'Donation';
    const SALARY = 'Salary';
    const MEMBER_PAYMENT = 'Member Payment';
    const DISTRICT_GRAND = 'District Grand';
    const BLOOD_CONATION_CAMP = 'Blood Donation Camp';
    const FIXED_DIPOSIT_INTEREST = 'Fixed Deposit Interest'; 
    const INTEREST_IN_BANK = 'Interest in Bank';
    const OTHER_CONTRIBUTION = 'Other Contribution';
   

    public static function values(): array
    {
        return [
            self::DONATION,
            self::SALARY,
            self::MEMBER_PAYMENT,
            self::DISTRICT_GRAND,
            self::BLOOD_CONATION_CAMP,
            self::FIXED_DIPOSIT_INTEREST,
            self::INTEREST_IN_BANK,
            
            self::OTHER_CONTRIBUTION,
            
        ];
    }
}
