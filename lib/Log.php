<?php
namespace lib;
use lib\Config;
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2017/12/27
 * Time: 14:45
 */
class Log
{

    const NOTICE = 1;
    const WARNING = 2;
    const ERROR = 3;
    static private $ERROR_LEVEL = [
        '0'             => '',
        self::NOTICE    => '[NOTICE ]',
        self::WARNING   => '[WARNING]',
        self::ERROR     => '[ERROR  ]',
    ];




    static public function write($msg, $level = 0){
        $log_file = Config::get('errorLog');
        $Resources = fopen($log_file, 'a+');
        if(!$Resources){
            return false;
        }
        $msg = date('Y-m-d H:i:s').' '.self::$ERROR_LEVEL[$level].' '.$msg."\n";
        $res = fwrite($Resources, $msg);
        fclose($Resources);
        return $res;
    }




}