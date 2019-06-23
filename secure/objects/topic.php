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
    
    public function readTopic($id) {
        $query = "SELECT * FROM 7062protopic INNER JOIN 7062prouser ON 7062protopic.TopicBy_ID=7062prouser.UserID WHERE TopicID = ?";
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
