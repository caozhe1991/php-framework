<?php


namespace lib;


class DBQuery
{
    private $TABLE_NAME = '';
    private $SELECTS = '';
    private $WHERE = '';
    private $WHERE_VALUES = [];
    private $LIMIT = '';
    private $ORDER = '';
    private $GROUP = '';

    public function __construct(string $table_name, array $columns)
    {
        $this->TABLE_NAME = $table_name;
        $this->select($columns);
    }


    public function select(array $array = [] ) : DBQuery {
        if ($array == false || !is_array($array)) {
            $this->SELECTS = '*';
        }else {
            foreach ($array as &$value){
                $value = '`'. $value .'`';
            }
            $this->SELECTS = implode(',', $array);
        }
        return $this;
    }

    public function where(string $column, $value, string $s = "=") : DBQuery{
        if($this->WHERE == false){
            $this->WHERE = " WHERE `{$column}`{$s}?";
        }else{
            $this->WHERE .= " AND `{$column}`{$s}?";
        }
        $this->WHERE_VALUES[] = $value;
        return $this;
    }

    public function orWhere(string $column, $value, string $mark = "=") : DBQuery{
        if($this->WHERE == false){
            $this->WHERE = " WHERE `{$column}`{$mark}?";
        }else{
            $this->WHERE .= " OR `{$column}`{$mark}?";
        }
        $this->WHERE_VALUES[] = $value;
        return $this;
    }

    public function orderBy(string $column, string $order = 'ASC') : DBQuery{
        if ($this->ORDER == false){
            $this->ORDER = " ORDER BY `{$column}` {$order}";
        }else{
            $this->ORDER .= ", `{$column}` {$order}";
        }
        return $this;
    }

    public function limit($page, $rows) : DBQuery{
        $number = ($page - 1) * $rows;
        $this->LIMIT = " LIMIT {$number},{$rows}";
        return $this;
    }

    public function get() : array {
        $sth = $this->query($this->tosql());
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function first() : array {
        $sth = $this->query($this->tosql());
        $res = $sth->fetch(\PDO::FETCH_ASSOC);
        if ($res == false)
            $res = [];

        return $res;
    }

    public function empty() : bool {
        $data = $this->first();
        return  !(bool)$data;
    }

    private function query(string $sql) : \PDOStatement{
        $db = NativeDB::getInstance();
        $sth = $db->prepare($sql);
        if ($sth == false)
            throw new \Exception("SQL: $sql 查询失败");

        if($sth->execute($this->WHERE_VALUES) == false){
            $errors = $sth->errorInfo();
            throw new \Exception(implode(" ", $errors));
        }
        return $sth;
    }

    public function tosql() : string {
        $sql = 'SELECT '. $this->SELECTS .' FROM `'. $this->TABLE_NAME .'`' . $this->WHERE. $this->GROUP. $this->ORDER. $this->LIMIT;
        return $sql;
    }

    public function count(string $column = 'id') : int{
        $sql = 'SELECT COUNT(`'.$column.'`) FROM `'.$this->TABLE_NAME.'`'.$this->WHERE;
        $stm = $this->query($sql);
        return (int)$stm->fetchColumn();
    }

}