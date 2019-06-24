<?php

class Document {
    
    private $connection;
    private $table_name = "7062prodocument";
    
    public $id;
    public $user_id;
    public $subject_level_id;
    public $subject_id;
    public $date_added;
    public $doc_path;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    function readDocument($code) {
        $query = "SELECT * FROM 7062prodocument INNER JOIN 7062prosubject ON 7062prodocument.Subject_ID=7062prosubject.SubjectID INNER JOIN 7062prouser ON
				7062prodocument.User_ID=7062prouser.UserID WHERE SubjectCode=? ORDER BY DateAdded DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $code);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;
        
    }
    
    function create() {
        
    }
    
    function update() {
        
    }
    
    function delete() {
        
    }
}
