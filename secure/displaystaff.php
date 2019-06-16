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
				
				 jQuery('input[type="file"]').change(function(e){
						
						var fileName = e.target.files[0].name;
						var fileSize = e.target.files[0].size;
						//alert('The file "' + fileName +  '" has been selected.');
						jQuery('#filepath').data("image", fileName);
						
						if (fileSize>2097152) {
							alert('File cannot be more than 2MB!');
							jQuery('#imginput').val("");
							jQuery('#filepath').removeData("image");
						}
						
						
						jQuery("#file").text(fileName);
						
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
			<div class="col-sm-12 com-md-8 col-lg-10" id="main">
				<?php
					$id = $_GET['id'];
					//echo "$userid";
					
					
					$query = "SELECT FirstName, LastName, ProfileImage, Email, RoomNumber, RoomAddress, PhoneExtension FROM 7062prouser INNER JOIN 7062prologindetails ON 
					7062prouser.UserID=7062prologindetails.User_ID INNER JOIN 7062protutordetails ON 7062prouser.UserID=7062protutordetails.User_ID WHERE UserID=$id";
					$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
					if(mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) {
							$firstname = $row["FirstName"];
							$lastname = $row["LastName"];
							$image = $row["ProfileImage"];
							$email = $row["Email"];
							$room = $row["RoomNumber"];
							$address = $row["RoomAddress"];
							$phone = $row["PhoneExtension"];
							
							echo "<div class='col-sm-12 col-md'>
									<div class='card fluid'>
										<div class='section'>
											<div class='row'>
												<div class='col-sm-12 col-md-2' id='profileimage'>
													<img src='../img/$image'>
												</div>
												<div class='col-sm-12 col-md'>
													<h4 class='search'>$firstname $lastname</h4>";
													
							$subjectquery = "SELECT SubjectName, SubjectCode FROM 7062prosubject INNER JOIN 7062proclassdetails ON 7062prosubject.SubjectID=7062proclassdetails.Subject_ID
							INNER JOIN 7062prouser ON 7062proclassdetails.User_ID=7062prouser.UserID WHERE UserID=$id";
							$subjectresult = mysqli_query($conn,$subjectquery) or die(mysqli_error($conn));
							if(mysqli_num_rows($subjectresult) > 0){
								echo "<div class='row'>
										<div class='col-sm-3 col-md-1' id='labels'>
											<p>Subjects:</p>
										</div>
										<div class='col-sm-9 col-md-11' id='info'>";
								while($row=mysqli_fetch_assoc($subjectresult)){
										$code = $row["SubjectCode"];
										$subject = $row["SubjectName"];
											echo "<p>$code: $subject</p>";
											
								}
								echo	"</div>
										</div>
										<br>";
							}
									echo			"<div class='row'>
														<div class='col-sm-3 col-md-1' id='labels'>
															<p>Email:</p>
															<p>Room:</p>
														</div>
														<div class='col-sm-9 col-md-11' id='info'>
															<p><a href='mailto:$email' data-rel='external'>$email</a></p>
															<a href='https://maps.google.com/?q=$address'><p>$room, $address</p></a>
														</div>
													</div>
													<div class='row'>
														<div class='col-sm-3 col-md-1' id='labels'>
															<p>Phone:</p>
														</div>
														<div class='col-sm-9 col-md-11' id='info'>
															<p>$phone</p>
														</div>
													</div>
												</div>	
											</div>
										</div>
									</div>
								</div>";											

							
						}
					}else {
						echo "<p>No information available</p>";
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