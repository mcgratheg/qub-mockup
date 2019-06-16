<?php

session_start();

include("connect/conn.php");

$email = mysqli_real_escape_string($conn,trim($_POST["email"]));

$pass = mysqli_real_escape_string($conn,trim($_POST["password"]));


$checkuser = "SELECT * FROM 7062prologindetails WHERE Email='$email' and Password=MD5('$pass') and Email LIKE '%qub.ac.uk'";

$userresult = mysqli_query($conn, $checkuser) or die(mysqli_error($conn));

mysqli_close($conn);

if(mysqli_num_rows($userresult) == 1){
	
	$_SESSION["cater_40105701"]= $email;
	while($row= mysqli_fetch_assoc($userresult)) {
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