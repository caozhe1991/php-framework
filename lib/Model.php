<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/6/26
 * Time: 15:36
 */

namespace lib;


class Model
{
    static public $TABLE = '';

    static public function Table(){
        if(static::$TABLE == false){
            return false;
        }
        return DB::Table(static::$TABLE);
    }

    static public function Select(array $arr = []) : DBQuery{
        return new DBQuery(static::$TABLE, $arr);
    }


    static public function Insert() : DBInsert{
        return new DBInsert(static::$TABLE);
    }

}