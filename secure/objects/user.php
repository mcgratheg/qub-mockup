<?php
class User {
    
    private $connection;
    private $table_name = "7062prouser";
    
    //object properties
    public $id;
    public $type;
    public $first_name;
    public $last_name;
    public $date_of_birth;
    public $address;
    public $city;
    public $postcode;
    public $home_number;
    public $mobile_number;
    public $profile_image;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    function readUser($email) {
        //select current data
        //$query = "SELECT * FROM " . $this->table_name . " INNER JOIN " . $login->table_name . " ON " . $this->table_name . ".UserID =" . $login->table_name . ".User_ID WHERE " . $login->table_name . ".Email= ?";
        $query = "SELECT * FROM 7062prouser INNER JOIN 7062prologindetails ON 7062prouser.UserID=7062prologindetails.User_ID WHERE 7062prologindetails.Email =?";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $email);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }

        if($result->num_rows == 1) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            
            $this->id = $row['UserID'];
            $this->type = $row['UserType_ID'];
            $this->first_name = $row['FirstName'];
            $this->last_name = $row['LastName'];
        }
        
        
    }
    
    function readAll($login, $id) {
        //select all data for user
        $query = "SELECT * FROM 7062prouser INNER JOIN 7062prologindetails ON 7062prouser.UserID=7062prologindetails.User_ID WHERE UserID=?";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        if($result->num_rows == 1) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            
            $this->id = $row['UserID'];
            $this->type = $row['UserType_ID'];
            $this->first_name = $row['FirstName'];
            $this->last_name = $row['LastName'];
            $this->date_of_birth = $row['DateOfBirth'];
            $this->address = $row['Address'];
            $this->city = $row['City'];
            $this->postcode = $row['PostCode'];
            $this->profile_image = $row['ProfileImage'];
            $this->home_number = $row['HomeNumber'];
            $this->mobile_number = $row['MobileNumber'];
            
            $login->email = $row['Email'];
        }
    }
    
    function create() {
        
        $query = "INSERT INTO 7062prouser (UserType_ID, FirstName, LastName, DateOfBirth, Address, City, PostCode, HomeNumber, MobileNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('issssss', $this->type, $this->first_name, $this->last_name, $this->date_of_birth, $this->address, $this->city, $this->postcode, $this->home_number, $this->mobile_number);
        
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
  
        $stmt->close();
    }
    
    function update($userid) {
        
        $query = "UPDATE 7062prouser SET UserType_ID=?, FirstName=?, LastName=?, DateOfBirth=?, Address=?, City=?, PostCode=?, HomeNumber=?, MobileNumber=? WHERE UserID=?";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('isssssi', $this->type, $this->first_name, $this->last_name, $this->date_of_birth, $this->address, $this->city, $this->postcode, $this->home_number, $this->mobile_number, $userid);
        $stmt->execute();
        
        $stmt->close();
    }
    
    function delete($userid) {
        
        $query = "DELETE FROM 7062prouser WHERE UserID=?";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);
        
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        
        $stmt->close();       
    }
}
