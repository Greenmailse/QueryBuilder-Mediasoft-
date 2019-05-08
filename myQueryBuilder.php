<?php
$config = array('localhost','root','','bdwatches');

class myQueryBuilder
{
    public $link;
    public $query;
    function __construct($config) {
        $this->link = mysqli_connect("localhost", "root", "","bdwatches");
        mysqli_set_charset($this->link, 'utf8');
        if (!$this->link) {
            die('Ошибка соединения: ' . mysqli_error($this->link));
        }
    }

    public function select($field1=null,$field2=null,$field3=null,$field4=null,$field5=null,$field6=null,$field7=null,$field8=null,$field9=null,$field10=null,$fields="*"){
        $this->query = "SELECT ";
        if(!empty($field1)){
            $field1 = mysqli_real_escape_string($this->link,$field1);
            $this->query.= " `{$field1}`";
            if(!empty($field2)){
                $field2 = mysqli_real_escape_string($this->link,$field2);
                $this->query.= " ,`{$field2}`";
                if(!empty($field3)){
                    $field3 = mysqli_real_escape_string($this->link,$field3);
                    $this->query.= " ,`{$field3}`";
                    if(!empty($field4)){
                        $field4 = mysqli_real_escape_string($this->link,$field4);
                        $this->query.= " ,`{$field4}`";
                        if(!empty($field5)){
                            $field5 = mysqli_real_escape_string($this->link,$field5);
                            $this->query.= " ,`{$field5}`";
                            if(!empty($field6)){
                                $field6 = mysqli_real_escape_string($this->link,$field6);
                                $this->query.= " ,`{$field6}`";
                                if(!empty($field7)){
                                    $field7 = mysqli_real_escape_string($this->link,$field7);
                                    $this->query.= " ,`{$field7}`";
                                    if(!empty($field8)){
                                        $field8 = mysqli_real_escape_string($this->link,$field8);
                                        $this->query.= " ,`{$field8}`";
                                        if(!empty($field9)){
                                            $field9 = mysqli_real_escape_string($this->link,$field9);
                                            $this->query.= " ,`{$field9}`";
                                            if(!empty($field10)){
                                                $field10 = mysqli_real_escape_string($this->link,$field10);
                                                $this->query.= " ,`{$field10}`";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        else{
            $this->query = "SELECT {$fields}";
        }
        return $this->query;
    }

    public function update($table,$field,$symbol,$value){
        if(empty($symbol)){
            $symbol = "=";
        }
        if(!empty($table)) {
            $field = mysqli_real_escape_string($this->link, $field);
            $table = mysqli_real_escape_string($this->link, $table);
            $this->query = "UPDATE `{$table}` SET `{$field}` {$symbol} {$value}";
        }
        else{
            echo 'Попытка использования пустой конструкции Update!';
        }
        return $this->query;
    }

    public function insert($table,$field,$value){
        if(!empty($table)){
            $table = mysqli_real_escape_string($this->link,$table);
            if(!empty($field)){
                $field = mysqli_real_escape_string($this->link,$field);
                if(!empty($value)){
                    $value = mysqli_real_escape_string($this->link,$value);
                    $this->query = "INSERT INTO `{$table}` (`{$field}`) VALUES ({$value})";
                }
                else{
                    echo 'Переданно пустое значение(конструкция INSERT)!';
                }
            }
            else{
                echo 'Передано пустое значение таблицы(конструкция INSERT)!';
            }

        }
        else{
            echo 'Попытка использования пустой конструкции INSERT!';
        }

        return $this->query;
    }

    public function delete($table){
        if(!empty($table)){
            $table = mysqli_real_escape_string($this->link,$table);
            $this->query = "DELETE FROM `{$table}`";
        }
        else{
            echo 'Попытка использования пустой конструкции DELETE!';
        }

        return $this->query;
    }

    public function from($table){
        if(!empty($table)) {
            $table = mysqli_real_escape_string($this->link, $table);
            $this->query .= " FROM `{$table}`";
        }else{
            echo 'Попытка использования пустой конструкции FROM!';
        }
        return $this->query;
    }

    public function where($field, $symbol,$value)
    {
        $field = mysqli_real_escape_string($this->link,$field);
        $this->query.= " WHERE `{$field}` {$symbol}";
        if (!is_integer($value)) {
            echo 'Попытка передать не числовое значение!(конструкция WHERE)';
        }
        else{
            $this->query.= " {$value}";
        }
        return $this->query;
    }

    public function andWhere($field, $symbol, $value = null)
    {
        $this->query.= " AND `{$field}` {$symbol}";
        if (!is_integer($value) && $value[0] != ":" && $value[0] != "?") { //проверка на параметр
            echo 'Попытка передать не числовое значение!(конструкция AND)';
        }
        else{
            $this->query.= " {$value}";
        }
        return $this->query;

    }

    public function orWhere($field, $symbol, $value = null)
    {
        $field = mysqli_real_escape_string($this->link,$field);
        $this->query.= " OR `{$field}` {$symbol}";
        if (!is_integer($value) && $value[0] != ":" && $value[0] != "?") { //проверка на параметр
            echo 'Попытка передать не числовое значение!(конструкция OR)';
        }
        else{
            $this->query.= " {$value}";
        }
        return $this->query;
    }

    public function limit(int $limit, int $offset = NULL)
    {
        if (!empty($limit)) {
            if (is_integer($limit)) { //проверка на параметр

                $this->query.= " LIMIT {$limit}";
            }
            else{
                echo 'Попытка передать не числовое значение в конструкции LIMIT(1 param)!';
            }
            if (!empty($offset)) {
                if (is_integer($offset)){
                    $this->query.= " OFFSET {$offset}";
                }
                else{
                    echo 'Попытка передать не числовое значение в конструкции LIMIT(2 param)!';
                }

            }
        }
        else{
            echo 'Попытка использования пустой конструкции Limit!';
        }
        return $this->query;
    }
    public function orderBy($field)
    {
        if(!empty($field)){
            $field = mysqli_real_escape_string($this->link,$field);
            $this->query.= " ORDER BY `{$field}`";
        }
        else{
            echo 'Попытка использования пустой конструкции OrderBy!';
        }

        return $this->query;
    }
    public function asc()
    {
        $this->query.= " ASC";
        return $this->query;
    }
    public function desc()
    {
        $this->query.= " DESC";
        return $this->query;
    }

    public function groupBy($field1=null,$field2=null,$field3=null,$field4=null,$field5=null)
    {
        $this->query.= " GROUP BY";
        if(!empty(($field1))){
            $field1 = mysqli_real_escape_string($this->link,$field1);
            $this->query.= " `{$field1}`";
            if(!empty($field2)){
                $field1 = mysqli_real_escape_string($this->link,$field2);
                $this->query.= " ,`{$field2}`";
                if(!empty($field3)){
                    $field1 = mysqli_real_escape_string($this->link,$field2);
                    $this->query.= " ,`{$field3}`";
                    if(!empty($field4)){
                        $field1 = mysqli_real_escape_string($this->link,$field2);
                        $this->query.= " ,`{$field4}`";
                        if(!empty($field5)){
                            $field1 = mysqli_real_escape_string($this->link,$field3);
                            $this->query.= " ,`{$field5}`";
                        }
                    }
                }
            }
        }
        else{
            echo 'Попытка использования пустой конструкции GroupBy!';
        }
        return $this->query;
    }

    public function execute(){
        $result = mysqli_query($this->link,$this->query);
        if($result === false){
            echo  mysqli_error($this->link);
            echo  "Запрос не выполнен!";
        }
        else{
            echo  "Строка запроса: ";
            echo  $this->query;
            echo  "<pre>";
            echo  "Запрос успешно выполнен!";
        }
        return $this->query;
    }
}

$base = new myQueryBuilder($config);

$base->select('id','name');
$base->from('product');
$base->where('id','>',10);
$base->andWhere('id','<',13);
$base->orderBy('id');
$base->desc();
$base->execute();