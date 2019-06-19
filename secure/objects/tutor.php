<?php

class Tutor {
    
    private $connection;
    private $table_name = "7062protutordetails";
    
    public $id;
    public $user_id;
    public $room_number;
    public $room_address;
    public $phone_ext;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    public function readTutor($userid) {
        $query = "SELECT RoomNumber, RoomAddress, PhoneExtension FROM 7062protutordetails WHERE User_ID=?";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        if($result->num_rows == 1) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            
            $this->room_number = $row['RoomNumber'];
            $this->room_address = $row['RoomAddress'];
            $this->phone_ext = $row['PhoneExtension'];
        }
    }
    
    public function create() {
        
    }
    
    public function update() {
        
    }
    
    public function delete() {
        
    }
}
