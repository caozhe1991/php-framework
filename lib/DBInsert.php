<?php


namespace lib;


class DBInsert
{
    private $TABLE_NAME = '';
    private $VALUES = [];

    function __construct(string $tn)
    {
        $this->TABLE_NAME = $tn;
    }


    /**
     * 向模型中添加单列数据
     * @param string $key
     * @param $value
     * @return DBInsert
     */
    public function add(string $key, $value) : DBInsert{
        $this->VALUES[$key] = $value;
        return $this;
    }

    /**
     * 添加一组数据，请使用关联数组，key为字段名称，value为字段值
     * @param array $column
     * @return DBInsert
     */
    public function adds(array $column) : DBInsert{
        $this->VALUES = array_merge($this->VALUES, $column);
        return $this;
    }

    /**
     * 保存数据，返回最后插入id
     * @return int
     * @throws \Exception
     */
    public function save() : int{
        $keys = array_keys($this->VALUES);
        $column = implode('`,`', $keys);
        $value = implode(', ', array_fill(0, count($keys), '?'));

        $sql = "INSERT INTO `{$this->TABLE_NAME}`(`{$column}`) VALUES ({$value})";
        try{
            $db = NativeDB::getInstance();
            $sth = $db->prepare($sql);
            if($sth->execute(array_values($this->VALUES)) == false){
                $err = $sth->errorInfo();
                throw new \Exception('MYSQL '.$err[1]. ' '. $err[2]);
            }
            return intval($db->lastInsertId());
        }catch (\PDOException $exception){
            throw new \Exception($exception->getMessage().'；SQL: '.$sql);
        }
    }

}