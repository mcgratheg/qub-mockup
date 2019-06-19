<?php

class Reply {
    
    private $connection;
    private $table_name = "7062proreply";
    
    public $id;
    public $reply_by_id;
    public $topic_id;
    public $date;
    public $content;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    public function read() {
        
    }
    
    public function  create() {
        
    }
    
    public function update() {
        
    }
    
    public function delete() {
        
    }
}
