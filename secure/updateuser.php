<?php
	session_start();
	
	if(!isset($_SESSION["cater_40105701"]))
	{
		header("Location: ../login.php");
		
	}
	
	include("connect/conn.php");
	
	$email = $_SESSION["cater_40105701"];
	$userquery = "SELECT * FROM 7062prouser INNER JOIN 7062prologindetails ON 7062prouser.UserID=7062prologindetails.User_ID WHERE 7062prologindetails.Email='$email'";
	$result = mysqli_query($conn, $userquery) or die(mysqli_error($conn));
	
	$row=mysqli_fetch_assoc($result);
	
	$userid = $row["UserID"];
	$userfirst = $row["FirstName"];
	$userlast = $row["LastName"];
	$usertype = $row["UserType_ID"];
	
	//variables for 7062prouser update
	$userupdate = $_POST["user"];
	$usertype = $_POST["usertype"];
	$fnamepost = mysqli_real_escape_string($conn,$_POST["firstname"]);
	$lnamepost = mysqli_real_escape_string($conn,$_POST["lastname"]);
	$dob = mysqli_real_escape_string($conn,$_POST["dateofbirth"]);
	$dobpost = date('Y-m-d', strtotime($dob));
	$addresspost = mysqli_real_escape_string($conn,$_POST["address"]);
	$citypost = mysqli_real_escape_string($conn,$_POST["city"]);
	$pcodepost = mysqli_real_escape_string($conn,$_POST["postcode"]);
	$homephonepost = mysqli_real_escape_string($conn,$_POST["homenumber"]);
	$mobilephonepost = mysqli_real_escape_string($conn,$_POST["mobilenumber"]);
	
	
	//$userupdate = "UPDATE `7062prouser` SET `FirstName`='$fnamepost', `LastName`='$lnamepost', `DateOfBirth`='$dobpost', `Address`='$addresspost', `City`='$citypost', `PostCode`='$pcodepost' WHERE `UserID`=$userupdate";
	$userupdate = mysqli_prepare($conn,"UPDATE 7062prouser SET FirstName=?, LastName=?, DateOfBirth=?, Address=?, City=?, PostCode=?, HomeNumber=?, MobileNumber=? WHERE UserID=$userupdate");
	mysqli_stmt_bind_param($userupdate, 'ssssssss', $fnamepost, $lnamepost, $dobpost, $addresspost, $citypost, $pcodepost, $homephonepost, $mobilephonepost);
	
	//$updateuserresult = mysqli_query($conn, $userupdate) or die(mysqli_error($conn));

		
	/*if($usertype == 2) {
		
		$roomnumber = mysqli_real_escape_string($conn,trim($_POST["roomnumber"]));
		$roomaddress = mysqli_real_escape_string($conn,trim($_POST["roomaddress"]));
		$phonenumber = mysqli_real_escape_string($conn,trim($_POST["phonenumber"]));

	$tutorupdate = "UPDATE `7062protutordetails` SET `RoomNumber`='$roomnumber', `RoomAddress`='$roomaddress', `PhoneNumber`='$phonenumber' WHERE `UserID`=$userupdate";
	$tutorupdatereuslt = mysqli_query($conn, $tutorupdate) or die(mysqli_error($conn));

	}*/
		
	mysqli_stmt_execute($userupdate);
	
	mysqli_stmt_close($userupdate);
	
	mysqli_close($conn);		
		
		
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Web Dev Project</title>
		<link rel="icon" href="../img/bird-bluetit.png">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://gitcdn.link/repo/Chalarangelo/mini.css/master/dist/mini-default.min.css">
		<link rel="stylesheet" href="../css/style.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>

			jQuery(document).ready(function(){
			
			
			});	

		</script>
	</head>
	<body>
		<!-- Header -->
		<header class="sticky">
			<label for="drawer-control" class="button drawer-toggle persistent"></label>
			<?php echo"<a href='index.php' class='logo'>
			<img src='../img/bird-bluetit.png' width='50px'></a>
			<a href='index.php' class='button'>McG VLE</a>
			<a href='displayprofile.php?userid=$userid' class='button' id='userbutton'>$userfirst $userlast</a>
                        <span>|</span>
                        <a href='signout.php' class='button'>Sign Out</a>";?>
		</header>
		<div class="container">
		<div class="row">
		<input type="checkbox" id="drawer-control" class="drawer">
			<nav class="drawer col-md-4 col-lg-2">
				<label for="drawer-control" class="drawer-close"></label>
				<ul>
					<li><h4>Navigation</h4></li>
					<?php echo"<li><a href='displayprofile.php?userid=$userid' class='button'>$userfirst $userlast</a></li>
					<li><a href='index.php' class='button'>Home</a></li>";?>
					<li><a href="subjectsearch.php" class="button">Subjects</a></li>
					<li><a href="staffsearch.php" class="button">Staff</a></li>
                                        <?php if($usertype == 1){ echo"<li><a href='admin/index.php' class='button'>Admin Portal</a></li>";}?>
					<li><a href="signout.php" class="button" id="signout">Sign Out</a></li>
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
			</div>
			<div class="clearfloat"></div>
			<!-- end of main content -->
		</div>
		</div>
		<footer class="sticky">
			<p> 40105701 | CSC7062 Web Development Project</p>
		</footer>	
	</body>
</html>