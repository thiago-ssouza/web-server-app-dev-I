<?php

class ManipulateDB
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "dbphpproject";
    private $connection;
    
    public function __construct() {
        
        $this->connection = mysqli_connect(
        $this->host,
        $this->username,
        $this->password,
        $this->database        );
    
        if (!$this->connection) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    }
    
    public function __destruct() {
        mysqli_close($this->connection);
    }
    
    public function getConnection() {
        return $this->connection;
    }
}

