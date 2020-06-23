<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/22
 * Time: 16:18
 */

namespace app\Controllers;

use lib\Input;
use \Session;
use lib\DB;

class ReplyController
{
    private $TABLE = 'tb_reply';

    public function addReply(){
        $user = Session::get('loginUser');
        $param['fid'] = Input::post('fid');
        $param['uid'] = $user['id'];
        $param['reply_time'] = date('Y-m-d H:i:s');
        $param['reply_content'] = Input::post('reply_content');

        //对话方向，0.管理员回复客户；1.客户回复管理员
        $param['direction'] = $user['type'] == '1' ? '0' : '1';
        if($param['fid'] == false){
            return '{"code":0,"msg":"提交失败，请重新打开页面后再次提交！"}';
        }

        $db = DB::Table($this->TABLE);
        $db->DB->beginTransaction(); //开启事务

        //tb_reply 插入对话数据
        $reply_id = $db->insert($param);
        if($reply_id == false){
            $db->DB->rollBack(); //回滚事务
            return '{"code":0,"msg":"提交失败，请重稍后再试！"}';
        }

        //tb_feedback 更新状态
        $update_value = $this->_updateValue($user);
        $num = $db->setTable('tb_feedback')->where(['id'=>$param['fid']])->update($update_value);
        if($num == false){
            $db->DB->rollBack(); //回滚事务
            return '{"code":0,"msg":"提交失败，请重稍后再试！"}';
        }

        //提交事务
        if($db->DB->commit() == false){
            return '{"code":0,"msg":"提交失败，事务处理错误"}';
        }

        return '{"code":1,"msg":"提交成功！"}';
    }

    public function getReplyRows($fid){
        return DB::Table($this->TABLE)->where(['fid'=>$fid])->orderBy('reply_time')->get(0);
    }


    private function _updateValue($user){
        $param['reply_time'] = date('Y-m-d H:i:s');
        if($user['type'] == '1'){
            $param['reply_status'] = '1'; //已回复
            $param['admin'] = $user['id'];
        }else{
            $param['reply_status'] = '2'; //等待回复
        }

        return $param;
    }
}