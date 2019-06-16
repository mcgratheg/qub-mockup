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
	
	
	$subjectupload = $_POST["subject"];
	$subjectlevelup = $_POST["subjectlevel"];
	$subjectcode = $_POST["subjectcode"];
	$userupload = $_POST["user"];
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
	$uploadfile = basename($_FILES["uploadfile"]["name"]);
	$uploadOk = 1;
	$msg = "";
	$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["uploadfile"]["tmp_name"]);
			if($check !== false) {
			$errmsg = "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
			} else {
				$errmsg = "File is not an image.";
				$uploadOk = 0;
			}
		}
	// Check if file already exists
	if (file_exists($target_file)) {
		$errmsg = "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["uploadfile"]["size"] > 2097152) {
		$errmsg = "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$msg = "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
			$msg = "The file ". basename( $_FILES["uploadfile"]["name"]). " has been uploaded.";
			
		$fileinsert = "INSERT INTO `7062prodocument`(`User_ID`, `SubjectLevel_ID`, `Subject_ID`, `Docpath`) VALUES ($userupload,$subjectlevelup,$subjectupload,'$uploadfile')";
		$uploadresult = mysqli_query($conn, $fileinsert) or die(mysqli_error($conn));
			
		} else {
			$msg = "Sorry, there was an error uploading your file.";
		}
	}

		
	
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
			
			
			if($uploadOK==0) {
			echo "<div>
					<p>$msg</p>
				</div>";
			} else {		
			echo "<div>		
					<p>$errmsg</p>
				</div>";
			}
			echo "<div class='row' id='nav'>
					<a href='documents.php?subject=$subjectcode'><button class='inverse'>Back</button></a>
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
<?php
	mysqli_close($conn);
?>	