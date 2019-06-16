<!DOCTYPE html>
<html>
	<head>
		<title>Web Dev Project</title>
		<link rel="icon" href="img/bird-bluetit.png">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mini.css/3.0.1/mini-default.min.css">
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
                        <label for="drawer-control" class="button drawer-toggle persistent"></label>
			<a href='login.php' class='logo'>
				<img src='img/bird-bluetit.png' width='50px'>
			</a>
			<a href='login.php' class='button'>McG VLE</a>
		</header>
		<div class="container">
		<div id="main">
			<div id="titlehead">
				<h3>McG Virtual Learning Environment</h3>
				<p>Please login using your unique email and password</p>
			</div>
			<form class="form-signin" id="myForm" action="secure/sign.php" method="POST">
				<fieldset>
					<legend>Login</legend>
					<div class="input-group vertical">
						<label for="email">email</label>
						<input type="email" value="" name="email" required="required" maxlength="30" style="width:85%;">
					</div>
					<div class="input-group vertical">
						<label for="password">password</label>
						<input type="password" value="" name="password" required="required" maxlength="30" style="width:85%;">
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
		<footer>
			<p> 40105701 | CSC7062 Web Development Project</p>
		</footer>	
	</body>
</html>