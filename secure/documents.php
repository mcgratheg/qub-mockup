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
						jQuery('#filepath').data("filename", fileName);
						
						if (fileSize>2097152) {
							alert('File cannot be more than 2MB!');
							jQuery('#fileinput').val("");
							jQuery('#filepath').removeData("filename");
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
                                        <?php if($usertype == 1){ echo"<li><a href='admin/index.php' class='button'>Admin Portal</a></li>";}?>
					<li><a href="signout.php" class="button" id="signout">Sign Out</a></li>
					
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
			<?php 
				$code = $_GET["subject"];
				
				$query = "SELECT UserID FROM 7062prouser INNER JOIN 7062proclassdetails ON 7062prouser.UserID=7062proclassdetails.User_ID WHERE UserID=$userid";
				$result = mysqli_query($conn, $query);
				if(mysqli_num_rows($result) == 1 || $usertype!=3){
					$query = "SELECT SubjectID, SubjectLevel_ID, SubjectName FROM 7062prosubject WHERE SubjectCode = '$code'";
					$display = mysqli_query($conn, $query);
						if(mysqli_num_rows($display) > 0) {
						while ($row = mysqli_fetch_assoc($display)) {
							$subjectid = $row["SubjectID"];
							$subjectlevel = $row["SubjectLevel_ID"];
							$subject = $row["SubjectName"];
							echo "<div id='titlehead'>
									<h2>$code : $subject</h2>
									<div class='row'>
										<p><a href='displaysubject.php?subject=$code'>Information</a></p>
										<span>|</span>
										<h5>Resources</h5>
										<span>|</span>
										<p><a href='forum.php?subject=$code'>Forum</a></p>
									</div>	
								</div><br>";	
					

				$documentquery = "SELECT * FROM 7062prodocument INNER JOIN 7062prosubject ON 7062prodocument.Subject_ID=7062prosubject.SubjectID INNER JOIN 7062prouser ON
				7062prodocument.User_ID=7062prouser.UserID WHERE SubjectCode='$code' ORDER BY DateAdded DESC";
				$documentresult = mysqli_query($conn, $documentquery) or die(mysqli_error($conn));
				
				if(mysqli_num_rows($documentresult) > 0) {
					//echo "<p>Stuff found in table</p>";
					echo "<table>
							<thead>
								<tr>
									<th>Name</th>
									<th>Tutor</th>
									<th>Added</th>
									<th>Link</th>
								</tr>	
							</thead>
							<tbody id='myTable'>";
					while($row = mysqli_fetch_assoc($documentresult)){
						$filepath = $row["Docpath"];
						$fileext = pathinfo($filepath, PATHINFO_EXTENSION);
						$filename = basename($filepath);
						$uploadby = $row["User_ID"];
						$uploadfname = $row["FirstName"];
						$uploadlname = $row["LastName"];
						$dateadded = date('d/m/y', strtotime($row["DateAdded"]));
						
						echo "<tr>
								<td data-label='Name'><a href='uploads/$filepath'>$filename</a></td>
								<td data-label='Tutor'><a href='displaystaff.php?id=$uploadby'>$uploadfname $uploadlname</a></td>
								<td data-label='Added'>$dateadded</td>
								<td data-label='Link'><a href='uploads/$filepath' download><img src='../img/Download-01.png' width='40px;'></a></td>
							</tr>";
					}
					echo "</tbody>
					</table>";
				}else{
					echo "<p>No documents available</p>";
				}
				
				if($usertype !=3) {	
						echo "<form method='post' id='uploadForm' action='uploadfile.php?userid=$userid' enctype='multipart/form-data'>
								<div class='row responsive-label'>
									<label for='fileinput' id='upload-file' class='button'>Upload File</label>
									<input type='file' id='fileinput' name='uploadfile'>
									<div id='filepath' style='margin-left:10px;'>File Name: <div id='file'></div></div>
								</div>
								<div class='hide-form'>
									<input type='number' name='user' class='hidden' value='$userid' id='hideform'>
									<input type='number' name='subject' class='hidden' value='$subjectid' id='hideform'>
									<input type='number' name='subjectlevel' class='hidden' value='$subjectlevel' id='hideform'>
									<input type='text' name='subjectcode' class='hidden' value='$code' id='hideform'>
								</div>
									<div class='row'>
										<input type='submit' class='primary' value='Submit' style='margin-left:10px;'>
									</div>
								</form>";
							}
						}
					}
				}else{
					echo "<p>Oops! You are not permitted to view this page.</p>";
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