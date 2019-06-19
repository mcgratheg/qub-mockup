<?php

class Document {
    
    private $connection;
    private $table_name = "7062prodocument";
    
    public $id;
    public $user_id;
    public $subject_level_id;
    public $subject_id;
    public $date_added;
    public $doc_path;
    
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
