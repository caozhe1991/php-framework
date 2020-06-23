<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/15
 * Time: 17:10
 */

namespace lib;


class Exception
{
    static private $ERROR = '#F33958';
    static private $WARNING = '#EDA712';
    static private $INFO = '#0F67AD';





    static public function Error($message = "", $code = 0, Exception $previous = null){
        $message = '<span style="font-weight: 700; color: '.self::$ERROR.'">'.$message.'</span>';
        self::_throwError($message, $code, $previous);
    }
    static public function Warning($message = "", $code = 0, Exception $previous = null){
        $message = '<span style="font-weight: 700; color: '.self::$WARNING.'">'.$message.'</span>';
        self::_throwError($message, $code, $previous);
    }
    static public function Info($message = "", $code = 0, Exception $previous = null){
        $message = '<span style="font-weight: 700; color: '.self::$INFO.'">'.$message.'</span>';
        self::_throwError($message, $code, $previous);
    }

    static private function _throwError($message = "", $code = 0, Exception $previous = null){
        throw new \Exception($message, $code, $previous);
    }
}