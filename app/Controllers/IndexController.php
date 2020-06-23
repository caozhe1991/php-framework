<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/17
 * Time: 14:32
 */

namespace app\Controllers;


use lib\Input;
use lib\View;
use app\Models\TBFeedback;
use app\Controllers\FeedbackController;
class IndexController
{
    
    public function showIndex(){
        $page = Input::get('page', 1);
        $rows = Input::get('rows', 10);

        $total = 1;

        $feedback = new FeedbackController();

        $user = \Session::get('loginUser');
        $db = TBFeedback::Table();
        $items = $db->select('*')
            ->where("(`admin`='' OR `admin`='{$user['id']}') AND `reply_status` != '1'")
            ->count($total)
            ->orderBy('`reply_status` DESC, `create_time` ASC', true)
            ->get($rows, ($page - 1) * $rows);

        return View::make('admin/index',['items'=>$items, 'page'=>$page, 'page_all'=> ceil($total / $rows), 'type'=>$feedback->TYPE, 'reply_status'=>$feedback->REPLY]);
    }

}