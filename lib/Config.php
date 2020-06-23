<?php
namespace lib;
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2017/12/27
 * Time: 11:21
 */

class Config
{

    static private $CONFIG_ALL = null;


    function __construct()
    {
        static::$CONFIG_ALL = include ROOT_PATH.'/config/config.php';
    }

    static public function get($name){
        if(static::$CONFIG_ALL == null){
            static::$CONFIG_ALL = include ROOT_PATH.'/config/config.php';
        }

        return static::$CONFIG_ALL[$name];
    }

    static public function set($key, $value){
        static::$CONFIG_ALL[$key] = $value;
    }

}