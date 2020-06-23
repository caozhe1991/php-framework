<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/15
 * Time: 16:27
 */

namespace lib;


class Group
{
    protected $MESSAGE = '';

    public function exec(){


        return true;
    }


    public function getMessage(){
        return $this->MESSAGE;
    }

    protected function setMessage($message){
        $this->MESSAGE = $message;
    }
}