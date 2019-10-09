<?php

class Topic {
    
    private $connection;
    private $table_name = "7062protopic";
    
    private $id;
    private $subject_id;
    private $topic_by_id;
    private $date;
    private $title;
    private $content;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
	
    public function get_id() {
	return $this->id;
    }
	
    public function get_subject_id() {
	return $this->subject_id;
    }
	
    public function get_topic_by_id() {
	return $this->topic_by_id;
    }
	
    public function get_date() {
	return $this->date;
    }
	
    public function get_title() {
	return $this->title;
    }
	
    public function get_content() {
	return $this->content;
    }
	
    public function set_id($id) {
	$this->id = $id;
    }
	
    public function set_subject_id($subject_id) {
	$this->subject_id = $subject_id;
    }
	
    public function set_topic_by_id($topic_by_id) {
	$this->topic_by_id = $topic_by_id;
    }
	
    public function set_date($date) {
	$this->date = $date;
    }
	
    public function set_title($title) {
	$this->title = $title;
    }
	
    public function set_content($content) {
	$this->content = $content;
    }	
    
    public function read_topic($id) {
        $query = "SELECT * FROM 7062protopic INNER JOIN 7062prouser ON 7062protopic.TopicBy_ID=7062prouser.UserID WHERE TopicID = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;    
        
    }
    
    public function read_topic_subject($code) {
        $query = "SELECT * FROM 7062protopic INNER JOIN 7062prouser ON 7062protopic.TopicBy_ID=7062prouser.UserID INNER JOIN 7062prosubject ON
						7062protopic.Subject_ID=7062prosubject.SubjectID WHERE 7062prosubject.SubjectCode = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $code);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;    
        
    }    
    
    public function create($topic_title, $topic_content, $subject_id, $user_id) {
        $query = "INSERT INTO 7062protopic (TopicTitle, TopicContent, Subject_ID, TopicBy_ID) VALUES (?,?,?,?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('ssii', $topic_title, $topic_content, $subject_id, $user_id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        $stmt->close();        
    }

}
