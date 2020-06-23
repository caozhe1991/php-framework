<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/15
 * Time: 15:01
 */

namespace lib;


class Route
{
    static private $ROUTES = [];
    static public $route;

    static public function method($route){
        $route = self::_getRoute($route);
        if ($route['request'] != 'ANY'){
            $request = $_SERVER['REQUEST_METHOD'];
            if($request != $route['request']){
                throw new \Exception('The pages you have accessed do not exist.');
            }
        }

        if($route['group'] != false){
            self::_execGroup($route['group']);
        }

        $arr = explode('@', $route['method']);
        if(count($arr) != 2){
            throw new \Exception('Methods do not exist.');
        }

        self::$route = $route;
        $obj_class = '\\app\\Controllers\\'.$arr[0];
        $obj_method = $arr[1];
        $obj = new $obj_class();
        echo $obj -> $obj_method();
    }

    static public function get($route, $method, $group = false){
        self::_set($route, $method, 'GET', $group);
    }


    static public function post($route, $method, $group = false){
        self::_set($route, $method, 'POST', $group);

    }


    static public function any($route, $method, $group = false){
        self::_set($route, $method, 'ANY', $group);
    }

    static private function _set($route, $method, $request, $group = false){
        $index = self::_getIndex($route);
        $tempR = [
            'route' => $route,
            'request' => $request,
            'method' => $method,
            'group' => $group
        ];

        self::$ROUTES[$index][] = $tempR;
    }

    static private function _getIndex($route){
        if ($route == '') throw new \Exception('Routing can not be empty.');

        if(strlen($route) < 2) {
            $index = 'a';
        } else{
            $index = $route[1];
        }

        return $index;
    }

    static private function _getRoute($route){
        if($route == '') $route = '/';
        $index = self::_getIndex($route);
        if(!array_key_exists($index, self::$ROUTES)){
            throw new \Exception('This route does not exist!');
        }
        $routes = self::$ROUTES[$index];
        foreach ($routes as $item){
            if($item['route'] == $route){
                self::$route = $item['route'];
                return $item;
            }
        }
        throw new \Exception('This route does not exist!');
    }

    static private function _execGroup($group){
        if(is_string($group)){
            $group = [$group];
        }

        if(is_array($group)){
            foreach ($group as $g){
                $obj_class =  '\\app\\Groups\\'.ucfirst($g);
                $obj = new $obj_class();
                if(!$obj -> exec()){
                    header('HTTP/1.0 500 Authentication Failed');
                    exit($obj->getMessage());
                }
            }
        }else{
            throw new \Exception('Group formatting error.');
        }
    }

}