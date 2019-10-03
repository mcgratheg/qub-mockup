<?php

class SubjectLevel {
    
    private $connection;
    private $table_name = "7062prosubjectlevel";
    
    private $id;
    private $name;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    public function get_id() {
	    return $this->id;
    }
    
    public function get_name() {
	    return $this->name;
    }    
    
    public function read_count() {
        $query = "SELECT COUNT(SubjectLevelID) AS 'COUNT' FROM 7062prosubjectlevel";
        $stmt = $this->connection->prepare($query);
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $count = $row['COUNT'];
        
        return $count;        
    }
    
    public function read_level($id) {
        $query = "SELECT Level FROM 7062prosubjectlevel WHERE SubjectLevelID = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $level = $row["Level"];
        
        return $level;
    }    
    
    public function create() {
        
    }
    
    public function update() {
        
    }
    
    public function delete() {
        
    }
}
