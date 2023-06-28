<?php

namespace Helpers;

use mysqli;

class Connection
{
    protected string $db_host = DB_HOST;
    protected string $db_user = DB_USER;
    protected string $db_pass = DB_PASS;
    protected string $db_name = DB_NAME;
    protected mysqli $connection;

    public function __construct()
    {
        $this->connection();
    }

    /**
     * @return void
     */
    public function connection(): void
    {     
        $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        
        if($this->connection->connect_error){
            die('Error de conexion: '. $this->connection->connect_error);
        }
    }
}