<?php

/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/23
 * Time: 11:15
 */
namespace app\Lib;

class Message
{


    static public function show($msg, $url = ''){
        $js = '';
        if($url != ''){
            $js = '<script type="text/javascript">setTimeout(function() {location.href="'.$url.'"},3000)</script>';
        }
        return '<html><head><meta charset="utf-8"><title>提示：</title></head><body><h2>'.$msg.'</h2></body>'.$js.'</html>';
    }


}