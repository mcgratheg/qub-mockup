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
include("objects/topic.php");
include("objects/reply.php");

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
                                        <?php if($user->type == 1){echo"<li><a href='admin/index.php' class='button'>Admin Portal</a></li>";}?>
					<li><a href="signout.php" class="button" id="signout">Sign Out</a></li>
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
				<?php
					$topicid = $_GET['topicid'];
					//echo "<h2>$topicid</h2>";
                                        
                                        $subject = new Subject($mysqli);
                                        $result = $subject->read_subject_topic($topicid);

					if($result->num_rows > 0) {
						while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
							$subject->name = $row["SubjectName"];
							$subject->code = $row["SubjectCode"];
							echo "<h2>$subject->code | $subject->name Forum</h2><br>";
						}
					
					
                                        $topic = new Topic ($mysqli);
                                        $topic_user = new User($mysqli);
                                        $topic_result = $topic->read_topic($topicid);
					if($topic_result->num_rows > 0) {
						while ($row = $topic_result->fetch_array(MYSQLI_ASSOC)) {
							$topic->id = $row["TopicID"];
							$topic->title = $row["TopicTitle"];
							$topic->content = $row["TopicContent"];
							$topic->date = date('d/m/y', strtotime($row["TopicDate"]));
							$topic_user->first_name = $row["FirstName"];
							$topic_user->last_name = $row["LastName"];
							$topic->topic_by_id = $row["Subject_ID"];
							
							echo "<div class='col-sm-12 col-md-9' id='topiccard'>
									<div class='card fluid'>
										<div class='section'>
											<div class='col-sm-12 col-md-3'>
												<p>$topic_user->first_name $topic_user->last_name</p>
												<p>Created $topic->date</p>
											</div>
											<div class='col-sm-12 col-md-9'>
												<h3>$topic->title</h3>
												<p>$topic->content</p>
											</div>
										</div>
									</div>
								</div>";
							
						}
					 
                                                $reply = new Reply($mysqli);
                                                $reply_user = new User($mysqli);
                                                $reply_result = $reply->read_reply($topicid);
						if($reply_result->num_rows > 0) {
							while ($row = $reply_result->fetch_array(MYSQLI_ASSOC)) {
								$reply->content = $row["ReplyContent"];
								$reply->date = date('d/m/y H:i', strtotime($row["ReplyDate"]));
								$reply_user->first_name = $row["FirstName"];
								$reply_user->last_name = $row["LastName"];
								$reply_user->type = $row["UserType_ID"];
								
								echo "<div class='col-sm-12' id='reply'>
										<div class='card fluid' id='replycard'>
											<div class='section'>
												<div class='col-sm-12 col-md-3'>
													<p>$reply_user->first_name $reply_user->last_name, ";
													
													if($reply_user->type == 2){
														echo "<b>Tutor</b>";
													}
													
												echo "</p>
													<p>$reply->date</p>
												</div>
												<div class='col-sm-12 col-sm-9'>
													<p>$reply->content</p>
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
												<input type='number' name='topic' class='hidden' value='$topic->id' id='hideform'>
												<input type='number' name='user' class='hidden' value='$user->id' id='hideform'>
											</div>
											<div class='row'>		
												<input type='submit' class='primary' value='Reply'>
											</div>	
									</fieldset>
								</form>
							</div>
							<br>";
					
						echo "<div class='row' id='nav'>
								<a href='forum.php?subject=$subject->code'><button class='inverse' id='button-right'>Back</button></a>
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