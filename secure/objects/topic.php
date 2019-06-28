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
    
    function read_topic($id) {
        $query = "SELECT * FROM 7062protopic INNER JOIN 7062prouser ON 7062protopic.TopicBy_ID=7062prouser.UserID WHERE TopicID = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;    
        
    }
    
    function read_topic_subject($code) {
        $query = "SELECT * FROM 7062protopic INNER JOIN 7062prouser ON 7062protopic.TopicBy_ID=7062prouser.UserID INNER JOIN 7062prosubject ON
						7062protopic.Subject_ID=7062prosubject.SubjectID WHERE 7062prosubject.SubjectCode = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $code);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;    
        
    }    
    
    function create($topic_title, $topic_content, $subject_id, $user_id) {
        $query = "INSERT INTO 7062protopic (TopicTitle, TopicContent, Subject_ID, TopicBy_ID) VALUES (?,?,?,?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('ssii', $topic_title, $topic_content, $subject_id, $user_id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        $stmt->close();        
    }
    
    function update() {
        
    }
    
    function delete() {
        
    }
}
