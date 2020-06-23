<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/18
 * Time: 14:57
 */

namespace app\Controllers;

use app\Models\TBUser;
use lib\DB;
use lib\Input;
use lib\View;
use Session;
class UserController
{
    private $TABLE = 'tb_user';
    private $IMG_TYPE = ['image/png'=>'.png','image/jpeg'=>'.jpg','image/gif'=>'.gif'];
    private $IMG_SIZE = 0.5 * 1024 * 1024;
    private $IMG_PATH = '/image/portrait';

    private $SEARCH_TYPE = [
        'company'  => '公司名称',
        'distribution_company'  => '分销公司',
        'tel'       => '联系电话',
        'name'      => '用户昵称',
        'device_id' => '设备ID',
        'device_version'        => '设备版本'
    ];

    static public function getLoginID($default = 0){
        return Session::get('uid', $default);
    }

    static function uidToName($uid){
        if($uid == false) return '';
        $row = DB::Table('tb_user')->where(['id'=>$uid])->get();

        if($row == false){
            return '';
        }

        return $row['name'];
    }

    public function deviceIDtoUser($deviceID){
        $row = DB::Table($this->TABLE)->where(['device_id'=> $deviceID])->get();
        if($row){
            return $row;
        }

        return false;
    }



    public function autoLogin($deviceID){
        $user = $this->deviceIDtoUser($deviceID);
        if($user == false){
            return false;
        }

        Session::add('loginUser', $user);
        return true;
    }

    public function getUserInfo($uid){
        return DB::Table($this->TABLE)->where(['id'=>$uid])->get();
    }

    public function updateDeviceVersion($uid, $version){
        return DB::Table($this->TABLE)->where(['id'=>$uid])->update(['device_version'=>$version,'update_time'=>date('Y-m-d H:i:s')]);
    }


    public function addUserView(){
        $user_id = Input::get('id', 0);
        $user_info = [];
        if($user_id == true)
            $user_info = TBUser::Table()->where(['id'=>base64_decode($user_id)])->get();

        if($user_info == false){
            $user_info = [
                'id'        => '0',
                'portrait'  => '',
                'type'      => '2',
                'user'      => '',
                'password'  => '',
                'name'      => '',
                'company'  => '',
                'tel'       => '',
                'email'     => '',
                'device_id' => '',
                'device_version' => '',
                'distribution_company'=>'惠尔顿',
            ];
        }

        return View::make('admin/add_user', ['user_info'=>$user_info]);
    }

    public function addUserItem(){
        $param = Input::post('param');
        if($param['name'] == false){
            return View::make('admin/add_user',['message'=>'请填写客户姓名', 'user_info'=>$param]);
        }
        if($param['type'] == '2'){
            if($param['company'] == false){
                return View::make('admin/add_user',['message'=>'请填写客户公司名称', 'user_info'=>$param]);
            }
            if($param['device_id'] == false){
                return View::make('admin/add_user',['message'=>'请填写设备ID', 'user_info'=>$param]);
            }
        }else{
            if($param['user'] == false){
                return View::make('admin/add_user',['message'=>'请填写登录账号', 'user_info'=>$param]);
            }
            if($param['password'] == false){
                return View::make('admin/add_user',['message'=>'请填登录密码', 'user_info'=>$param]);
            }
        }
        if(($portrait = $this->_getPortrait($meg)) === false){
            return View::make('admin/add_user',['message'=>$meg, 'user_info'=>$param]);
        }

        if($portrait == true){
            $param['portrait'] = $portrait;
        }


        if($param['id'] == true){
            return $this->_userUpdate($param);
        }else{
            return $this->_userInsert($param);
        }
    }

    private function _userInsert($param){
        //新建用户，如果没有上传头像，则指定默认头像
        if($param['portrait'] == false){
            $param['portrait'] = '/image/007.png';
        }
        $param['register_time'] = date('Y-m-d');
        $tb_user = TBUser::Table();
        if($tb_user->where(['device_id'=>$param['device_id']])->get() == true){
            return View::make('admin/add_user',['message'=>'设备ID：'.$param['device_id'].'已存在！', 'param'=>$param]);
        }

        if($tb_user->insert($param) == true){
            Redirect('/user/lists/view');
        }

        return View::make('admin/add_user',['message'=>'添加失败！', 'param'=>$param]);
    }

