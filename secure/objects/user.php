<?php
class User {
    
    private $connection;
    private $table_name = "7062prouser";
    
    //object properties
    private $id;
    private $type;
    private $first_name;
    private $last_name;
    private $date_of_birth;
    private $address;
    private $city;
    private $postcode;
    private $home_number;
    private $mobile_number;
    private $profile_image;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
	
    public function get_id() {
	return $this->id;
    }
	
    public function get_type() {
	return $this->type;
    }
	
    public function get_first_name() {
	return $this->fist_name;
    }
	
    public function get_last_name() {
	return $this->last_name;
    }
	
    public function get_date_of_birth() {
	return $this->date_of_birth;
    }
	
    public function get_address() {
	return $this->address;
    }
	
    public function get_city() {
	return $this->city;
    }
	
    public function get_postcode() {
	return $this->postcode;
    }
	
    public function get_home_number() {
	return $this->home_number;
    }
	
    public function get_mobile_number() {
	return $this->mobile_number;
    }
	
    public function get_profile_image() {
	return $this->profile_image;
    }	
	
    public function set_id($id) {
	$this->id = $id;
    }
	
    public function set_type($type) {
	$this->type = $type;
    }
	
    public function set_first_name($first_name) {
	$this->first_name = $first_name;
    }
	
    public function set_last_name($last_name) {
	$this->last_name = $last_name;
    }
	
    public function set_date_of_birth($date_of_birth) {
	$this->date_of_birth = $date_of_birth;
    }	
	
    public function set_address($address) {
	$this->address = $address;
    }
	
    public function set_city($city) {
	$this->city = $city;
    }
	
    public function set_postcode($postcode) {
	$this->postcode = $postcode;
    }
	
    public function set_home_number($home_number) {
	$this->home_number = $home_number;
    }
	
    public function set_mobile_number($mobile_number) {
	$this->mobile_number = $mobile_number;
    }
	
    public function set_profile_image($profile_image) {
	$this->profile_image = $profile_image;
    }	
    
    public function read_user($email) {
        //select current data
        //$query = "SELECT * FROM " . $this->table_name . " INNER JOIN " . $login->table_name . " ON " . $this->table_name . ".UserID =" . $login->table_name . ".User_ID WHERE " . $login->table_name . ".Email= ?";
        $query = "SELECT * FROM 7062prouser INNER JOIN 7062prologindetails ON 7062prouser.UserID=7062prologindetails.User_ID WHERE 7062prologindetails.Email =?";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $email);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
            $executed = true;
        } else {
            $executed = false;
        }

        if($result->num_rows == 1) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            
            $this->id = $row['UserID'];
            $this->type = $row['UserType_ID'];
            $this->first_name = $row['FirstName'];
            $this->last_name = $row['LastName'];
        }
        
        return $executed;
        
    }
    
    public function read_all($user_type, $login, $id) {
        //select all data for user
        $query = "SELECT * FROM 7062prouser INNER JOIN 7062prologindetails ON 7062prouser.UserID=7062prologindetails.User_ID INNER JOIN 7062prousertype
					ON 7062prouser.UserType_ID=7062prousertype.UserTypeID WHERE UserID=?";
        
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
            $user_type->id = $row['UserType_ID'];
            $user_type->name = $row['Type'];
        }
    }
    
    public function read_tutor() {
        $query = "SELECT UserID, FirstName, LastName, ProfileImage FROM 7062prouser WHERE UserType_ID=2 ORDER BY LastName ASC";
        $stmt = $this->connection->prepare($query);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;
    }
    
    public function read_count($user_type_id) {
        $query = "SELECT COUNT(UserID) AS 'COUNT' FROM 7062prouser WHERE UserType_ID = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $user_type_id);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $count = $row['COUNT'];
        
        return $count;
    }
    
    public function read_user_search() {
        $query = "SELECT UserID, Type, FirstName, LastName FROM 7062prouser INNER JOIN 7062prousertype ON 7062prouser.UserType_ID=7062prousertype.UserTypeID
				ORDER BY UserTypeID, LastName";
        $stmt = $this->connection->prepare($query);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;
    }
    
    public function create($user_type, $first_name, $last_name, $date_of_birth, $address, $city, $postcode) {
        
        $query = "INSERT INTO 7062prouser (UserType_ID, FirstName, LastName, DateOfBirth, Address, City, PostCode) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('issssss', $user_type, $first_name, $last_name, $date_of_birth, $address, $city, $postcode);
        
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
  
        $stmt->close();
    }
    
    public function update($update_first, $update_last, $update_dob, $update_address, $update_city, $update_postcode, $update_home, $update_mobile, $user_id) {
        
        $query = "UPDATE 7062prouser SET FirstName=?, LastName=?, DateOfBirth=?, Address=?, City=?, PostCode=?, HomeNumber=?, MobileNumber=? WHERE UserID=?";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('ssssssssi', $update_first, $update_last, $update_dob, $update_address, $update_city, $update_postcode, $update_home, $update_mobile, $user_id);
        $stmt->execute();
        
        $stmt->close();
    }
    
    public function update_profile_image($user_id) {
        $target_dir = "../../img/";
	$target_file = $target_dir . basename($_FILES["profileimg"]["name"]);
	$updateimg = basename($_FILES["profileimg"]["name"]);
	$uploadOk = 1;
	$msg = "";
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["profileimg"]["tmp_name"]);
			if($check !== false) {
			$msg = "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
			} else {
				$msg = "File is not an image.";
				$uploadOk = 0;
			}
		}
	// Check if file already exists
	if (file_exists($target_file)) {
		$msg = "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["profileimg"]["size"] > 2097152) {
		$msg = "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
		$msg = "Sorry, only JPG, JPEG, PNG files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$msg = "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["profileimg"]["tmp_name"], $target_file)) {
			$msg = "The file ". basename( $_FILES["profileimg"]["name"]). " has been uploaded.";
			
		$query = "UPDATE `7062prouser` SET `ProfileImage`= ? WHERE `UserID`= ?";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param('si', $updateimg, $user_id);
		
                if($stmt->execute()) {
                    $result = $stmt->get_result();
                }
			
		} else {
			$msg = "Sorry, there was an error uploading your file.";
		}
	}

        return $msg;
       
    }  
    
    public function delete($userid) {
        
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
