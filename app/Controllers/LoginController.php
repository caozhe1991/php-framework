<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/16
 * Time: 18:02
 */

namespace app\Controllers;

use lib\DB;
use lib\Input;

use app\Lib\Message;
use lib\View;
use Session;

class LoginController
{
    private $TABLE = 'tb_account';

    public function showIndex(){


        return View::make('login',['info'=>'']);
    }

    public function login(){
        $user = Input::get('user');
        $password = Input::get('password');

        $rows = DB::Table($this->TABLE)->where(['user'=>$user,'password'=>$password])->get();
        if($rows == false){
            Session::set('error', '账号或密码错误！');
            return Redirect('/login');
        }


        //Session::set('deviceID', 'ID: 00 00 00 00 00 00 00 00');
        Session::set('loginUser', $rows);
        Redirect('/');
    }

    public function logout(){
        Session::clear();
        Redirect('/login');
    }


    public function autoLogin(){
        $deviceID   = Input::get('cid','');
        $time       = Input::get('t','');
        $token      = Input::get('token','');
        $version    = Input::get('ver');
        $distribution_company = Input::get('dc','');


        //验证Token是否正确
        $new_token = $this->_createToken($deviceID, $time, $version, $distribution_company);
        if($new_token !== $token){
            return Message::show('对不起，您的信息无法通过验证1！');
        }

        //验证时间，10分钟内有效
        $time = explode('.', $time);
        $new_time = time();
        if($time[0] - 600 > $new_time || $time[0] + 600 < $new_time){
            return Message::show('对不起，请刷新您的页面后再次进入！');
        }

        //解密分销公司
        $distribution_company = base64_decode(base64_decode($distribution_company.'==').'==');
        if($distribution_company == false){
            return Message::show('对不起，您的信息无法通过验证！');
        }

        //解密CPU序列号
        $cpu_id = base64_decode(base64_decode($deviceID.'==').'==');
        //var_dump($cpu_id);
        if($cpu_id == false){
            return Message::show('对不起，您的信息无法通过验证！');
        }

        //设备是否已经注册
        $user = new UserController();
        $user_info = $user->deviceIDtoUser($cpu_id);
        if($user_info == false){
            return (new UserController())->selfRegisterView($deviceID, $version, $distribution_company);
            //return Message::show('对不起，您的设备未注册！将为您跳转到自助注册页...', url(''));
        }
        $user->updateDeviceVersion($user_info['id'], $version);
        $user_info['device_version'] = $version;

        //Session::set('deviceID', $cpu_id);
        Session::set('loginUser', $user_info);
        Redirect('/');
    }

    private function _createToken($deviceID,$time,$version,$distribution_company){
       //return md5($deviceID.'-WHOLETON-'.$time).md5(md5($time.'-wholeton-'.$version).'-wholetom-'.$distribution_company);
        return md5(md5($deviceID.$version.$distribution_company.$time).'wholeton888');
    }
}