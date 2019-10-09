<?php

class Reply {
    
    private $connection;
    private $table_name = "7062proreply";
    
    private $id;
    private $reply_by_id;
    private $topic_id;
    private $date;
    private $content;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
	
    public function get_id() {
        return $this->id;
    }
	
    public function get_reply_by_id() {
        return $this->reply_by_id;
    }
	
    public function get_topic_id() {
        return $this->topic_id;
    }
	
    public function get_date() {
        return $this->date;
    }
	
    public function get_content() {
        return $this->content;
    }
	
    public function set_id($id) {
	$this->id = $id;
    }
	
    public function set_reply_by_id($reply_by_id) {
	$this->reply_by_id = $reply_by_id;
    }
	
    public function set_topic_id($topic_id) {
	$this->topic_id = $topic_id;
    }
	
    public function set_date($date) {
	$this->date = $date;
    }
	
    public function set_content($content) {
	$this->content = $content;
    }
    
    public function read_reply($id) {
        $query = "SELECT * FROM 7062proreply INNER JOIN 7062prouser ON 7062proreply.ReplyBy_ID=7062prouser.UserID WHERE ReplyTopic_ID = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result; 
    }
    
    public function read_reply_user($id) {
        $query = "SELECT 7062prouser.FirstName, 7062prouser.LastName FROM 7062prouser INNER JOIN
								7062proreply ON 7062prouser.UserID=7062proreply.ReplyBy_ID WHERE 7062proreply.ReplyTopic_ID = ? ORDER BY 
								7062proreply.ReplyDate DESC LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;        
    }
    
    public function create($user_id, $topic_id, $reply_content) {
        $query = "INSERT INTO 7062proreply (ReplyBy_ID, ReplyTopic_ID, ReplyContent) VALUES (?,?,?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('iis', $user_id, $topic_id, $reply_content);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        $stmt->close();
    }

}
