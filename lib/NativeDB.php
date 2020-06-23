<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/1/16
 * Time: 10:16
 */

namespace lib;

class NativeDB
{

    private static $_instance = null;
   

    private function __construct(){
    }

    private function __clone() {
    }

    static public function getInstance() {

        if (is_null ( self::$_instance ) || isset ( self::$_instance )) {

            $db_conn = Config::get('mysql');

            $dsn = 'mysql:dbname='.$db_conn['dbname'].';host='.$db_conn['host'].';port='.$db_conn['port'];
            self::$_instance = new \PDO($dsn, $db_conn['user'], $db_conn['password']);
            
            self::$_instance->exec("set names {$db_conn['charset']}");
        }
        return self::$_instance;
    }
    
    
    
}