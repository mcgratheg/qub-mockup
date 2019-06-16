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
			
				jQuery(function() {
					var reply = $('.reply-box');
					
					reply.click(function() {
						reply.toggleClass('expanded-reply');
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
                                        <?php if($usertype == 1){echo"<li><a href='admin/index.php' class='button'>Admin Portal</a></li>";}?>
					<li><a href="signout.php" class="button" id="signout">Sign Out</a></li>
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
				<?php
					$topicid = $_GET['topicid'];
					//echo "<h2>$topicid</h2>";
					
					$subjectquery = "SELECT SubjectName, SubjectCode FROM 7062prosubject INNER JOIN 7062protopic ON 7062prosubject.SubjectID=7062protopic.Subject_ID WHERE TopicID = $topicid";
					$display = mysqli_query($conn, $subjectquery);
					if(mysqli_num_rows($display) > 0) {
						while ($row = mysqli_fetch_assoc($display)) {
							$subject = $row["SubjectName"];
							$code = $row["SubjectCode"];
							echo "<h2>$code | $subject Forum</h2><br>";
						}
					
					
					$query = "SELECT * FROM 7062protopic INNER JOIN 7062prouser ON 7062protopic.TopicBy_ID=7062prouser.UserID WHERE TopicID = $topicid";
					$display = mysqli_query($conn, $query);
					if(mysqli_num_rows($display) > 0) {
						while ($row = mysqli_fetch_assoc($display)) {
							$topicid = $row["TopicID"];
							$topictitle = $row["TopicTitle"];
							$topiccontent = $row["TopicContent"];
							$createdate = date('d/m/y', strtotime($row["TopicDate"]));
							$topicbyf = $row["FirstName"];
							$topicbyl = $row["LastName"];
							$subjectid = $row["Subject_ID"];
							
							echo "<div class='col-sm-12 col-md-9' id='topiccard'>
									<div class='card fluid'>
										<div class='section'>
											<div class='col-sm-12 col-md-3'>
												<p>$topicbyf $topicbyl</p>
												<p>Created $createdate</p>
											</div>
											<div class='col-sm-12 col-md-9'>
												<h3>$topictitle</h3>
												<p>$topiccontent</p>
											</div>
										</div>
									</div>
								</div>";
							
						}
					 
						$reply = "SELECT * FROM 7062proreply INNER JOIN 7062prouser ON 7062proreply.ReplyBy_ID=7062prouser.UserID WHERE ReplyTopic_ID = $topicid";
						$displayreply = mysqli_query($conn, $reply);
						if(mysqli_num_rows($displayreply) > 0) {
							while ($row = mysqli_fetch_assoc($displayreply)) {
								$replycontent = $row["ReplyContent"];
								$replydate = $row["ReplyDate"];
								$displaydate = date('d/m/y H:i', strtotime($replydate));
								$replybyf = $row["FirstName"];
								$replybyl = $row["LastName"];
								$usertype = $row["UserType_ID"];
								
								echo "<div class='col-sm-12' id='reply'>
										<div class='card fluid' id='replycard'>
											<div class='section'>
												<div class='col-sm-12 col-md-3'>
													<p>$replybyf $replybyl, ";
													
													if($usertype == 2){
														echo "<b>Tutor</b>";
													}
													
												echo "</p>
													<p>$displaydate</p>
												</div>
												<div class='col-sm-12 col-sm-9'>
													<p>$replycontent</p>
												</div>
											</div>
										</div>
									</div>";
							
							}
						} else {
							echo "<p>No replies available</p>";
						}
						
						echo "<div class='col-sm-12 col-md-9'>
								<form class='form-addreply' id='myForm' action='insertreply.php' method='POST'>
									<fieldset>
										<legend>Add Reply</legend>
											<div class='input-group vertical'>
												<label for='replycontent'>Content</label>
												<textarea class='reply-box' value='' name='reply' required='required' style='width:95%;height:250px'></textarea>
											</div>
											<div class='hide-form'>
												<input type='number' name='topic' class='hidden' value='$topicid' id='hideform'>
												<input type='number' name='user' class='hidden' value='$userid' id='hideform'>
											</div>
											<div class='row'>		
												<input type='submit' class='primary' value='Reply'>
											</div>	
									</fieldset>
								</form>
							</div>
							<br>";
					
						echo "<div class='row' id='nav'>
								<a href='forum.php?subject=$code'><button class='inverse' id='button-right'>Back</button></a>
							</div>
							<br>";
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