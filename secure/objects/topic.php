<?php

class Topic {
    
    private $connection;
    private $table_name = "7062protopic";
    
    public $id;
    public $subject_id;
    public $topic_by_id;
    public $date;
    public $title;
    public $content;
    
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
