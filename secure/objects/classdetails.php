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

    function read_tutor_details($userid) {
        $query = "SELECT SubjectName, SubjectCode FROM 7062prosubject INNER JOIN 7062proclassdetails ON 7062prosubject.SubjectID=7062proclassdetails.Subject_ID
		INNER JOIN 7062prouser ON 7062proclassdetails.User_ID=7062prouser.UserID WHERE 7062prouser.UserID=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }

    function read_class_details($userid) {
        $query = "SELECT UserID FROM 7062prouser INNER JOIN 7062proclassdetails ON 7062prouser.UserID=7062proclassdetails.User_ID WHERE UserID=?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $userid);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }

    function read_all_classes($subject, $user_id) {
        $query = "SELECT * FROM 7062proclassdetails INNER JOIN 7062prosubject ON 7062proclassdetails.Subject_ID=7062prosubject.SubjectID WHERE User_ID=?
		ORDER BY SubjectCode";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $user_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
        }

        return $result;
    }

    function create($user_id, $subject_id) {
        $query = "INSERT INTO 7062proclassdetails (User_ID, Subject_ID) VALUES (?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('ii', $user_id, $subject_id);
        
        $stmt->execute();
        $stmt->close();
    }

    function update() {
        
    }

    function delete() {
        
    }

}
