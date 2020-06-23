<?php


namespace app\Controllers;


use app\Models\TBDevices;
use lib\Input;
use lib\Validation;
use lib\View;
use lib\NativeDB;

class DevicesManageController
{
    public function activationView(){
        $product_id = Input::get('id');
        return View::make('devices_manage/activation', ['product_id'=> $product_id, 'token' => token()]);
    }

    public function index(){
        return View::make('devices_manage/devices_list');
    }

    //添加设备页面
    public function addView(){
        $id = Input::get('id',false);
        $data = [
            'id'        => 0,
            'warrant'   => '365',
        ];
        if($id != false){
            $data = TBDevices::Table()->where(['id' => $id])->get();
        }
        return View::make('devices_manage/add_device', ['data' => $data]);
    }

    public function getList(){
        $page = Input::get('page', 1);
        $rows = Input::get('rows', 12);
        $keyword = Input::get('keyword', '');
        $type = Input::get('keyword_type', '');

        $table = TBDevices::$TABLE;
        $where = "WHERE `switch`='1' ";
        if($keyword == true && $type == true){
            $where .= "AND {$type} like '%{$keyword}%' ";
        }

        $db = NativeDB::getInstance();
        $res = $db->query("SELECT COUNT(`id`) AS `count` FROM {$table} {$where}", \PDO::FETCH_ASSOC);
        $total = $res->fetch()['count'];

        $index = ($page - 1) * $rows;
        $items = $db->query("SELECT * FROM {$table} {$where} LIMIT {$index},{$rows}", \PDO::FETCH_ASSOC)->fetchAll();

        $this->formatData($items);

        return json_encode(["total" => (int)$total, "rows" => $items]);
    }

    public function formatData(&$items){
        foreach ($items as &$item){
            if (empty($item['company']))
                $item['company'] = '-';
            if (empty($item['contact']))
                $item['contact'] = '-';
            if (empty($item['phone']))
                $item['phone'] = '-';
            if (empty($item['tel']))
                $item['tel'] = '-';
            if (empty($item['email']))
                $item['email'] = '-';
        }
    }




    //添加设备
    public function add(){
        $id = Input::post('id');
        $param['product_id'] = Input::post('product_id');
        $param['company'] = Input::post('company', '');
        $param['contact'] = Input::post('contact', '');
        $param['phone'] = Input::post('phone', '');
        $param['tel'] = Input::post('tel', '');
        $param['email'] = Input::post('email', '');
        $param['warrant'] = Input::post('warrant', '365');
        $param['key'] = $this->key($param['product_id'], $param['warrant']);

        if($param['product_id'] == false){
            return '{"status":0, "message":"请填写产品标识"}';
        }
        if($param['key'] == false){
            return '{"status":0, "message":"产品KEY计算失败"}';
        }

        if($id == false){
            $row = TBDevices::Select(['product_id'])
                ->where('product_id', $param['product_id'])
                ->where("switch", "1")
                ->first();
            if (!empty($row['product_id'])){
                return '{"status":0, "message":"'.$row['product_id'].' 标识已存在"}';
            }

            $param['update_time'] = date('Y-m-d H:i:s');
            $result = TBDevices::Table()->insert($param);
        }else{
            $result = TBDevices::Table()->where(['id' => $id])->update($param);
        }

        if($result == false){
            return '{"status":0, "message":"提交失败"}';
        }
        return '{"status":1, "message":"success"}';
    }

    public function del(){
        $id = Input::get('id', 0);
        if($id == false)
            return '{"status":0, "message":"删除失败，id = false"}';

        $res = TBDevices::Table()->where(['id' => $id])->update(['switch' => '0']);
        if($res == false)
            return '{"status":0, "message":"删除失败，id可能不存在"}';

        return '{"status":1, "message":"success"}';
    }

    function key($pro_id, $time){
        $hash = md5($pro_id);
        $hash = md5('WHOLETON'.$hash);
        $hash = md5($hash.'wholeton');
        $hash = md5('hed'. $hash . 'hed');
        $hash = md5('time:'.$time.$hash);

        $key = '';
        for ($i=1; $i<=strlen($hash); $i++){
            $key .= $hash[$i-1];
            if ($i % 6 == 0){
                $key .= '-';
            }
        }

        return strtoupper($key);
    }


    //激活设备
    function activation(){
        $product_id = Input::post('product_id');
        $param['company'] = Input::post('company', '');
        $param['contact'] = Input::post('contact', '');
        $param['phone'] = Input::post('phone', '');
        $param['email'] = Input::post('email', '');

        //检查产品标识是否存在
        $row = TBDevices::Table()->where(['product_id' => $product_id, 'switch' => '1'])->get();
        if($row == false)
            return '{"status":0, "message":"产品未备案，请联系销售方！"}';

        // 是否已经激活过
        if($row['status'] == true) {
            if ($row['phone'] != $param['phone'])
                return '{"status":0, "message":"产品已激活，预留号码 '. $this->maskPhoneNumber($row['phone']) .'<br />请输入正确手机号获取KEY"}';

            return '{"status":1, "message":"信息正确，您的KEY：<br/>'.$row['key'].'"}';
        }

        //检查公司名称
        if(strlen($param['company']) < 12)
            return '{"status":0, "message":"请填写公司全称！"}';

        if(strlen($param['contact']) < 6)
            return '{"status":0, "message":"请填写联系人名称"}';

        //检查手机号格式是否正确
        if(Validation::isPhone($param['phone']) == false){
            return '{"status":0, "message":"请输入正确的手机号"}';
        }

        if($param['email'] == true){
            //检查邮箱格式是否正确
            if(Validation::isEmail($param['email']) == false){
                return '{"status":0, "message":"请输入正确的邮箱"}';
            }
        }

        $param['time'] = date('Y-m-d');
        $param['status'] = 1;
        TBDevices::Table()->where(['product_id' => $product_id])->update($param);
        return '{"status":1, "message":"激活成功，您的KEY：<br/>'.$row['key'].'"}';
    }


    /**
     * 设备向云端发起请求，获取激活KEY
     * @return string
     */
    public function getDeviceKey(){
        $code = Input::post('code', false);
        if($code == false)
            return '{"status":0, "message":"设备ID不能为空"}';

        $item = TBDevices::Table()->where(['product_id' => $code, 'switch' => 1])->get();
        if($item == false)
            return '{"status":0, "message":"产品未备案，请联系销售方！"}';

        if($item['status'] != '1')
            return '{"status":0, "message":"产品未激活，请扫描二维码激活后再次获取"}';

        return '{"status":1, "message":"success", "key":"'.$item['key'].'"}';
    }

    private function maskPhoneNumber($number){
        return substr($number, 0, 4). '*****' .substr($number,-2);
    }
}