<?php
	session_start();
	
	if(!isset($_SESSION["cater_40105701"]))
	{
		header("Location: ../../login.php");
		
	}

include("../connect/database.php");
include("../objects/user.php");
include("../objects/login.php");

$email = $_SESSION["cater_40105701"];

$db = Database::getInstance();
$mysqli = $db->getConnection();

$user = new User($mysqli);
$login = new Login($mysqli);

$stmt = $user->read_user($email);
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Web Dev Project</title>
		<link rel="icon" href="../../img/bird-bluetit.png">
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-default.min.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mini.css/3.0.1/mini-default.min.css">
                <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../../css/jquery-ui.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
		<link rel="stylesheet" href="../../css/style.css">
		<script src="../../js/myForm.js"></script>
		<script>

			jQuery(document).ready(function(){
				
				jQuery('#datepicker').datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: "1950:c",
					navigationAsDateFormat: true
					
	
				});	

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
			<a href='../displayprofile.php?userid=$user->id' class='button' id='userbutton'>$user->first_name $user->last_name</a>
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
					<?php echo"<li><a href='../displayprofile.php?userid=$user->id' class='button'>$user->first_name $user->last_name</a></li>
					<li><a href='index.php' class='button'>Home</a></li>";?>
					<li><a href="../subjectsearch.php" class="button">Subjects</a></li>
					<li><a href="../staffsearch.php" class="button">Staff</a></li>
					<li><a href="../signout.php" class="button" id="signout">Sign Out</a></li>
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
					<div id="titlehead">
						<h3>Add User</h3>
						<p>Please fill out all fields.</p>
					</div>	
						<form method="post" id="myForm" action="insertuser.php">
							<fieldset>
								<legend>User Details</legend>
								<div class="row responsive-label">
									<div class="col-sm-12 col-md-2">
										<label for="firstname">First Name</label>
									</div>
									<div class="col-sm-12 col-md">
										<input type="text" value="" id="firstname" name="firstname" style="width:75%;">
									</div>
								</div>
								<div class="row responsive-label">
									<div class="col-sm-12 col-md-2">
										<label for="lastname">Last Name</label>
									</div>
									<div class="col-sm-12 col-md">
										<input type="text" value="" id="lastname" name="lastname" style="width:75%;">
									</div>
								</div>
								<div class="row responsive-label">
									<div class="col-sm-12 col-md-2">
										<label for="usertype">User Type</label>
									</div>
									<div class="col-sm-12 col-md">
										<select name="usertype">
											<option value="2" name="usertype" required="required">Tutor</option>
											<option value="3" name="usertype" required="required">Student</option>
										</select>
									</div>	
								</div>
								<div class="row responsive-label">
									<div class="col-sm-12 col-md-2">
										<label for="dateofbirth">Date Of Birth</label>
									</div>
									<div class="col-sm-12 col-md">
										<input type="text" id="datepicker" value="" name="dateofbirth" required="required" style="width:75%;">
									</div>
								</div>
								<div class="row responsive-label">
									<div class="col-sm-12 col-md-2">
										<label for="address">Address Line</label>
									</div>
									<div class="col-sm-12 col-md">
										<input type="text"value="" id="address" name="address" style="width:75%;">
									</div>
								</div>
								<div class="row responsive-label">
									<div class="col-sm-12 col-md-2">
										<label for="city">City</label>
									</div>
									<div class="col-sm-12 col-md">
										<input type="text"value="" id="city" name="city" style="width:75%;">
									</div>
								</div>
								<div class="row responsive-label">
									<div class="col-sm-12 col-md-2">
										<label for="postcode">Postcode</label>
									</div>
									<div class="col-sm-12 col-md">
										<input type="text" value="" id="postcode" name="postcode" style="width:75%;">
									</div>
								</div>
							</fieldset>
							<fieldset>
								<legend>Login Details</legend>
								<div class="row responsive-label">
									<div class="col-sm-12 col-md-2">
										<label for="emailnew">Email</label>
									</div>
									<div class="col-sm-12 col-md">
										<input type="email" value="" id="email" name="emailnew" required="required" style="width:75%;">
									</div>
								</div>
								<div class="row responsive-label">
									<div class="col-sm-12 col-md-2">
										<label for="password">Password</label>
									</div>
									<div class="col-sm-12 col-md">
										<input type="password" value="" id="pwd" name="password" required="required" minlength=5 style="width:75%;">
									</div>
								</div>
								<div class="row responsive-label">
									<div class="col-sm-12 col-md-2">
										<label for="confirmpass">Confirm Password</label>
									</div>
									<div class="col-sm-12 col-md">
										<input type="password" value="" id="confirmpass" name="confirmpass" style="width:75%;">
									</div>
								</div>
							</fieldset>
							<div class="row">		
								<input type="submit" class="primary" value="Submit" style="margin-left:10px;">
							</div>
						</form>
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