<?php

class Login {
    
    private $connection;
    private $table_name = "7062prologindetails";
    
    public $id;
    public $user_id;
    public $email;
    public $password;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    function readEmail($email) {
        
        $query = "SELECT Email FROM 7062prologindetails WHERE Email = ?";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $email);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $this->email = $row['Email'];
        }
        
        
    }
    
    function create() {
        
    }
    
    function update() {
        
    }
    
    function delete() {
        
    }
}
