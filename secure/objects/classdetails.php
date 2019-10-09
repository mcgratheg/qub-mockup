<?php

class ClassDetails {

    private $connection;
    private $table_name = "7062proclassdetails";
    private $id;
    private $user_id;
    private $subject_id;

    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
	
    public function get_id() {
	return $this->id;
    }
	
    public function get_user_id() {
	return $this->user_id;
    }
	
    public function get_subject_id() {
	return $this->subject_id;
    }
    
    public function set_id($id) {
	$this->id = $id;
    }
	
    public function set_user_id($user_id) {
	$this->user_id = $user_id;
    }
	
    public function set_subject_id($subject_id) {
	$this->subject_id = $subject_id;
    }
	    
    public function read_tutor_details($userid) {
        $query = "SELECT SubjectName, SubjectCode FROM 7062prosubject INNER JOIN 7062proclassdetails ON 7062prosubject.SubjectID=7062proclassdetails.Subject_ID
		INNER JOIN 7062prouser ON 7062proclassdetails.User_ID=7062prouser.UserID WHERE 7062prouser.UserID=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }

    public function read_class_details($userid) {
        $query = "SELECT UserID FROM 7062prouser INNER JOIN 7062proclassdetails ON 7062prouser.UserID=7062proclassdetails.User_ID WHERE UserID=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }

    public function read_all_classes($subject, $user_id) {
        $query = "SELECT * FROM 7062proclassdetails INNER JOIN 7062prosubject ON 7062proclassdetails.Subject_ID=7062prosubject.SubjectID WHERE User_ID=?
		ORDER BY SubjectCode";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $user_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }

    public function create($user_id, $subject_id) {
        $query = "INSERT INTO 7062proclassdetails (User_ID, Subject_ID) VALUES (?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('ii', $user_id, $subject_id);
        
        $stmt->execute();
        $stmt->close();
    }

}
