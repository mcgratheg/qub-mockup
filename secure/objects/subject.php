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
        $query = "SELECT * FROM 7062prosubject WHERE SubjectCode = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $code);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;
        
    }
    
    public function readSubjectTopic($id) {
        $query = "SELECT SubjectName, SubjectCode FROM 7062prosubject INNER JOIN 7062protopic ON 7062prosubject.SubjectID=7062protopic.Subject_ID WHERE TopicID = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        
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

