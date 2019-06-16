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
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script>

			jQuery(document).ready(function(){
				
				jQuery('#myInput').on("keyup", function() {
					var value = $(this).val().toLowerCase();
					$('#myTable tr').filter(function() {
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
			 <h3>Search Users</h3>
			 <p>Find users by any field</p>
			 <input type="text" id="myInput" placeholder="Search for users...">
			 <br>
			<?php 
				echo "<div class='row' id='nav'>
						<button class='primary' style='margin-left:20px;'><a href='adduser.php'>Add User</a></button>
					</div><br>";
					
				$query = "SELECT UserID, Type, FirstName, LastName FROM 7062prouser INNER JOIN 7062prousertype ON 7062prouser.UserType_ID=7062prousertype.UserTypeID WHERE NOT UserType_ID=1
				ORDER BY UserTypeID, LastName";
				$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
				if(mysqli_num_rows($result) > 0) {
					echo "<table>
								<thead>
									<tr>
										<th>ID</th>
										<th>First Name</th>
										<th>Last Name</th>
										<th>User Type</th>
									</tr>	
								</thead>
								<tbody id='myTable'>";
					while($row=mysqli_fetch_assoc($result)) {
						$id = $row["UserID"];
						$fname = $row["FirstName"];
						$lname = $row["LastName"];
						$type = $row["Type"];
						
							echo "<tr>
									<td data-label='ID'><a href='displayuser.php?id=$id'>$id</a></td>
									<td data-label='First Name'>$fname</td>
									<td data-label='Last Name'>$lname</td>
									<td data-label='User Type'>$type</td>
								</tr>";	
						
					}
					echo "</tbody>
					</table>";
				} else{
					echo "<p>No data in table</p>";
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