<?php

class SubjectLevel {
    
    private $connection;
    private $table_name = "7062prosubjectlevel";
    
    public $id;
    public $name;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    function read_count() {
        $query = "SELECT COUNT(SubjectLevelID) AS 'COUNT' FROM 7062prosubjectlevel";
        $stmt = $this->connection->prepare($query);
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $count = $row['COUNT'];
        
        return $count;        
    }
    
    function read_level($id) {
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
    
    function create() {
        
    }
    
    function update() {
        
    }
    
    function delete() {
        
    }
}
