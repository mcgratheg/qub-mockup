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
    
    public function __construct($db) {
        $this->connection = $db;
    }
    
    function read() {
        //select all data
        $query = "SELECT * FROM " . $this->table_name . "INNER JOIN" . $login->table_name . "ON";
    }
}
