<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/15
 * Time: 18:47
 */

namespace app\Groups;


use lib\Group;
use lib\Input;
use \Session;

class Admin extends Group
{


    public function exec()
    {
        $user = Session::get('loginUser');
        if($user['type'] != '1'){
            Redirect('/show/feedback/list');
            return true;
        }

        return true;
    }
}