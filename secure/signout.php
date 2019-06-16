<?php
session_start();

if(!isset($_SESSION["cater_40105701"]))
{
	header("Location: ../login.php");
}else{
	unset($_SESSION["cater_40105701"]);
	header("Location: ../login.php");
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
		<link rel="stylesheet" href="css/style.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>

			jQuery(document).ready(function(){
				
			});	

		</script>
	</head>
	<body>
		<!-- Header -->
		<header class="sticky">
                        <a href="secure/index.php" class="logo"><img src="../img/bird-bluetit.png"></a>
			<a href="secure/index.php" class="button">Home</a>
			<a href="#" class="button">Search</a>
		</header>
		<div class="container">
		<div id="main">
			<div id="titlehead">
				<h3>Login Form</h3>
				<p>Please login using your unique email and password</p>
			</div>
			<form class="form-signin" id="myForm" action="secure/sign.php" method="POST">
				<fieldset>
					<legend>Login</legend>
					<div class="input-group vertical">
						<label for="email">email</label>
						<input type="email" value="" name="email" required="required" style="width:75%;">
					</div>
					<div class="input-group vertical">
						<label for="password">password</label>
						<input type="password" value="" name="password" required="required" style="width:75%;">
					</div>
					<div class="row">		
						<input type="submit" class="primary" value="Submit">
						<a href="forgot.php"><input type="button" class="secondary" value="Forgot Password"></a>
					</div>
				</fieldset>
			</form>
		</div>
				<div class="clearfloat"></div>
				<!-- end of main content -->
		</div>
		<footer class="sticky">
			<p> 40105701 | CSC7062 Web Development Project</p>
		</footer>	
	</body>
</html>