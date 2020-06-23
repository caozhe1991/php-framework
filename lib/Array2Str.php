<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2017/12/28
 * Time: 12:01
 */

namespace lib;


class Array2Str
{

    /** 将一个数组转换到字符串，处理查询的字段
     * @param $fields ['id','user','pass']
     * @return string `id`,`user`,`pass`
     */
    static public function arrayToField( $fields ,$isKey = false){
        $field = $fields;
        if(is_array($fields)){
            $field = '';
            foreach ($fields as $key => $value) {
                if($isKey){
                    $field .= "`{$key}`,";
                }else{
                    $field .= "`{$value}`,";
                }

            }
            $field = rtrim($field,',');
        }
        return $field;
    }


    /** 将一个数组转换到字符串，用于where条件处理
     * @param $wheres ['id'=>'5','user'=>'admin','pass'=>'admin888']
     * @param string $join
     * @return string `id`=:id and `user`=:user and `pass`=:pass
     */
    static public function arrayToWhere($wheres, $join = 'and'){
        $where = $wheres;
        if(is_array($where)){
            $where = '';
            foreach ($wheres as $key => $value) {

                if($key == 'raw()'){
                    $where .= ' '.$value;
                }else{
                    $where .= " {$join} `{$key}`=:{$key}";
                }

            }
            $where = ltrim($where, ' '.$join);
        }
        if($where != '') $where = ' WHERE '.$where;
        return $where;
    }


    /** 将一个数组转换到字符串
     * @param $contents ['id'=>'xxx','user'=>'xxx','pass'=>'xxx']
     * @return string :id, :user, :pass
     */
    static public function arrayToContent($contents){
        $content = $contents;
        if(is_array($content)){
            $content = '';
            foreach ($contents as $key => $value) {
                $content .= ":{$key}, ";
            }
            $content = rtrim($content,', ');
        }
        return $content;
    }


    /** 将一个数组转换到字符串
     * @param $contents ['id'=>'xxx','user'=>'xxx','pass'=>'xxx']
     * @return string `id`=:id, `user`=:user, `pass`=:pass
     */
    static public function arrayToUpdate($contents){
        $content = $contents;
        if(is_array($content)){
            $content = '';
            foreach ($contents as $key => $value) {
                $content .= "`{$key}`=:{$key}, ";
            }
            $content = rtrim($content,', ');
        }
        return $content;
    }

}