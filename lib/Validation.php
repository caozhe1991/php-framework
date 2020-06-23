<?php


namespace lib;


class Validation
{
    static function isPhone($phone){
        $preg = '/^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(17[0,1,3,5,6,7,8]))\d{8}$/';
        return preg_match($preg, $phone);
    }

    static function isTel($tel){
         $preg = '/^([0-9]{3,4}-)?[0-9]{7,8}$/';
        return preg_match($preg, $tel);
    }

    static function isEmail($email){
        $preg = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/';
        return preg_match($preg, $email);
    }

}