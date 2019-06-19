<?php

class SubjectLevel {
    
    private $connection;
    private $table_name = "7062prosubjectlevel";
    
    public $id;
    public $name;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    public function read() {
        
    }
    
    public function create() {
        
    }
    
    public function update() {
        
    }
    
    public function delete() {
        
    }
}
