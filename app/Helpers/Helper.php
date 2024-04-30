<?php


if (!function_exists('getImage')) {
    function getImage($image, $folder)
    {
       
        if(!empty($image)){
            return asset('storage/'.$folder.'/' . $image);
        }
        return asset('noimg.png');
    }
}