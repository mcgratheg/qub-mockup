<?php
	session_start();
	
	if(!isset($_SESSION["cater_40105701"]))
	{
		header("Location: ../../login.php");
		
	}
	
	
	include("../connect/conn.php");
	
	$email = $_SESSION["cater_40105701"];
	$userquery = "SELECT * FROM 7062prouser INNER JOIN 7062prologindetails ON 7062prouser.UserID=7062prologindetails.User_ID WHERE 7062prologindetails.Email='$email'";
	$result = mysqli_query($conn, $userquery) or die(mysqli_error($conn));
	
	$row=mysqli_fetch_assoc($result);
	
	$userid = $row["UserID"];
	$userfirst = $row["FirstName"];
	$userlast = $row["LastName"];
	$usertype = $row["UserType_ID"];

	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Web Dev Project</title>
		<link rel="icon" href="../../img/bird-bluetit.png">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://gitcdn.link/repo/Chalarangelo/mini.css/master/dist/mini-default.min.css">
		<link rel="stylesheet" href="../../css/style.css">
		
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
			<img src='../../img/bird-bluetit.png' width='50px'></a>
			<a href='index.php' class='button'>McG VLE</a>
			<a href='../displayprofile.php?userid=$userid' class='button' id='userbutton'>$userfirst $userlast</a>
                        <span>|</span>
                        <a href='../signout.php' class='button'>Sign Out</a>";?>
		</header>
		<div class="container">
		<div class="row">
		<input type="checkbox" id="drawer-control" class="drawer">
			<nav class="drawer col-md-4 col-lg-2">
				<label for="drawer-control" class="drawer-close"></label>
				<ul>
					<li><h4>Navigation</h4></li>
					<?php echo"<li><a href='../displayprofile.php?userid=$userid' class='button'>$userfirst $userlast</a></li>
					<li><a href='index.php' class='button'>Home</a></li>";?>
					<li><a href="../subjectsearch.php" class="button">Subjects</a></li>
					<li><a href="../staffsearch.php" class="button">Staff</a></li>
					<li><a href="../signout.php" class="button" id="signout">Sign Out</a></li>
					
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
			<?php 
					$id= $_GET["id"];
					//echo $id;
					
					$query = "SELECT FirstName, LastName, RoomNumber, RoomAddress, PhoneExtension FROM 7062prouser INNER JOIN 7062protutordetails ON
					7062prouser.UserID=7062protutordetails.User_ID WHERE UserID=$id";
					$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
					if(mysqli_num_rows($result)==1){
						while($row=mysqli_fetch_array($result)){
							$fname = $row["FirstName"];
							$lname = $row["LastName"];
							$roomnumber = $row["RoomNumber"];
							$roomaddress = $row["RoomAddress"];
							$phoneext = $row["PhoneExtension"];
							
							echo "<div id='titlehead'>
									<h4>Office Details</h4>
									<br>
									<p>$fname $lname</p>
								</div>
								<form method='post' id='myForm' action='updateoffice.php'>
									<fieldset>
										<div class='row responsive-label'>
											<div class='col-sm-12 col-md-2'>
												<label for='room'>Room</label>
											</div>
											<div class='col-sm-12 col-md'>
												<input type='text' value='$roomnumber' name='room' style='width:65%;'>
											</div>
										</div>
										<div class='row responsive-label'>
											<div class='col-sm-12 col-md-2'>
												<label for='address'>Address</label>
											</div>
											<div class='col-sm-12 col-md'>
												<input type='text' value='$roomaddress' name='address' style='width:65%;'>
											</div>
										</div>
										<div class='row responsive-label'>
											<div class='col-sm-12 col-md-2'>
												<label for='extension'>Extension</label>
											</div>
											<div class='col-sm-12 col-md'>
												<input type='text' value='$phoneext' name='extension' style='width:65%;'>
											</div>
										</div>
										<div class='hide-form'>
											<input type='number' name='user' class='hidden' value='$id' id='hideform'>
										</div>
										<div class='row'>
											<input type='submit' class='primary' value='Submit'>
										</div>
									</fieldset>
								</form>";
						}
					}
			 ?>
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
<?php
	mysqli_close($conn);
?>