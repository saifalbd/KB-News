<?php

use App\Service\DateConvert;

if (!function_exists('is_bd_phone')) {
    function is_bd_phone($num)
    {
        return preg_match('/(^([+]{1}[8]{2}|0088)?(01){1}[3-9]{1}\d{8})$/', $num);
    }
}


function post_date($date,$showDay=false){
    $rep = new DateConvert;

    return $rep->convert($date,$showDay);
 
}


function make_slug($str){
return preg_replace('/\s+/', '-', $str);
}


if (!function_exists('str_limit')) {
    function str_limit($str,$limit,$end="...")
    {
        return Illuminate\Support\Str::limit($str,$limit,$end);
    }
}