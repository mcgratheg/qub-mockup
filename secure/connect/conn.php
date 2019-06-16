<?php

	include("password.php");
	
	$webserver = "localhost";
	$username = "root";
	$db = "qub_website_mock";
	
	$conn = mysqli_connect($webserver, $username, $password, $db);
	
	if(!$conn){
		die("Connection failed!".mysqli_connect_error());
	}
	
?>