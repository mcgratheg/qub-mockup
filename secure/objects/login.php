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
    
    function read_check_user($email, $password) {
        
        $query = "SELECT * FROM 7062prologindetails WHERE Email= ? and Password=MD5(?) and Email LIKE '%qub.ac.uk'";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;
        
        
    }
    
    function create($user_id, $user_email, $password) {
        $query = "INSERT INTO 7062prologindetails (User_ID, Email, Password) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $password_hash = md5($password);
        $stmt->bind_param('iss', $user_id, $user_email, $password_hash);
        
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        
        $stmt->close();
    }
    
    function update_password($password_hash, $email) {
        
        $query = "UPDATE 7062prologindetails SET Password=? WHERE Email=?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('ss', $password_hash, $email);
        
        if($stmt->execute()) {
            $result = true;
        } else {
            $result = false;
        }
        
        return $result;
    }
    
    function delete() {
        
    }
}
