<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/16
 * Time: 15:56
 * @param string $href
 * @return string
 */


function resource(string $href) : string {
    return '/'.trim($href,'/');
}

function asset(string $href) : string {
    return '/'.trim($href,'/');
}

function url(string $url) : string {
    return '/' .trim($url,'/');
}

function Redirect(string $url): void {
    header('Location:/' . trim($url,'/'));
    exit;
}

function get($data, $default = '', $key = ''){
    if(is_array($data)){
        return isset($data[$key]) ? $data[$key] : $default;
    }else {
        return isset($data) ? $data : $default;
    }

}

/**
 * 输出HTML元素选中状态的Class（样式表）
 * @param string $value
 * @param string $key
 * @param string $on
 * @return string
 */
function classOn(string $value, string $key = 'action', string $on = ' class="on" ') : string {
    $r = \lib\Input::get($key, '/');
    if($r == $value)
        return $on;
    return '';
}

/**
 * 判断 Input=checkbox 是否需要选中
 * @param $switch
 * @return string
 */
function checked($switch) : string {
    if(empty($switch) || $switch == false){
        return '';
    }
    return 'checked="checked"';
}



function cat($var){
    global $$var;
    echo $$var;
}

function layout($view){
    include_once ROOT_PATH.'/app/Views/'.ltrim($view, '/').'.blade.php';
}

function token(){
    $time = time();
    $key = md5('wholeton-cz-@2019@-'. $time);
    return $time.'.'.$key;
}


function array2js( $array ){
    $data = "{\n";
    foreach ($array as $key => $value){
        $tmp_data = "";
        if(is_array($value)){
            $tmp_data = array2js($value);
        }

        if(is_int($value))
            $tmp_data = $value;

        if(is_string($value))
            $tmp_data = '"'.$value.'"';

        if(is_bool($value))
            $tmp_data = $value ? "true" : "false";

        $data .=  "$key: $tmp_data, ";
    }
    $data .= "},\n";
    return $data;
}