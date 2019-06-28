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
    
    function read_reply($id) {
        $query = "SELECT * FROM 7062proreply INNER JOIN 7062prouser ON 7062proreply.ReplyBy_ID=7062prouser.UserID WHERE ReplyTopic_ID = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result; 
    }
    
    function read_reply_user($id) {
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
    
    function create($user_id, $topic_id, $reply_content) {
        $query = "INSERT INTO 7062proreply (ReplyBy_ID, ReplyTopic_ID, ReplyContent) VALUES (?,?,?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('iis', $user_id, $topic_id, $reply_content);
        
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
