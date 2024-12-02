<?php

use App\enum\ExpenditureCategoryEnum;
use App\enum\ExpenditureTypeEnum;

if (!function_exists('getImage')) {
    function getImage($image, $folder)
    {
       
        if(!empty($image)){
            return asset('storage/'.$folder.'/' . $image);
        }
        return asset('noimg.png');
    }
}

if (!function_exists('getExpenditureType')) {
    function getExpenditureType($expenditureType)
    {
        if($expenditureType == ExpenditureTypeEnum::CREDIT){
            return 'badge bg-success';
        }
        return 'badge bg-danger';
    }
}

if (!function_exists('getExpenditureCategory')) {
    function getExpenditureCategory($expenditureCategory)
    {
        $donationCategories = [
            // ExpenditureCategoryEnum::DONATION,
            // ExpenditureCategoryEnum::DISTRICT_GRAND,
            // ExpenditureCategoryEnum::BLOOD_CONATION_CAMP,
            // ExpenditureCategoryEnum::FIXED_DIPOSIT_INTEREST,
            // ExpenditureCategoryEnum::INTEREST_IN_BANK,
            // ExpenditureCategoryEnum::OTHER_CONTRIBUTION
            ExpenditureCategoryEnum::SERVICE,
            ExpenditureCategoryEnum::ADMINISTRATIVE,
            ExpenditureCategoryEnum::WELFARE,
            
        ];
        if(in_array($expenditureCategory, $donationCategories)){
            return 'badge bg-info text-dark';
        }
        if($expenditureCategory == ExpenditureCategoryEnum::SERVICE){
            return 'badge bg-secondary';
        }
        if($expenditureCategory == ExpenditureCategoryEnum::ADMINISTRATIVE){
            return 'badge bg-warning text-dark';
        }
        return 'badge bg-danger';
    }
}
