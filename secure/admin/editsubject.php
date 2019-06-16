<?php
	session_start();
	
	if(!isset($_SESSION["cater_40105701"]))
	{
		header("Location: ../../login.php");
		
	}
	
	
	include("../connect/conn.php");
	
	$email = $_SESSION["cater_40105701"];
	$userquery = "SELECT * FROM 7062prouser INNER JOIN 7062prologindetails ON 7062prouser.UserID=7062prologindetails.User_ID WHERE 7062prologindetails.Email='$email'";
	$result = mysqli_query($conn, $userquery);
	
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
					<?php echo"<li><a href='../displayprofile.php?userid=$userid' class='button'>$userfirst $userlast</a></li>
					<li><a href='index.php' class='button'>Home</a></li>";?>
					<li><a href="../subjectsearch.php" class="button">Subjects</a></li>
					<li><a href="../staffsearch.php" class="button">Staff</a></li>
					<li><a href="../signout.php" class="button" id="signout">Sign Out</a></li>
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
			<?php
					$code = $_GET["subject"];
					
					$query = "SELECT * FROM 7062prosubject WHERE SubjectCode='$code'";
					$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
					
					if(mysqli_num_rows($result)==1){
						while($row=mysqli_fetch_assoc($result)){
							$subjectid = $row["SubjectID"];
							$subjectname = $row["SubjectName"];
							$subjectdesc = $row["SubjectDescription"];
							
					echo "<div id='titlehead'>
							<h3>Edit Subject</h3>
							<p>Please fill out all fields.</p>
						</div>	
						<form method='post' id='myForm' action='updatesubject.php'>
							<fieldset>
								<legend>Subject Details</legend>
								<div class='row responsive-label'>
									<div class='col-sm-12 col-md-2'>
										<label for='subjectname'>Subject Name</label>
									</div>
									<div class='col-sm-12 col-md'>
										<input type='text' value='$subjectname' id='subjectname' name='subjectname' required='required' style='width:75%;'>
									</div>
								</div>
								<div class='row responsive-label'>
									<div class='col-sm-12 col-md-2'>
										<label for='subjectcode'>Subject Code</label>
									</div>
									<div class='col-sm-12 col-md'>
										<input type='text' value='$code' id='subjectcode' name='subjectcode' required='required' style='width:50%;'>
									</div>
								</div>
								<div class='row responsive-label'>
									<div class='col-sm-12 col-md-2'>
										<label for='subjectdesc'>Subject Description</label>
									</div>
									<div class='col-sm-12 col-md'>
										<textarea value='$subjectdesc' name='description' placeholder='Add new description...' style='width:95%;height:250px'></textarea>
									</div>
								</div>
								<div class='hide-form'>
									<input type='number' name='subjectid' class='hidden' value='$subjectid' id='hideform'>
								</div>
							</fieldset>
							<div class='row'>		
								<input type='submit' class='primary' value='Submit' style='margin-left:10px;'>
							</div>
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