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
				echo "<div class='row' id='titlehead'>
						<h3>Hi, $userfirst!</h3>
					</div><br><br>";
					
				echo "<table>
							<thead>
								<tr>
									<th>User Type</th>
									<th>Count</th>
								</tr>	
							</thead>
							<tbody id='myTable'>";	
					$counttutor = "SELECT COUNT(`UserID`) AS 'COUNT' FROM `7062prouser` WHERE `UserType_ID`=2";
					$tutorresult = mysqli_query($conn, $counttutor) or die(mysqli_error($conn));
					while($count = mysqli_fetch_assoc($tutorresult)){
						$tutors = $count["COUNT"];
						echo "<tr>
								<td data-label='User Type'>Tutors</td>
								<td data-label='Count'>$tutors</td>
							</tr>";
					}
					$countstudent = "SELECT COUNT(`UserID`) AS 'COUNT' FROM `7062prouser` WHERE `UserType_ID`=3";
					$studentresult = mysqli_query($conn, $countstudent) or die(mysqli_error($conn));
					while($count = mysqli_fetch_assoc($studentresult)){
						$students = $count["COUNT"];
						echo "<tr>
								<td data-label='User Type'>Students</td>
								<td data-label='Count'>$students</td>
							</tr>";
					}
					echo "</tbody>
						</table>";
						
					echo "<div class='row' id='nav'>
							<button class='primary' style='margin-left:20px;'><a href='usersearch.php'>Search Users</a></button>
						</div><br>";

					echo "<table>
							<thead>
								<tr>
									<th>User Type</th>
									<th>Count</th>
								</tr>	
							</thead>
							<tbody id='myTable'>";							
					$count01 = "SELECT COUNT(`SubjectID`) AS 'COUNT' FROM `7062prosubject` WHERE `SubjectLevel_ID`=1";
					$result01 = mysqli_query($conn, $count01) or die(mysqli_error($conn));
					while($count = mysqli_fetch_assoc($result01)){
						$level = $count["COUNT"];
						echo "<tr>
								<td data-label='Level'>Level 01</td>
								<td data-label='Count'>$level</td>
							</tr>";
					}
					$count02 = "SELECT COUNT(`SubjectID`) AS 'COUNT' FROM `7062prosubject` WHERE `SubjectLevel_ID`=2";
					$result02 = mysqli_query($conn, $count02) or die(mysqli_error($conn));
					while($count = mysqli_fetch_assoc($result02)){
						$level = $count["COUNT"];
						echo "<tr>
								<td data-label='Level'>Level 02</td>
								<td data-label='Count'>$level</td>
							</tr>";
					}
					$count03 = "SELECT COUNT(`SubjectID`) AS 'COUNT' FROM `7062prosubject` WHERE `SubjectLevel_ID`=3";
					$result03 = mysqli_query($conn, $count03) or die(mysqli_error($conn));
					while($count = mysqli_fetch_assoc($result03)){
						$level = $count["COUNT"];
						echo "<tr>
								<td data-label='Level'>Level 03</td>
								<td data-label='Count'>$level</td>
							</tr>";
					}
					$count04 = "SELECT COUNT(`SubjectID`) AS 'COUNT' FROM `7062prosubject` WHERE `SubjectLevel_ID`=4";
					$result04 = mysqli_query($conn, $count04) or die(mysqli_error($conn));
					while($count = mysqli_fetch_assoc($result04)){
						$level = $count["COUNT"];
						echo "<tr>
								<td data-label='Level'>Level 04</td>
								<td data-label='Count'>$level</td>
							</tr>";
					}
					$count05 = "SELECT COUNT(`SubjectID`) AS 'COUNT' FROM `7062prosubject` WHERE `SubjectLevel_ID`=5";
					$result05 = mysqli_query($conn, $count05) or die(mysqli_error($conn));
					while($count = mysqli_fetch_assoc($result05)){
						$level = $count["COUNT"];
						echo "<tr>
								<td data-label='Level'>Level 07</td>
								<td data-label='Count'>$level</td>
							</tr>";
					}
					$count06 = "SELECT COUNT(`SubjectID`) AS 'COUNT' FROM `7062prosubject` WHERE `SubjectLevel_ID`=6";
					$result06 = mysqli_query($conn, $count06) or die(mysqli_error($conn));
					while($count = mysqli_fetch_assoc($result06)){
						$level = $count["COUNT"];
						echo "<tr>
								<td data-label='Level'>Level 08</td>
								<td data-label='Count'>$level</td>
							</tr>";
					}
					$count07 = "SELECT COUNT(`SubjectID`) AS 'COUNT' FROM `7062prosubject` WHERE `SubjectLevel_ID`=7";
					$result07 = mysqli_query($conn, $count07) or die(mysqli_error($conn));
					while($count = mysqli_fetch_assoc($result07)){
						$level = $count["COUNT"];
						echo "<tr>
								<td data-label='Level'>Level 09</td>
								<td data-label='Count'>$level</td>
							</tr>";
					}
					echo "</tbody>
						</table>";
						
					echo "<div class='row' id='nav'>
							<button class='primary' style='margin-left:20px;'><a href='../subjectsearch.php'>Search Subjects</a></button>
						</div><br>";
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