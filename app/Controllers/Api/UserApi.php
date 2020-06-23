<?php
/**
 * Created by PhpStorm.
 * User: wholeton-cz
 * Date: 2019/1/11
 * Time: 18:55
 */

namespace app\Controllers\Api;


use app\Models\TBUser;
use lib\Input;

class UserApi
{

    function checkUser(){
        $param['device_id'] = Input::post('device_id');
        $param['user'] = Input::post('user');
        $param['password'] =Input::post('password');
        $param['cloud_id'] = Input::post('cloud_id');

        if($param['cloud_id'] == false)
            $user_info = $this->registerUser($param);
        else
            $user_info = TBUser::Table()->where(['cloud_id' => $param['cloud_id']])->get();

        if($user_info == false || $user_info['cloud_id'] == false){
            $user_info = [
              'cloud_id' => '',
              'integral' => '',
              'email'    => '',
              'skin'     => 'default',
              'font'     => '微软雅黑',
            ];
        }

        echo json_encode([
            'status'=>1,
            'data'=>[
                'cloud_id' => $user_info['cloud_id'],
                'integral' => $user_info['integral'],
                'email'    => $user_info['email'],
            ],
            'config' => [
                'skin'     => $user_info['skin'],
                'font'     => $user_info['font'],
            ]
        ]);
    }


    function registerUser($data){
        if($data['user'] == false || $data['password'] == false)
            return false;

        $user = TBUser::Table();
        $user_info = $user->where(['device_id'=>$data['device_id'], 'user' => $data['user']])->get();
        if($user_info == true){
            return $user_info;
        }

        /*
        $uuid_conf = ROOT_PATH . '/config/uuid.conf';
        $hand = fopen($uuid_conf,'r+');
        flock($hand, LOCK_EX);
        $uuid = fgets($hand);
        fseek($hand, 0);
        fwrite($hand, $uuid + 1);
        flock($hand, LOCK_UN);
        fclose($hand);
        */

        $id = $user->select('id')->orderBy('id', 'DESC')->get();
        $cloud_id = ($id == false) ? 1 : $id['id'] + 1;

        $data['register_time'] = date('Y-m-d H:i:s');
        $data['cloud_id'] = 100000 + $cloud_id;
        $data['skin'] = 'default';
        $data['font'] = '微软雅黑';
        if($user->insert($data) > 0){
            $data['integral'] = 0;
            $data['email'] = '';
            return $data;
        }

        return false;
    }

}