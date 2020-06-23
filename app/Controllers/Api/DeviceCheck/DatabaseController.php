<?php
namespace app\Controllers\Api\DeviceCheck;

use app\Models\TBConfigure;
use lib\Input;

class DatabaseController
{


    function databaseTableNumber(){
        return json_encode([
            'status' => true,
            'message'   => 'success',
            'data' => [
                'total' => 5
            ]
        ]);
    }

    // 在某个版本中，数据库需要的所有表
    function getTableList(){
        $version = Input::get("version");
        if ($version == false) {
            return $this->json(false, "未获取到设备版本");
        }

        $row = TBConfigure::Select()
            ->where("key", "database_table_list")
            ->where("version", $version)
            ->where("switch", "1")
            ->first();

        if ($row == false){
            return $this->json(false, "未获取到相应信息");
        }

        $table_list = explode(",", $row['value']);
        return $this->json(true, "success", $table_list);
    }

    // 在某个版本中，某个表的所有字段
    function getTableStruct(){
        $version = Input::get('version');
        $table = Input::get('table');
        if ($version == false){
            return $this->json(false, "未获取到设备版本");
        }

        if ($table == false){
            return $this->json(false, "未获取到要查询的表");
        }

        $row = TBConfigure::Select()
            ->where("key", "t_" . $table . "_struct")
            ->where("version", $version)
            ->where("switch", "1")
            ->first();

        if ($row == false){
            return $this->json(false, "未获取到相应信息");
        }

        $fields = explode(",", $row['value']);
        return $this->json(true, "success", $fields);
    }


    private function json($status, $message, $data = []){
        return json_encode([
            'status'    => $status,
            'message'   => $message,
            'data'      => $data
        ]);
    }

}