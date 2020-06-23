<?php
/**
 * Created by PhpStorm.
 * User: wholeton-cz
 * Date: 2019/1/18
 * Time: 10:31
 */

namespace app\Controllers\Api;


use app\Models\TBArticle;
use lib\Input;

class ArticleApi
{

    public function getList(){
        $page = Input::get('page','1') - 1;
        $rows = Input::get('rows', '5');

        $items = TBArticle::Table()->select(['id','title','label','style','images','author'])->where(['status'=>'0'])->orderBy('time', 'DESC')->get($rows, $page * $rows);
        if($items == false || count($items) < 1){
            return '{"status":0, "message":"未获取到相关数据", "data":[]}';
        }

        return json_encode([
            'status' => 1,
            'message' => 'success',
            'data' => $items
        ]);
    }

    public function getDetail(){
        $id = Input::get('id','0');
        $item = TBArticle::Table()->select(['title', 'author', 'body', 'time'])->where(['id'=>$id, 'status'=>'0'])->get();
        if($item == false){
            return json_encode([
                'status' => 0,
                'message' => '文章不存在或已被移除',
                'data' => []
            ]);
        }

        return json_encode([
            'status' => 1,
            'message' => 'success',
            'data' => $item
        ]);
    }
}
