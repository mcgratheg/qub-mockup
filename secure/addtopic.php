<?php
	session_start();
	
	if(!isset($_SESSION["cater_40105701"]))
	{
		header("Location: ../login.php");
		
	}
	
	
	include("connect/conn.php");
	
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
		<link rel="icon" href="../img/bird-bluetit.png">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://gitcdn.link/repo/Chalarangelo/mini.css/master/dist/mini-default.min.css">
		<link rel="stylesheet" href="../css/style.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
		<script src="../js/myForm.js"></script>
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
                                        <?php
                                            if($usertype == 1) {
                                                echo"<li><a href='admin/index.php' class='button'>Admin Portal</a></li>";
                                            }
                                        ?>
					<li><a href="signout.php" class="button" id="signout">Sign Out</a></li>
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
				<?php
					$subjectcode = $_GET['subject'];
					//echo "<h2>$subjectid</h2>";
					
					$query = "SELECT `SubjectID`, `SubjectName`, `SubjectCode` FROM `7062prosubject` WHERE `SubjectCode` = '$subjectcode'";
					$display = mysqli_query($conn, $query);
					if(mysqli_num_rows($display) > 0) {
						while ($row = mysqli_fetch_assoc($display)) {
							$subjectid = $row["SubjectID"];
							$subject = $row["SubjectName"];
							$code = $row["SubjectCode"];
							echo "<h2>$subjectcode | $subject Forum</h2>";
						}
					}
					
				echo	"<div id='titlehead'>
							<h4>Add Topic</h4>
						</div><br>
						<form class='form-addtopic' id='myForm' action='inserttopic.php' method='POST'>
				<fieldset>
					<legend>Topic</legend>
					<div class='row responsive-label'>
						<div class='col-sm-12 col-md-2'>
							<label for='topictitle'>Title</label>
						</div>
						<div class='col-sm-12 col-md'>
							<input type='text' value='' id='title' name='title' style='width:85%;'>
						</div>
					</div>
					<div class='row responsive-label'>
						<div class='col-sm-12 col-md-2'>
							<label for='topiccontent'>Content</label>
						</div>
						<div class='col-sm-12 col-md'>	
							<textarea value='' name='content' style='width:95%; height:200px;'></textarea>
						</div>
					</div>
					<div class='hide-form'>
						<input type='number' name='subject' class='hidden' value='$subjectid' id='hideform'>
						<input type='number' name='user' class='hidden' value='$userid' id='hideform'>
					</div>
					<div class='row'>		
						<input type='submit' class='primary' value='Submit'>
						<a href='forum.php?subject=$code'><input type='button' class='secondary' value='Cancel'></a>
					</div>
				</fieldset>
			</form>";
						
					
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