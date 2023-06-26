<?php
namespace app\Models;

use Exception;
use Helpers\Connection;
use mysqli;

class Model extends Connection
{
    protected $connection;
    protected $query;
    protected $table;
    protected $primaryKey = 'id';

    public function query($sql, $data = [], $params = null){
        if($data){

            $params = $params ?? str_repeat('s', count($data));

            $prepareSql = $this->connection->prepare($sql);        
            $prepareSql->bind_param($params, ...$data);
            $prepareSql->execute();
            $this->query = $prepareSql->get_result();
        }else{
            $this->query = $this->connection->query($sql);
        }
        return $this;
    }

    public function first(){
        return $this->query->fetch_object();
        // return $this->query->fetch_assoc();
    }

    public function get(){
        $return_array = [];
        while($user = $this->query->fetch_object()) {
            $return_array[] = $user;
        }    
        return $return_array;
        // return $this->query->fetch_all(MYSQLI_ASSOC);
    }
    
    //consultas
    public function all(){
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->get();
    }

    public function find($id){
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->query($sql, [$id], 'i')->first();
    }

    public function where($column, $operator , $value = null){
        if($value == null){
            $value = $operator;
            $operator = '=';
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} ?";

        $this->query($sql, [$value]);

        return $this;
    }

    public function create($data){
        
        $columns = array_keys(get_object_vars($data));
        $columns = implode(', ', $columns);
        
        $values = array_values(get_object_vars($data));
        $valuesSql = str_repeat('?, ', count($values) -1 ) . '?';
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$valuesSql})";
        $this->query($sql, $values);

        $last_id = $this->connection->insert_id;
        return $this->find($last_id);
        
    }

    public function update($data){
        
        $id = $data[$this->primaryKey];

        $fields = [];
        foreach($data as $key => $value){
            $fields[] = "{$key} = ?";
        }
        $fields = implode(', ', $fields);

        $sql = "UPDATE {$this->table} SET {$fields} WHERE {$this->primaryKey} = ?";

        $values = array_values($data);
        $values[] = $id;

        $this->query($sql, $values);
        
        return $this->find($id);
    }
    
    public function delete($data){
        if(is_array($data))
            $id = $data[$this->primaryKey];
        else
            $id = $data;

        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $this->query($sql, [$id], 'i');
        return true;
    }

    public function save(){
        
        // $sql = "INSERT INTO {$this->table} () VALUES ({$column}, {$operator}, {$value})";
        // echo $sql;
        // $this->query($sql);
        return $this;
    }
}