    private function _userUpdate($param){
        $id = $param['id'];
        unset($param['id']);
        if(TBUser::Table()->where(['id'=>$id])->update($param) == false){
            return View::make('admin/add_user',['message'=>'修改失败！', 'param'=>$param]);
        }

        Redirect('/user/lists/view');
    }


    //新建用户设置头像
    private function _getPortrait(&$err_msg){
        $file = $_FILES['portrait'];

        //var_dump($file);exit;
        if($file['name'] == false){
            return '';
        }

        if($file['error'] != 0){
            $err_msg = '图片上传错误！';
            return false;
        }
        if(array_key_exists($file['type'],$this->IMG_TYPE) == false){
            $err_msg = '图片类型错误，请上传：'.implode(';', $this->IMG_TYPE).'等格式。';
            return false;
        }
        if($file['size'] > $this->IMG_SIZE){
            $err_msg = '图片大小超出！请小于512K';
            return false;
        }

        $new_file = $this->IMG_PATH.'/'.date('Ymd_His').'_'.uniqid().$this->IMG_TYPE[$file['type']];
        if(move_uploaded_file($file['tmp_name'], ROOT_PATH.'/public/resource'.$new_file)){
            return $new_file;
        }

        $err_msg = '图片上传失败！';
        return false;
    }


    public function userListView(){
        $keyword = Input::get('keyword','');
        $search_type = Input::get('search_type','');
        $like = '';
        $search = '';
        if($keyword == true && $search_type == true){
            $like = " {$search_type} LIKE '%{$keyword}%' ";
            $search = "&keyword={$keyword}&search_type={$search_type}";
        }

        
        $page = Input::get('page', 1);
        $rows = Input::get('rows', 15);
        $user_list = TBUser::Table()->where($like)->count($count)->get($rows, ($page-1)*$rows);


        return View::make('admin/list_user', [
            'user_list'=>$user_list,
            'page'=>$page,
            'rows'=>$rows,
            'page_all'=>ceil($count/$rows),
            'keyword'=>$keyword,
            'search_type'=>$search_type,
            'search'=>$search,
            'search_item'=>$this->SEARCH_TYPE,
        ]);
    }


    public function delUser(){
        $id = Input::get('id', '0');
        if($id == false)
            Redirect('/user/lists/view');
        
        $id = base64_decode($id);
        TBUser::Table()->where(['id'=>$id])->delete();

        $search = '';
        $keyword = Input::get('keyword','');
        $search_type = Input::get('search_type','');
        if($keyword == true && $search_type == true){
            $search = "&keyword={$keyword}&search_type={$search_type}";
        }

        $page = ($page = Input::get('page')) == true ? '&page='.$page : '';
        $rows = ($rows = Input::get('rows')) == true ? '&rows='.$rows : '';

        $url = '/user/lists/view'.$page.$rows.$search;
        Redirect($url);
    }


    public function selfRegisterView($device_id, $device_version, $distribution_company){
        $param = [
            'name' => '',
            'company' => '',
            'user'  => '',
            'password' => '',
            'tel'   => '',
            'email' => '',
            'device_id' => $device_id,
            'device_version' => $device_version,
            'distribution_company' => $distribution_company,
        ];


        return View::make('self_register',['param' => $param, 'message' => '']);
    }
    
    public function selfRegisterData(){
        $param = Input::get('param');
        if($param['name'] == false){
            return View::make('self_register',['param' => $param, 'message' => '请填写您的姓名']);
        }
        if($param['company'] == false){
            return View::make('self_register',['param' => $param, 'message' => '请填写您的公司名称']);
        }
        
        $device_id = base64_decode(base64_decode($param['device_id'].'==').'==');
        if($device_id == false){
            return View::make('self_register',['param' => $param, 'message' => '参数错误！请<b>关闭当前页面</b>，重新打开！']);
        }

        //处理头像
        if(($portrait = $this->_getPortrait($meg)) === false){
            return View::make('admin/add_user',['message'=>$meg, 'param'=>$param]);
        }
        if($portrait == true){
            $param['portrait'] = $portrait;
        }


        $param['device_id'] = $device_id;
        $param['type'] = '2';
        if($this->_userInsert($param) == true){
            Redirect('/');
        }else{
            return View::make('self_register',['param' => $param, 'message' => '注册失败！']);
        }
    }

}