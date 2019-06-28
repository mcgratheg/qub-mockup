<?php

session_start();

include("connect/database.php");
include("objects/user.php");
include("objects/login.php");

$db = Database::getInstance();
$mysqli = $db->getConnection();

$user = new User($mysqli);
$login = new Login($mysqli);

$email = $mysqli->real_escape_string(trim($_POST["email"]));

$pass = $mysqli->real_escape_string(trim($_POST["password"]));

$result = $login->read_check_user($email, $pass);

if($result->num_rows == 1){
	
	$_SESSION["cater_40105701"]= $email;
	while($row= $result->fetch_array(MYSQLI_ASSOC)) {
		if($row["UserType_ID"] == 1) {
			$_SESSION["isAdmin"] = true;
		} else {
			$_SESSION["isAdmin"] = false;
		}
	}
	header("Location: index.php");
}else{
	header("Location: ../login.php");
}

?>