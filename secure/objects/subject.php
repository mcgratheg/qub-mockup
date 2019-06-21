<?php

class Subject {
    
    private $connection;
    private $table_name = "7062prosubject";
    
    public $id;
    public $subject_level_id;
    public $name;
    public $code;
    public $description;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    public function read($code) {
        $query = "SELECT SubjectID, SubjectName, SubjectCode FROM 7062prosubject WHERE SubjectCode = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $code);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;
        
    }
    
    public function create() {
        
    }
    
    public function update() {
        
    }
    
    public function delete() {
        
    }
}

