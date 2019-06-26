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

    function readTutor($userid) {
        $query = "SELECT RoomNumber, RoomAddress, PhoneExtension FROM 7062protutordetails WHERE User_ID=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;
    }

    function searchTutor($userid) {
        $query = "SELECT FirstName, LastName, ProfileImage, Email, RoomNumber, RoomAddress, PhoneExtension FROM 7062prouser INNER JOIN 7062prologindetails ON 
					7062prouser.UserID=7062prologindetails.User_ID INNER JOIN 7062protutordetails ON 7062prouser.UserID=7062protutordetails.User_ID WHERE 7062prouser.UserID=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }

    function create($user_id, $room_number, $room_address, $phone_ext) {
        $query = "INSERT INTO 7062protutordetails (User_ID, RoomNumber, RoomAddress, PhoneExtension) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('isss', $user_id, $room_number, $room_address, $phone_ext);
        
        $stmt->execute();
        $stmt->close();
    }

    function update($room_number, $room_address, $phone_ext, $user_id) {
        $query = "UPDATE 7062protutordetails SET RoomNumber=?, RoomAddress=?, PhoneExtension=? WHERE User_ID=?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('sssi', $room_number, $room_address, $phone_ext, $user_id);
        
        $stmt->execute();
        $stmt->close();
    }

    function delete() {
        
    }

}
