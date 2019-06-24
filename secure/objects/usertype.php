<?php

class UserType {
    
    private $connection;
    private $table_name = "7062prousertype";
    
    public $id;
    public $name;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    function read() {
        
    }
    
    function create() {
        
    }
    
    function update() {
        
    }
    
    function delete() {
        
    }
}
