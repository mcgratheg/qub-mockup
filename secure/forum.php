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
					$code = $_GET['subject'];
					//echo "<h2>$subjectid</h2>";
					$query = "SELECT UserID FROM 7062prouser INNER JOIN 7062proclassdetails ON 7062prouser.UserID=7062proclassdetails.User_ID WHERE UserID=$userid";
					$result = mysqli_query($conn, $query);
					if(mysqli_num_rows($result) == 1 || $usertype!=3){
						
						$query = "SELECT SubjectName FROM 7062prosubject WHERE SubjectCode = '$code'";
						$display = mysqli_query($conn, $query);
						if(mysqli_num_rows($display) > 0) {
							while ($row = mysqli_fetch_assoc($display)) {
								$subject = $row["SubjectName"];
								echo "<div id='titlehead'>
									<h2>$code : $subject</h2>
									<div class='row'>
										<p><a href='displaysubject.php?subject=$code'>Information</a></p>
										<span>|</span>
										<p><a href='documents.php?subject=$code'>Resources</a></p>
										<span>|</span>
										<h5>Forum</h5>
									</div>	
								</div><br>";	
						
							
						
					

					
						$query = "SELECT * FROM 7062protopic INNER JOIN 7062prouser ON 7062protopic.TopicBy_ID=7062prouser.UserID INNER JOIN 7062prosubject ON
						7062protopic.Subject_ID=7062prosubject.SubjectID WHERE SubjectCode = '$code'";
						$display = mysqli_query($conn, $query);
						if(mysqli_num_rows($display) > 0) {
							while ($row = mysqli_fetch_assoc($display)) {
								$topicid = $row["TopicID"];
								$topictitle = $row["TopicTitle"];
								$topiccontent = $row["TopicContent"];
								$topicsubcont = substr($topiccontent, 0, 50);
								$createdate = date('d/m/y', strtotime($row["TopicDate"]));
								$topicbyf = $row["FirstName"];
								$topicbyl = $row["LastName"];
							
								$reply = "SELECT 7062prouser.FirstName, 7062prouser.LastName FROM 7062prouser INNER JOIN
								7062proreply ON 7062prouser.UserID=7062proreply.ReplyBy_ID WHERE 7062proreply.ReplyTopic_ID = $topicid ORDER BY 
								7062proreply.ReplyDate DESC LIMIT 1";
								$result = mysqli_query($conn, $reply);
							
								echo "<div class='col-sm-12'>
										<div class='card fluid'>
											<div class='section'>
												<a href='displaytopic.php?topicid=$topicid'><h3>$topictitle</h3></a>
												<p>$topicsubcont...</p>
												<div class='row'>
													<p>By $topicbyf $topicbyl</p>
													<p>|</p>
													<p>Created $createdate</p>";
												if(mysqli_num_rows($result) ==1) {
													while($r = mysqli_fetch_assoc($result)){
														$replyf = $r["FirstName"];
														$replyl = $r["LastName"];
														echo "<p>|</p>
															<p>Last reply by $replyf $replyl</p>";
													}
												}
								echo			"</div>
											</div>
										</div>
									</div>";
							
							}
						} else {
							echo "<div class='row'>
									<p>No topics available</p>
								</div>";
						}
							}
						}
					
						echo "<br><div class='row' id='nav'>
								<a href='addtopic.php?subject=$code'><button class='primary'>Add Topic</button></a>
							</div>";	
					
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