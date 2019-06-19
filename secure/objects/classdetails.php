<?php

class ClassDetails {
    
    private $connection;
    private $table_name = "7062proclassdetails";
    
    public $id;
    public $user_id;
    public $subject_id;
    
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
