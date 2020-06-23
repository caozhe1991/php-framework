<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/6/26
 * Time: 10:13
 */

namespace app\Lib;


use lib\Input;

class Page
{
    static public function createPageView($page, $page_all, $url, $key = 'page', $rows = 'rows'){
        $join = strstr($url, '?') ? '&' : '?';
        $r = Input::get($rows);
        if($r == true)
            $r = '&'.$rows.'='.$r;
        else
            $r = '';

        $data['loop'] = $page_all;
        $data['start'] = 1;
        $data['end'] = $page_all;
        if($page_all > 9){
            $data['loop'] = 9;
            $data['start'] = $page > 4 ? $page - 4 : 1;
            $data['end'] = $page_all > 9 ? $page + 4 : 9;
        }
        $next = $page+1 > $page_all ? $page_all : $page+1;
        $last = $page-1 < 1 ? 1 : $page-1;

        $html = '<div class="pagination"><ul class="clearfix"><li><a href="'.$url.$join.$key.'='.$data['start'].$r.'"><<</a></li><li><a href="'.$url.$join.$key.'='.$last.$r.'"><</a></li>';
        for( $i = $data['start']; $i <= $data['end']; $i++){
            $class = '';
            if($i == $page)
                $class = ' class="on" ';
           $html .= '<li ><a '.$class.' href="'.$url.$join.$key.'='.$i.$r.'">'.$i.'</a></li>';
        }
        $html .= '<li><a href="'.$url.$join.$key.'='.$next.$r.'">></a></li><li><a href="'.$url.$join.$key.'='.$page_all.$r.'">>></a></li></ul></div>';
        return $html;
    }


}