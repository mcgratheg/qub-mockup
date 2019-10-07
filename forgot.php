<?php
include('secure/connect/database.php');
include('secure/objects/user.php');
include('secure/objects/login.php');

$db = Database::getInstance();
$mysqli = $db->getConnection();

$user = new User($mysqli);
$login = new Login($mysqli);
 
?>
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
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script>

			jQuery(document).ready(function(){
				
			});	

		</script>
	</head>
	<body>
		<!-- Header -->
		<header class="sticky">
                    <label for="drawer control" class="button drawer-toggle persistent"></label>
			<a href='login.php' class='logo'>
				<img src='img/bird-bluetit.png' width='50px'>
			</a>
			<a href='login.php' class='button'>McG VLE</a>
		</header>
		<div class="container">
		<div id="main">
			<div id="titlehead">
				<h3>Forgot Password</h3>
				<p>Please enter your e-mail address. You will receive a new password via e-mail.</p>
			</div>
			<form class="form-signin" method="POST">
				<fieldset>
					<div class="input-group vertical">
						<label for="useremail">email</label>
						<input type="email" value="" name="email" required="required" style="width:85%;">
					</div>
					<div class="row">		
						<input type="submit" class="primary" value="Request Reset">
						<a href="login.php"><input type="button" class="secondary" value="Cancel"></a>
					</div>
				</fieldset>
			</form>
		</div>
		<?php
			if(isset($_POST) & !empty($_POST)){
			$postemail = trim($_POST['email']);
                        $result = $user->readUser($postemail);
				if($result){
					$pass = rand(999, 99999);
					$password_hash = md5($pass);

                                        $result = $login->updatePassword($password_hash, $postemail);
					if($result){
						$subject = "Your New Password";
 
						$message = "Hi " . $user->get_first_name() . ",
						Please use this password to login $pass
						Once logged in, please change your password as soon as possible.
						Regards,
						Site Admin";
						if(mail($postemail, $subject, $message)){
							echo "<p>Password has been sent, please check your email</p>";
						}else{
							echo "<p>Password has been sent, please check your email</p>";
						}
					}
 
				}else{
					echo "<p>Password has been sent, please check your email</p>";
				}
			}
 
 
?>
				<div class="clearfloat"></div>
				<!-- end of main content -->
		</div>
		<footer class="sticky">
			<p> 40105701 | CSC7062 Web Development Project</p>
		</footer>	
	</body>
</html>
<?php
	$mysqli->close();
?>