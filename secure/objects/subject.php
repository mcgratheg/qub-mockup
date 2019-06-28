<?php

class Subject {
    
    private $connection;
    private $table_name = "7062prosubject";
    
    public $id;
    public $subject_level_id;
    public $name;
    public $code;
    public $description;
    
    public function __construct($mysqli) {
        $this->connection = $mysqli;
    }
    
    function read($code) {
        $query = "SELECT * FROM 7062prosubject WHERE SubjectCode = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('s', $code);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;
        
    }
    
    function read_subject_topic($id) {
        $query = "SELECT SubjectName, SubjectCode FROM 7062prosubject INNER JOIN 7062protopic ON 7062prosubject.SubjectID=7062protopic.Subject_ID WHERE TopicID = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;
        
    }
    
    function read_subject_search() {
        $query = "SELECT Level, SubjectID, SubjectCode, SubjectName FROM 7062prosubject INNER JOIN 7062prosubjectlevel ON 
				7062prosubject.SubjectLevel_ID=7062prosubjectlevel.SubjectLevelID ORDER BY SubjectLevel_ID, SubjectCode ASC";
        $stmt = $this->connection->prepare($query);        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        return $result;
        
    }
    
    function read_count($subject_level_id) {
        $query = "SELECT COUNT(SubjectID) AS 'COUNT' FROM 7062prosubject WHERE SubjectLevel_ID = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $subject_level_id);
        
        if($stmt->execute()) {
            $result = $stmt->get_result();
        }
        
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $count = $row['COUNT'];
        
        return $count;
    }    
    
    function create($subject_level_id, $subject_code, $subject_name, $subject_description) {
        $query = "INSERT INTO 7062prosubject (SubjectLevel_ID, SubjectCode, SubjectName, SubjectDescription) VALUES (?,?,?,?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('isss', $subject_level_id, $subject_code, $subject_name, $subject_description);
        
        $stmt->execute();
        $stmt->close();
    }
    
    function update($subject_code, $subject_name, $subject_description, $subject_id) {
        $query = "UPDATE `7062prosubject` SET `SubjectCode`=?, `SubjectName`=?, `SubjectDescription`=? WHERE `SubjectID`=?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('sssi', $subject_code, $subject_name, $subject_description, $subject_id);
        
        $stmt->execute();
        $stmt->close();
    }
    
    function delete() {
        
    }
}

