<?php
	session_start();
	
	if(!isset($_SESSION["cater_40105701"]))
	{
		header("Location: ../login.php");
		
	}
	
include("connect/database.php");
include("objects/user.php");
include("objects/login.php");

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
		<link rel="icon" href="../img/bird-bluetit.png">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://gitcdn.link/repo/Chalarangelo/mini.css/master/dist/mini-default.min.css">
		<link rel="stylesheet" href="../css/style.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>

			jQuery(document).ready(function(){
				
				jQuery('#myInput').on("keyup", function() {
					var value = $(this).val().toLowerCase();
					$('.card').filter(function() {
						$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					});	
				});
			
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
                                        <?php if($user->type == 1){ echo"<li><a href='admin/index.php' class='button'>Admin Portal</a></li>";}?>
					<li><a href="signout.php" class="button" id="signout">Sign Out</a></li>
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
			 <h3>Search Staff</h3>
			 <p>Find staff by name or by subject</p>
			 <input type="text" id="myInput" placeholder="Search for staff...">
			 <br><br>
			<?php 
				$staff = new User($mysqli);
                                $result = $staff->read_tutor();
				if($result->num_rows > 0) {
					while($row= $result->fetch_array(MYSQLI_ASSOC)) {
						$staff->id=$row["UserID"];
						$staff->first_name=$row["FirstName"];
						$staff->last_name=$row["LastName"];
						$staff->profile_image=$row["ProfileImage"];
						
						echo "<div class='col-sm-12 col-md-7'>
									<div class='card fluid'>
										<div class='section'>
											<div class='row'>
												<div class='col-sm-12 col-md-2' id='profileimage'>
													<img src='../img/$staff->profile_image' width='120px'>
												</div>
												<div class='col-sm-12 col-md'>
													<h4 class='search'><a href='displaystaff.php?id=$staff->id'>$staff->first_name $staff->last_name</a></h4>
												</div>	
											</div>
										</div>
									</div>
								</div>";
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