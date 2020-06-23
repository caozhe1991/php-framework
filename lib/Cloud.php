<?php
use lib\Config;
use lib\Input;
use lib\Log;
use lib\Route;

/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2017/12/27
 * Time: 11:34
 */

class Cloud{
    static public function Run(){
        spl_autoload_register(function ($class_name) {
            $class_path =  ROOT_PATH.'/'. str_replace('\\', '/',$class_name ).'.php';

            if(file_exists($class_path)){
                require_once $class_path;
            }else{
                Log::write('类不存在：class = '.$class_name, Log::ERROR);
                throw new \Exception('Class "'.$class_name.'" does not exist');
            }
        });


        error_reporting(E_ALL | E_STRICT);
        if(Config::get('debug')){
            ini_set('display_errors','On');
        }else{
            ini_set('display_errors','Off');
        }

        require_once ROOT_PATH.'/app/routes.php';
        //require_once ROOT_PATH.'/lib/Error.php';
        //var_dump(set_error_handler("errorHandler"));
        self::Route();
    }

/*
    static public function Route(){
        $action = Input::get('action');
        if($action === null){
            Log::write('错误的请求参数：action = null', Log::ERROR);
            exit(json_encode(['code'=>'400', 'msg'=>'错误的请求']));

        }

        $action = explode('/', $action, 2);
        if($action < 2){
            Log::write('错误的请求参数：action = '.$action, Log::ERROR);
            exit(json_encode(['code'=>'400', 'msg'=>'错误的请求']));
        }

        $object = '\\controllers\\'.ucfirst($action[0]);
        $object = new $object();
        $method = $action[1];

        if(!method_exists($object, $method)){
            Log::write('请求方法不存在：'.$action[0].'->'.$method.'()', Log::ERROR);
            exit(json_encode(['code'=>'400', 'msg'=>'错误的请求']));
        }

        $object->$method();
        $object->$method();
    }
*/

    static public function Route(){
        $action = Input::get('action','/');

        /*
        if($action === null){
            Log::write('错误的请求参数：action = null', Log::ERROR);
            exit(json_encode(['code'=>'400', 'msg'=>'错误的请求']));
        }
        */
        Route::method($action);
    }

    static function errorHandler($errno, $errstr, $errfile, $errline){
        header("Code: 500");
        echo $errstr, 'in file ', $errfile, 'line number to', $errline;
        exit();
    }
}

