<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/18
 * Time: 10:19
 */

namespace app\Controllers;


use lib\DB;
use lib\NativeDB;

class ImageController
{
    private $TABLE = 'tb_images';
    private $IMG_TYPE = ['image/png'=>'.png','image/jpeg'=>'.jpg','image/gif'=>'.gif'];
    private $IMG_SIZE = 2 * 1024 * 1024;

    public function uploadImage(){
        $files = $_FILES;
        if(count($files) < 1){
            return '{"error":"404","data":[]}';
        }

        $result = ['errno'=>'1', 'data'=>[]];
        foreach ($files as $file){
            if($file['error'] == 0 && array_key_exists($file['type'],$this->IMG_TYPE) && $file['size'] <= $this->IMG_SIZE){
                //创建文件名，并写入数据库
                $new_file = $this->createFileName($file['type']);
                //var_dump($new_file);exit;
                if($new_file){
                    if(move_uploaded_file($file['tmp_name'], $new_file['upload_path'])){
                        $result['errno'] = 0;
                        $result['data'][] = $new_file['img_path'].'/'.$new_file['img_name'];
                    }
                }
            }
        }

        return json_encode($result);
    }

    private function createFileName($type){
        $y = date('Y');
        $m = date('m');
        $param['img_path'] = '/resource/image/upload/'.$y.'/'.$m;

        $dir = ROOT_PATH.'/public/resource/image/upload/'.$y;
        //年目录不存在
        if(!is_dir($dir)){
            if(!mkdir($dir)) {
                return '';
            }
        }

        $dir =  ROOT_PATH.'/public/resource/image/upload/'.$y.'/'.$m;
        //月目录不存在
        if(!is_dir($dir)){
            if(!mkdir($dir)) {
                return '';
            }
        }

        $param['uid'] = UserController::getLoginID();
        $param['up_time'] = date('Y-m-d H:i:s');
        $param['img_name'] = uniqid().$this->IMG_TYPE[$type];

        if(DB::Table($this->TABLE)->insert($param)){
            $param['upload_path'] = $dir.'/'.$param['img_name'];
           return $param;
        }

        return '';
    }



}