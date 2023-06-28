<?php
namespace app\Models;

use Helpers\Connection;

class Model extends Connection
{
    protected $connection;
    protected $query;
    protected $table;
    protected $primaryKey = 'id';

    /**
     * @param string $sql
     * @param array $data
     * @param string|null $params tipo de dato que se va a ejecutar en la sentencia preparada
     */
    public function query(string $sql, array $data = [], string|null $params = null)
    {
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

    public function first()
    {
        return $this->query->fetch_object();
    }

    public function get()
    {
        $return_array = [];
        while($user = $this->query->fetch_object()) {
            $return_array[] = $user;
        }    
        return $return_array;
        // return $this->query->fetch_all(MYSQLI_ASSOC);
    }
    
    //consultas

    /**
     * @return array Retorna un array con todos los registros de la tabla.
     */
    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        
        return $this->query($sql)->get();
    }

    /**
     * @param string|int $search
     * @return object 
     */
    public function find(int|string $search): object
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";

        $searchType = is_int($search) ? 'i' : 's';
        
        return $this->query($sql, [$search], $searchType)->first();
    }

    /**
     * @param string $column
     * @param string $operator
     * @return object
     */
    public function where($column, $operator , $value = null): object
    {
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

        $data = is_array($data) ? (object) $data : $data;
        
        $id = $data->{$this->primaryKey};

        $fields = [];
        foreach($data as $key => $value){
            $fields[] = "{$key} = ?";
        }
        $fields = implode(', ', $fields);

        $sql = "UPDATE {$this->table} SET {$fields} WHERE {$this->primaryKey} = ?";

        $values = array_values(get_object_vars($data));
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
}