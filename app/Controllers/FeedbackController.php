<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/17
 * Time: 18:35
 */

namespace app\Controllers;


use lib\Input;
use lib\View;
use lib\DB;
use \Session;
class FeedbackController
{
    private $TABLE = 'tb_feedback';

    private $SOURCE = [
        '0' => '未知来源',
        '1' => '设备跳转',
        '2' => '用户登录',
    ];

    public $TYPE = [
        '0' => '未分类',
        '1' => '问题或BUG',
        '2' => '意见或建议',
    ];

    public $REPLY = [
        '0' => '未回复',
        '1' => '已回复',
        '2' => '等待回复'
    ];

    public $STATUS = [
        '0' => '未完成',
        '1' => '已完成',
        '2' => '已关闭'
    ];


    //打开新增反馈信息页面
    public function showAddFeedbackView(){
        $user = Session::get('loginUser');
        return View::make('feedback/feedback_add_item',['source'=>$user['company'],'version'=>$user['device_version']]);
    }


    //添加用户反馈
    public function AddFeedbackItem(){
        $user = Session::get('loginUser');
        $param['source']      = Input::post('source','0');
        $param['version']     = Input::post('version','0000.00');
        $param['type']        = Input::get('type','');
        $param['title']       = Input::get('title','');
        $param['describe']    = Input::get('describe','');
        $param['create_time'] = date('Y-m-d H:i:s');
        $param['uid']         = $user['id'];

        if($lastId = DB::Table($this->TABLE)->insert($param)){
            Redirect('/');
        }

        return $this->_showInfo('您的信息提交失败，请稍后再试。');
    }

    public function showFeedbackItem(){
        $fid = base64_decode(Input::get('id'));
        if($fid == false){
            return $this->_showInfo('您查看的反馈信息不存在');
        }

        $row = DB::Table($this->TABLE)->where(['id'=>$fid])->get();
        if($row == false){
            return $this->_showInfo('您查看的反馈信息不存在');
        }

        //取出管理员和用户的名称、头像信息
        $user = new UserController();
        $admin = $user->getUserInfo($row['admin']);
        if($admin == false){
            $admin = ['name'=>'', 'portrait'=>''];
        }
        $user = $user->getUserInfo($row['uid']);
        $users = [
            'admin' => ['name'=>$admin['name'], 'portrait'=>$admin['portrait']],
            'user'  => ['name'=>$user['name'],  'portrait'=>$user ['portrait']],
        ];

        //取出所有的对话消息
        $replys = (new ReplyController())->getReplyRows($fid);

        return View::make('feedback/feedback_show_item',['feedback'=>$row, 'replys'=>$replys, 'users'=>$users]);
    }

    //更新状态
    public function updateFeedbackStatus($param,$where){
        return DB::Table($this->TABLE)->where($where)->update($param);
    }

    //完成反馈信息
    public function overFeedback(){
        $fid = Input::get('fid');
        $user = Session::get('loginUser');
        if($user['type'] == '1'){
            return '{"code":0,"msg":"管理员不允结束反馈！"}';
        }
        $num = DB::Table($this->TABLE)->where(['id'=>$fid, 'uid'=>$user['id']])->update(['status'=>'1']);
        if($num == false){
            return '{"code":"0","msg":"操作失败，请重新打开后再次操作！"}';
        }

        return '{"code":"1", "msg":"操作成功！"}';
    }


    //取出反馈列表
    public function getFeedbackList(){
        $page = Input::get('page', '1');
        $rows = Input::get('rows', '20');

        $user = Session::get('loginUser');
        $where = [];
        $sql = 'select count(`id`) as count from`tb_feedback`';
        if($user['type'] != '1'){
            $where['uid'] = $user['id'];
            $sql = 'select count(`id`) as count from `tb_feedback` where uid='.$user['id'];
        }
        
        $feedback = DB::Table($this->TABLE);
        $count = $feedback->DB->query($sql)->fetch(\PDO::FETCH_ASSOC)['count'];
        $feedback_list = $feedback->select(['id','type','title','status','source','reply_status','create_time'])
                                  ->where($where)
                                  ->orderBy('create_time', 'DESC')
                                  ->get($rows, ($page - 1) * $rows);
        
        return View::make('/feedback/feedback_show_list', ['total' => ceil($count / $rows), 'page' => $page, 'rows' => $feedback_list, 'obj' => $this]);
    }


    private function _showInfo($msg){
        return "<h2>{$msg}</h2>";
    }
}