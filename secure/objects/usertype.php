<?php

class UserType {
    
    private $connection;
    private $table_name = "7062prousertype";
    
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
    
    public function set_id($id) {
	    $this->id = $id;
    }
    
    public function set_name($name) {
	    $this->name = $name;
    }
    
    public function read_count() {
        $query = "SELECT COUNT(UserTypeID) AS 'COUNT' FROM 7062prousertype";
        $stmt = $this->connection->prepare($query);
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $count = $row['COUNT'];
        
        return $count;
    }
    
    public function read_type($id) {
        $query = "SELECT Type FROM 7062prousertype WHERE UserTypeID = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $type = $row["Type"];
        
        return $type;
    }
    
    public function create() {
        
    }
    
    public function update() {
        
    }
    
    public function delete() {
        
    }
}
