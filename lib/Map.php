<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/16
 * Time: 18:12
 */


class Map {

    static $MAP = [];

    static public function get($key, $default = ''){
        if(array_key_exists($key, self::$MAP)){
            return self::$MAP[$key];
        }

        return $default;
    }

    static public function set($key, $value){
        self::$MAP[$key] = $value;
    }

    static public function add($key, $value){
        if(array_key_exists($key, self::$MAP)){
            return false;
        }

        self::$MAP[$key] = $value;
        return true;
    }

}

class Session {
    static private $STATUS = false;

    static public function get($key, $default = ''){
        self::ss();
        if(array_key_exists($key, $_SESSION)){
            return  $_SESSION[$key];
        }

        return $default;
    }

    static public function getOnce($key, $default = ''){
        self::ss();
        if(array_key_exists($key, $_SESSION)){
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $value;
        }

        return $default;
    }

    static public function set($key, $value){
        self::ss();
        $_SESSION[$key] = $value;
    }

    static public function add($key, $value){
        self::ss();
        if(array_key_exists($key, $_SESSION)){
            return false;
        }

        $_SESSION[$key] = $value;
        return true;
    }

    static public function del($key){
        self::ss();
        if(array_key_exists($key, $_SESSION)){
            unset($_SESSION[$key]);
        }
    }

    static public function clear(){
       self::ss();
        $_SESSION = [];
    }

    static private function ss(){
        if(self::$STATUS == false){
            self::$STATUS = true;
            session_start();
        }

    }
}