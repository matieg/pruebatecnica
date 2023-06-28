<?php
namespace app\Models;

use Helpers\Connection;
use mysqli;

class Model extends Connection
{
    protected mysqli $connection;
    protected $query;
    protected string $table;
    protected string $primaryKey = 'id';

    /**
     * @param string $sql
     * @param array $data
     * @param string|null $params tipo de dato que se va a ejecutar en la sentencia preparada
     * @return Model
     */
    public function query(string $sql, array $data = [], string|null $params = null): Model
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

    public function get(): array
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
     * @param string|int|null $value
     * @return Model
     */
    public function where(string $column, string $operator , string|int|null $value = null): Model
    {
        if($value == null){
            $value = $operator;
            $operator = '=';
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} ?";

        $this->query($sql, [$value]);
        
        return $this;
    }

    /**
     * @param object $data
     * @return object Retorna los datos creados 
     */
    public function create(object $data): object
    {
        
        $columns = array_keys( get_object_vars($data) );
        $columns = implode(', ', $columns);
        
        $values = array_values( get_object_vars($data) );
        $valuesSql = str_repeat('?, ', count($values) -1 ) . '?';
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$valuesSql})";
        $this->query($sql, $values);

        $last_id = $this->connection->insert_id;

        return $this->find($last_id);
    }

    /**
     * @param object|array $data
     * @return object Retorna los datos que se modificaron.
     */
    public function update(object|array $data): object
    {

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
    
    /**
     * Elimina de la base de datos
     * @param array|string|int valor de la clave primaria
     * @return bool
     */
    public function delete($data): bool
    {
        if(is_array($data))
            $id = $data[$this->primaryKey];
        else
            $id = $data;

        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";

        $dataType = is_int($data) ? 'i' : 's';

        $this->query($sql, [$id], $dataType);

        return true;
    }
}