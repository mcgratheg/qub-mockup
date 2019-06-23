<?php
	session_start();
	
	if(!isset($_SESSION["cater_40105701"]))
	{
		header("Location: ../login.php");
		
	}
	
include("connect/database.php");
include("objects/user.php");
include("objects/login.php");
include("objects/subject.php");

$email = $_SESSION["cater_40105701"];

$db = Database::getInstance();
$mysqli = $db->getConnection();

$user = new User($mysqli);
$login = new Login($mysqli);

$stmt = $user->readUser($email);	
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
			<a href='displayprofile.php?userid=$user->id' class='button' id='userbutton'>$user->first_name $user->last_name</a>
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
					<?php echo"<li><a href='displayprofile.php?userid=$user->id' class='button'>$user->first_name $user->last_name</a></li>
					<li><a href='index.php' class='button'>Home</a></li>";?>
					<li><a href="subjectsearch.php" class="button">Subjects</a></li>
					<li><a href="staffsearch.php" class="button">Staff</a></li>
					<?php if($user->type==1){echo"<li><a href='admin/index.php' class='button'>Admin Portal</a></li>";}?>
					<li><a href="signout.php" class="button" id="signout">Sign Out</a></li>
					
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
			<?php 
				$subjectcode = $_GET["subject"];
                                
                                $subject = new Subject($mysqli);
				$result = $subject->read($subjectcode);
				
				if($result->num_rows == 1) {
					$row = $result->fetch_array(MYSQLI_ASSOC);
						$subject->name = $row["SubjectName"];
						$subject->description = $row["SubjectDescription"];
                                                $subject->code = $row["SubjectCode"];
						
					 echo "<div id='titlehead'>
								<h2>$subject->code : $subject->name</h2>
								<div class='row'>
									<h5>Information</h5>
									<span>|</span>
									<p><a href='documents.php?subject=$subject->code'>Resources</a></p>
									<span>|</span>
									<p><a href='forum.php?subject=$subject->code'>Forum</a></p>
								</div>	
							</div><br>";	
					
					if($subject->description!=""){
						echo "<div class='col-sm-12 col-md-8'>
									<h4>Module Description</h4>
									<pre>$subject->description</pre>
								</div>";
						}else{
						echo "<div class='col-sm-12 col-md-8'>
								<h4>Module Description</h4>
								<p>No description available</p>
							</div>";
						}
					
				}
				
				if($user->type==1){
					echo "<div class='row' id='nav'>
							<button class='primary' style='margin-left:20px;'><a href='admin/editsubject.php?subject=$subject->code'>Edit Subject</a></button>
						</div>";
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