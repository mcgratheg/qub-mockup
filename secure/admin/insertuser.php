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
	
	//variables for 7062prouser insert
	$usertype = $_POST["usertype"];
	$fnamepost = trim($_POST["firstname"]);
	$lnamepost = trim($_POST["lastname"]);
	$dob = $_POST["dateofbirth"];
	$dobpost = date('Y-m-d', strtotime($dob));
	$addresspost = trim($_POST["address"]);
	$citypost = trim($_POST["city"]);
	$pcodepost = trim($_POST["postcode"]);
	
	$userinsert = mysqli_prepare($conn,"INSERT INTO 7062prouser (UserType_ID, FirstName, LastName, DateOfBirth, Address, City, PostCode) VALUES (?, ?, ?, ?, ?, ?, ?)");
	mysqli_stmt_bind_param($userinsert, 'issssss', $usertype, $fnamepost, $lnamepost, $dobpost, $addresspost, $citypost, $pcodepost);
	
	//$insertuserresult = mysqli_query($conn, $userinsert) or die(mysqli_error($conn));
	//mysqli_stmt_execute($userinsert);
	
	if(mysqli_stmt_execute($userinsert)){
		$usersuccess = true;
		$msg = "New user was added successfully";
	} else {
		$usersuccess = false;
		$msg = "Request was unsuccessful";
	}
	
	mysqli_stmt_close($userinsert);
	
	$userid = mysqli_insert_id($conn);
		
			//variables for 7062prologindetails insert
			$emailpost = trim($_POST["emailnew"]);
			$passpost = trim($_POST["password"]);
			$passpost_hash = md5($passpost);
		
			$logininsert = mysqli_prepare($conn,"INSERT INTO 7062prologindetails (User_ID, Email, Password) VALUES (?, ?, ?)");
			mysqli_stmt_bind_param($logininsert, 'iss', $userid, $emailpost, $passpost_hash);
		
			//$insertloginresult = mysqli_query($conn, $logininsert) or die(mysqli_error($conn));
			//mysqli_stmt_execute($logininsert);
			
			if(mysqli_stmt_execute($logininsert)){
				$loginsuccess = true;
				$logmsg = "Login details were successfully added";
			}else{
				$loginsuccess = false;
				$logmsg = "Request was unsuccesful";
			}
			
			mysqli_stmt_close($logininsert);
			
	mysqli_close($conn);		
		
		
	
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
		<input type="checkbox" id="drawer-control">
			<nav class="drawer col-md-4 col-lg-2">
				<label for="drawer-control" class="drawer-close"></label>
				<ul>
					<li><h4>Navigation</h4></li>
					<?php echo"<li><a href='displayprofile.php?userid=$userid' class='button'>$userfirst $userlast</a></li>
					<li><a href='index.php' class='button'>Home</a></li>";?>
					<li><a href="../subjectsearch.php" class="button">Subjects</a></li>
					<li><a href="../staffsearch.php" class="button">Staff</a></li>
					<li><a href="../signout.php" class="button" id="signout">Sign Out</a></li>
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
			<?php
			
				if($usersuccess){
					echo "<p>$msg</p>";
					
					echo "<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>
								<p>Name:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>
								<p>$fnamepost $lnamepost</p>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>
								<p>User Type:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>
								<p>$usertype</p>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>
								<p>Date Of Birth:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>	
								<p>$dob</p>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>		
								<p>Address:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>		
								<p>$addresspost<br>$citypost<br>$pcodepost</p>
							</div>
						</div>";
					
				} else {
					echo "<p>$msg</p>";
				}
				
				if($loginsuccess){
					echo "<p>$logmsg</p>";
					
					echo "<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>
								<p>Email:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>
								<p>$emailpost</p>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>
								<p>Password:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>	
								<p>********</p>
							</div>
						</div>";
				}else{
					echo "<p>$logmsg</p>";
				}
				
				echo "<div class='row' id='nav'>
							<button class='primary'><a href='usersearch.php'>Return to Users</a></button>
					</div>";
					
				
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