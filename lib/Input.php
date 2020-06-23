<?php
namespace lib;
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2017/12/27
 * Time: 14:30
 */

class Input{
    static $filter_char = [
        '<'  => '',
        '>'  => '',
        '\'' => '',
        '"'  => '',
        '&'  => '',
        ';'  => '',
    ];

    static public function get($name, $value = null){
        $v = isset($_GET[$name]) ? $_GET[$name] : $value;
        if($v === $value){
            $v = isset($_POST[$name]) ? $_POST[$name] : $value;
        }

        return self::filter($v, self::$filter_char);
    }

    static public function post($name, $value = null){
        $v = isset($_POST[$name]) ? $_POST[$name] : $value;
        if($v === $value){
            $v = isset($_GET[$name]) ? $_GET[$name] : $value;
        }
        return self::filter($v, self::$filter_char);
    }

    private static function filter($data, $unusual){
        $new_data = $data;
        if(is_string($data)){
            $new_data = strtr($data, $unusual);
        }
        else if (is_array($data)){
            foreach ($data as $key => $value){
                if(is_array($value)){
                    $new_data[$key] = self::filter($value, $unusual);
                }else{
                    $new_data[$key] = strtr($value, $unusual);
                }
            }
        }
        return $new_data;
    }

}