<?php
namespace app\Groups;


use lib\Group;

class Api extends Group
{
    public function exec()
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Methods:GET,POST,OPTIONS");
        header("Content-Type:text/plain;charset=UTF-8");
        return true;
    }
}