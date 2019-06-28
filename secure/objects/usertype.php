<?php

class UserType {
    
    private $connection;
    private $table_name = "7062prousertype";
    
    public $id;
    public $name;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    function read_count() {
        $query = "SELECT COUNT(UserTypeID) AS 'COUNT' FROM 7062prousertype";
        $stmt = $this->connection->prepare($query);
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $count = $row['COUNT'];
        
        return $count;
    }
    
    function read_type($id) {
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
    
    function create() {
        
    }
    
    function update() {
        
    }
    
    function delete() {
        
    }
}
