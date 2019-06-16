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
					$id = $_GET['userid'];
					//echo "$userid";
					
					$query = "SELECT * FROM 7062prouser INNER JOIN 7062prologindetails ON 7062prouser.UserID=7062prologindetails.User_ID WHERE UserID=$id";
					$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
					if(mysqli_num_rows($result) == 1) {
						while($row = mysqli_fetch_assoc($result)) {
							$firstname = $row["FirstName"];
							$lastname = $row["LastName"];
							$dateofbirth = $row["DateOfBirth"];
							$displaydate = date('d/m/Y', strtotime($dateofbirth));
							$homeaddress = $row["Address"];
							$homecity = $row["City"];
							$postcode = $row["PostCode"];
							$image = $row["ProfileImage"];
							$email = $row["Email"];
							$homephone = $row["HomeNumber"];
							$mobilephone = $row["MobileNumber"];
							
							echo "<div id='titlehead'>
									<h4>Personal Details</h4>
								</div>	
									<div class='col-sm-12'>
										<fieldset>
											<legend>Basic Info</legend>
											<div id='profileimage'>
												<img src='../img/$image' width='150px'>
											</div>";
										if($usertype !=3) {	
											echo "<form method='post' id='uploadForm' action='updateimage.php?userid=$id' enctype='multipart/form-data'>
												<div class='row responsive-label'>
													<label for='imginput' id='upload-file' class='button'>Upload Image</label>
													<input type='file' id='imginput' name='profileimg' class='hidden'>
													<div id='filepath' style='margin-left:10px;'>File Name: <div id='file'></div></div>
												</div>
												<div class='hide-form'>
													<input type='number' name='user' class='hidden' value='$id' id='hideform'>
												</div>
												<div class='row'>
													<input type='submit' class='primary' value='Submit' style='margin-left:10px;'>
												</div>
											</form>";
										}											
										
									echo "<div class='row'>
											<div class='col-sm-4 col-md-2' id='labels'>
												<p>Name:</p>
											</div>
											<div class='col-sm-8 col-md-10' id='info'>
												<p>$firstname $lastname</p>
											</div>
										</div>
										<div class='row'>
											<div class='col-sm-4 col-md-2' id='labels'>
												<p>Date Of Birth:</p>
											</div>
											<div class='col-sm-8 col-md-10' id='info'>	
												<p>$displaydate</p>
											</div>
										</div>
										<div class='row'>
											<div class='col-sm-4 col-md-2' id='labels'>		
												<p>Address:</p>
											</div>
											<div class='col-sm-8 col-md-10' id='info'>		
												<p>$homeaddress<br>$homecity<br>$postcode</p>
											</div>
										</div>	
										</fieldset>
										<br>
										<fieldset>
											<legend>Login Details</legend>
											<div class='row'>
												<div class='col-sm-4 col-md-2' id='labels'>
													<p>Email:</p>
												</div>
												<div class='col-sm-8 col-md-10' id='info'>
													<p>$email</p>
												</div>
											</div>
											<div class='row'>
												<div class='col-sm-4 col-md-2' id='labels'>
													<p>Password:</p>
												</div>
												<div class='col-sm-8 col-md-10' id='info'>
													<p>********</p>
													<p><a href=changepassword.php?userid=$id>Change Password</a></p>
												</div>
											</div>	
										</fieldset>
										<br>";
							

										
										echo "<fieldset>
												<legend>Contact Details</legend>
												<div class='row'>
													<div class='col-sm-4 col-md-2' id='labels'>
														<p>Home No:</p>
													</div>
													<div class='col-sm-8 col-md-10' id='info'>";
												
										if ($homephone!=NULL) {		
												echo "<p>$homephone</p>";	
										}else {
											echo "<p>N/A</p>";

										}
										echo "</div>
											</div>
											<div class='row'>
												<div class='col-sm-4 col-md-2' id='labels'>
													<p>Mobile No:</p>
												</div>
												<div class='col-sm-8 col-md-10' id='info'>";
												
										if ($mobilephone!=NULL) {		
											echo "<p>$mobilephone</p>";	
										}else {
											echo "<p>N/A</p>";

										}
										echo "</div>
										</div>";
												
								if ($usertype !=3) {
								$tutorquery = "SELECT * FROM 7062protutordetails WHERE User_ID=$id";
								$tutorresult = mysqli_query($conn, $tutorquery) or die (mysqli_error($conn));
								if(mysqli_num_rows($tutorresult) == 1){
									while($row = mysqli_fetch_assoc($tutorresult)){
										$roomnumber = $row["RoomNumber"];
										$roomaddress = $row["RoomAddress"];
										$phonenumber = $row["PhoneExtension"];	
												
										echo 	"<div class='row'>
													<div class='col-sm-4 col-md-2' id='labels'>
														<p>Room:</p>
													</div>
													<div class='col-sm-8 col-md-10' id='info'>
														<p>$roomnumber</p>
													</div>
												</div>
												<div class='row'>
													<div class='col-sm-4 col-md-2' id='labels'>
														<p>Address:</p>
													</div>
													<div class='col-sm-8 col-md-10' id='info'>
														<p>$roomaddress</p>
													</div>
												</div>
												<div class='row'>
													<div class='col-sm-4 col-md-2' id='labels'>
														<p>Phone Extension:</p>
													</div>
													<div class='col-sm-8 col-md-10' id='info'>
														<p>$phonenumber</p>
													</div>	
												</div>";	
												
										
										
									}
								}
							}
							echo "</fieldset>
									<br>";
							echo "<div class='row' id='nav'>
								<a href='editprofile.php?userid=$id'><button class='primary'>Edit Profile</button></a>
							</div>
							<br>
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
<?php
	mysqli_close($conn);
?>