<?php

class ClassDetails {

    private $connection;
    private $table_name = "7062proclassdetails";
    public $id;
    public $user_id;
    public $subject_id;

    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }

    function readTutorDetails($userid) {
        $query = "SELECT SubjectName, SubjectCode FROM 7062prosubject INNER JOIN 7062proclassdetails ON 7062prosubject.SubjectID=7062proclassdetails.Subject_ID
		INNER JOIN 7062prouser ON 7062proclassdetails.User_ID=7062prouser.UserID WHERE 7062prouser.UserID=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }
    
    function readClassDetails($userid) {
        $query = "SELECT UserID FROM 7062prouser INNER JOIN 7062proclassdetails ON 7062prouser.UserID=7062proclassdetails.User_ID WHERE UserID=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }    

    function create() {
        
    }

    function update() {
        
    }

    function delete() {
        
    }

}
