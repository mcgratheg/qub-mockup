<?php

class Document {

    private $connection;
    private $table_name = "7062prodocument";
    private $id;
    private $user_id;
    private $subject_level_id;
    private $subject_id;
    private $date_added;
    private $doc_path;

    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
	
    public function get_id() {
	return $this->id;
    }
	
    public function get_user_id() {
	return $this->user_id;
    }
	
    public function get_subject_level_id() {
	return $this->subject_level_id;
    }
	
    public function get_subject_id() {
	return $this->subject_id;
    }
	
    public function get_date_added() {
	return $this->date_added;
    }
	
    public function get_doc_path() {
	return $this->doc_path;
    }
	
    public function set_id($id) {
	 $this->id = $id;
    }
	
    public function set_user_id($user_id) {
	 $this->user_id = $user_id;
    }
	
    public function set_subject_level_id($subject_level_id) {
	 $this->subject_level_id = $subject_level_id;
    }
	
    public function set_subject_id($subject_id) {
	 $this->subject_id = $subject_id;
    }
	
    public function set_date_added($date_added) {
	 $this->date_added = $date_added;
    }	
	
    public function set_doc_path($doc_path) {
	 $this->doc_path = $doc_path;
    }

    public function read_document($code) {
        $query = "SELECT * FROM 7062prodocument INNER JOIN 7062prosubject ON 7062prodocument.Subject_ID=7062prosubject.SubjectID INNER JOIN 7062prouser ON
				7062prodocument.User_ID=7062prouser.UserID WHERE SubjectCode=? ORDER BY DateAdded DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $code);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }

    public function create($user_id, $subject_level_id, $subject_id) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
        $uploadfile = basename($_FILES["uploadfile"]["name"]);
        $uploadOk = 1;
        $msg = "";
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["uploadfile"]["tmp_name"]);
            if ($check !== false) {
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
        if ($_FILES["uploadfile"]["size"] > 2097152) {
            $msg = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $msg = "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
                $msg = "The file " . basename($_FILES["uploadfile"]["name"]) . " has been uploaded.";

                $query = "INSERT INTO `7062prodocument`(`User_ID`, `SubjectLevel_ID`, `Subject_ID`, `Docpath`) VALUES (?, ?, ?, ?)";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param('iiis', $user_id, $subject_level_id, $subject_id, $uploadfile);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                }
            } else {
                $msg = "Sorry, there was an error uploading your file.";
            }
        }

        return $msg;
    }

}
