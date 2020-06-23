<?php
/**
 * Created by PhpStorm.
 * User: dzg
 * Date: 2018/5/18
 * Time: 11:34
 */

namespace lib;

class DB
{
    public $DB = null;
    protected $TABLE = '';
    protected $SQL = '';
    protected $WHERE = '';
    protected $LIMIT = '';
    protected $ORDER = '';
    protected $PARAM = [];
    protected $SELECT = '*';

    function __construct($table){
        $this->TABLE = $table;
        $this->DB = NativeDB::getInstance();
    }

    static public function Table($table){
        $object = new DB($table);
        return $object;
    }

    public function setTable($table){
        $this->TABLE = $table;
        return $this;
    }

    public function where($array, $join = 'and'){
        if($array == false) return $this;

        if(is_array($array)){
            $str = Array2Str::arrayToWhere($array, $join);
            $this->PARAM = $array;
        }else{
            $str = ' WHERE '.$array;
        }
        $this->WHERE = $str;
        return $this;
    }

    /**
     * @param int $rows 欲取出的行数
     * @param int $number 从某行开始取
     * @return array $rows 返回结果集
     */
    public function get($rows = 1, $number = 0){
        if($rows < 1){
            $this->LIMIT = '';
        }else{
            $this->LIMIT = " LIMIT {$number},{$rows}";
        }

        $sql = $this->_sql_join($param);
        $sth = $this->DB->prepare($sql);
        $sth->execute($param);
        if($rows == 1){
            $rows = $sth->fetch(\PDO::FETCH_ASSOC);
        }else{
            $rows = $sth->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $rows;
    }


    public function count(&$total, $field = 'id'){
        $sql = "SELECT COUNT(`{$field}`) as `total` FROM `{$this->TABLE}` {$this->WHERE}";
        $total = $this->DB->query($sql)->fetch()['total'];
        return $this;
    }

    public function select($field = '*'){
        if(is_array($field)){
            $str = Array2Str::arrayToField($field);
        }else{
            $str = $field;
        }

        $this->SELECT = $str;
        return $this;
    }

    /**
     * @param string/array $field
     * @param string $sort
     * @return $this
     */
    public function orderBy($field, $sort = "ASC"){
        if(is_array($field)){
            $str = Array2Str::arrayToField($field);
        }else{
            $str = "`{$field}`";
        }

        if($sort === true)
            $this->ORDER = "ORDER BY {$field}";
        else
            $this->ORDER = "ORDER BY {$str} {$sort}";

        return $this;
    }

    public function limit($rows = 1, $number = 0){
        $this->LIMIT = " LIMIT {$number},{$rows}";
        return $this;
    }


    //返回受影响行数
    public function update($array){
        if(is_array($array)){
            $update = Array2Str::arrayToUpdate($array);
        }else{
            $update = $array;
            $array = [];
        }
        $sql = "UPDATE `{$this->TABLE}` SET {$update} {$this->WHERE}";
        $this->SQL = $sql;
        $sth = $this->DB->prepare($sql);
        if($sth->execute(array_merge($array,$this->PARAM)) == false){
            $err = $sth->errorInfo();
            throw new \Exception('MYSQL '.$err[1]. ' '. $err[2]);
        }

        //清除各种条件
        $this->_clear_();
        return $sth->rowCount();
    }


    //默认返回插入后的ID，也可以指定某字段，插入失败返回0
    public function insert($array, $field = 'id'){
        $errors = false;
        if(is_array($array)){
            $field = Array2Str::arrayToField($array,true);
            $content = Array2Str::arrayToContent($array);
            $sql = "INSERT INTO `{$this->TABLE}`({$field}) VALUES ({$content})";
            $sth = $this->DB->prepare($sql);
            if($sth->execute($array) == false){
                $errors = $sth->errorInfo();
            }
        }else {
            $sql = $array;
            if($this->DB->exec($sql) == false){
                $errors = $this->DB->errorInfo();
            }
        }

        if ($errors !== false)
            throw new \Exception("[SQL] $errors[1] $errors[2]");

        $this->SQL = $sql;
        return $this->DB->lastInsertId($field);
    }

    //返回受影响行数
    public function delete(){

        $sql = "DELETE FROM `{$this->TABLE}` {$this->WHERE}";
        $this->SQL = $sql;
        $sth = $this->DB->prepare($sql);
        $sth->execute($this->PARAM);

        //清除各种条件
        $this->_clear_();
        return $sth->rowCount();
    }

/*
    public function save($insert, $update){
        $field = Array2Str::arrayToField($insert,true);
        $_insert = Array2Str::arrayToContent($insert);
        $_update = Array2Str::arrayToUpdate($update);

        $sql = "INSERT INTO `{$this->TABLE}` ({$field}) VALUES ({$_insert}) ON DUPLICATE KEY UPDATE {$_update}";
        $this->SQL = $sql;

        $sth = $this->DB->prepare($sql);
        $result = $sth->execute($insert);
    }
*/
    private function _sql_join(&$param, $is_clear = true){
        $sql = "SELECT {$this->SELECT} FROM `{$this->TABLE}` {$this->WHERE} {$this->ORDER} {$this->LIMIT}";
        $param = $this->PARAM;
        if($is_clear == true) $this->_clear_();
        $this->SQL = $sql;
        return $sql;
    }

    private function _clear_(){
        $this->SELECT = '';
        $this->WHERE = '';
        $this->ORDER = '';
        $this->LIMIT = '';
        $this->PARAM = [];
    }

    public function getSQL(){
        return $this->SQL;
    }

}