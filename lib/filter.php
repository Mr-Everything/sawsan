<?php

namespace PHPMVC\LIB;

trait Filter
{
    public static function filterString($str){
        return trim(filter_var($str, FILTER_SANITIZE_STRING));
    }
    public static function filterInt($int){
        return filter_var($int, FILTER_SANITIZE_NUMBER_INT);
    }
    public static function filterFloat($float){
        return filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
    public static function isNum($num){
        return $num !== false && is_numeric($num);
    }
    public static function cryptPassword($password){
        $salt = '$2y$10$YMJdyhiJK.NU7Y6qDFOfGO$';
         return crypt($password, $salt);
    }
    public static function CrossSiteScripting($username)
    {
        // it will return 1 if false and 0 if it true
        return preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username) ? true : false ;
//        var_dump(strip_tags($username));
    }
}