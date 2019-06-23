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
    
    public function readReply($id) {
        $query = "SELECT * FROM 7062proreply INNER JOIN 7062prouser ON 7062proreply.ReplyBy_ID=7062prouser.UserID WHERE ReplyTopic_ID = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result; 
    }
    
    public function  create() {
        
    }
    
    public function update() {
        
    }
    
    public function delete() {
        
    }
}
