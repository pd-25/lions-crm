<?php

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