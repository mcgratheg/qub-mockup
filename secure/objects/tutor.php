<?php

class Tutor {

    private $connection;
    private $table_name = "7062protutordetails";
    private $id;
    private $user_id;
    private $room_number;
    private $room_address;
    private $phone_ext;

    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
	
    public function get_id() {
	return $this->id;
    }
	
    public function get_user_id() {
	return $this->user_id;
    }
	
    public function get_room_number() {
	return $this->room_number;
    }
	
    public function get_room_address() {
	return $this->room_address;
    }
	
    public function get_phone_ext() {
	return $this->phone_ext;
    }	
	
    public function set_id($id) {
	$this->id = $id;
    }
	
    public function set_user_id($user_id) {
	$this->user_id = $user_id;
    }
	
    public function set_room_number($room_number) {
	$this->room_number = $room_number;
    }
	
    public function set_room_address($room_address) {
	$this->room_address = $room_address;
    }
	
    public function set_phone_ext($phone_ext) {
	$this->phone_ext = $phone_ext;
    }	

    public function read_tutor($userid) {
        $query = "SELECT RoomNumber, RoomAddress, PhoneExtension FROM 7062protutordetails WHERE User_ID=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;
    }

    public function search_tutor($userid) {
        $query = "SELECT FirstName, LastName, ProfileImage, Email, RoomNumber, RoomAddress, PhoneExtension FROM 7062prouser INNER JOIN 7062prologindetails ON 
					7062prouser.UserID=7062prologindetails.User_ID INNER JOIN 7062protutordetails ON 7062prouser.UserID=7062protutordetails.User_ID WHERE 7062prouser.UserID=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }

    public function create($user_id, $room_number, $room_address, $phone_ext) {
        $query = "INSERT INTO 7062protutordetails (User_ID, RoomNumber, RoomAddress, PhoneExtension) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('isss', $user_id, $room_number, $room_address, $phone_ext);
        
        $stmt->execute();
        $stmt->close();
    }

    public function update($room_number, $room_address, $phone_ext, $user_id) {
        $query = "UPDATE 7062protutordetails SET RoomNumber=?, RoomAddress=?, PhoneExtension=? WHERE User_ID=?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('sssi', $room_number, $room_address, $phone_ext, $user_id);
        
        $stmt->execute();
        $stmt->close();
    }

}
