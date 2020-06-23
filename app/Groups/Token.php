<?php


namespace app\Groups;


use lib\Group;
use lib\Input;

class Token extends Group
{
    public function exec()
    {
        $token = Input::get('token');
        if($token == false)
            $token = Input::get('t');

        if ($token == false){
            $this->errorMessage();
            return false;
        }


        //token格式不符
        $token_arr = explode('.', $token);
        if (count($token_arr) != 2) {
            $this->errorMessage();
            return false;
        }

        //token 过期
        if(time() - $token_arr[0] > 3600){
            $this->errorMessage();
            return false;
        }

        //token不符
        if (md5('wholeton-cz-@2019@-'.$token_arr[0]) != $token_arr[1]) {
            $this->errorMessage();
            return false;
        }

        return true;
    }

    public function errorMessage(){
        //echo '{"status":0, "message":"身份令牌验证失败，刷新后重新"}';
        $this->setMessage('{"status":0, "message":"身份令牌验证失败，刷新后重新"}');
    }
}