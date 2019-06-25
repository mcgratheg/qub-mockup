<?php

class Document {

    private $connection;
    private $table_name = "7062prodocument";
    public $id;
    public $user_id;
    public $subject_level_id;
    public $subject_id;
    public $date_added;
    public $doc_path;

    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }

    function readDocument($code) {
        $query = "SELECT * FROM 7062prodocument INNER JOIN 7062prosubject ON 7062prodocument.Subject_ID=7062prosubject.SubjectID INNER JOIN 7062prouser ON
				7062prodocument.User_ID=7062prouser.UserID WHERE SubjectCode=? ORDER BY DateAdded DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $code);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }

    function create($user_id, $subject_level_id, $subject_id) {
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

    function update() {
        
    }

    function delete() {
        
    }

}
