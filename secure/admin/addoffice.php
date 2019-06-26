<?php
session_start();

if (!isset($_SESSION["cater_40105701"])) {
    header("Location: ../../login.php");
}

include("../connect/database.php");
include("../objects/user.php");
include("../objects/login.php");
include("../objects/usertype.php");

$email = $_SESSION["cater_40105701"];

$db = Database::getInstance();
$mysqli = $db->getConnection();

$user = new User($mysqli);
$login = new Login($mysqli);

$stmt = $user->readUser($email);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Web Dev Project</title>
        <link rel="icon" href="../../img/bird-bluetit.png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://gitcdn.link/repo/Chalarangelo/mini.css/master/dist/mini-default.min.css">
        <link rel="stylesheet" href="../../css/style.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>

            jQuery(document).ready(function () {


            });

        </script>
    </head>
    <body>
        <!-- Header -->
        <header class="sticky">
            <label for="drawer-control" class="button drawer-toggle persistent"></label>
<?php echo"<a href='index.php' class='logo'>
			<img src='../../img/bird-bluetit.png' width='50px'></a>
			<a href='index.php' class='button'>McG VLE</a>
			<a href='../displayprofile.php?userid=$user->id' class='button' id='userbutton'>$user->first_name $user->last_name</a>
                        <span>|</span>
                        <a href='../signout.php' class='button'>Sign Out</a>"; ?>
        </header>
        <div class="container">
            <div class="row">
                <input type="checkbox" id="drawer-control" class="drawer">
                <nav class="drawer col-md-4 col-lg-2">
                    <label for="drawer-control" class="drawer-close"></label>
                    <ul>
                        <li><h4>Navigation</h4></li>
<?php echo"<li><a href='../displayprofile.php?userid=$user->id' class='button'>$user->first_name $user->last_name</a></li>
					<li><a href='index.php' class='button'>Home</a></li>"; ?>
                        <li><a href="../subjectsearch.php" class="button">Subjects</a></li>
                        <li><a href="../staffsearch.php" class="button">Staff</a></li>
                        <li><a href="../signout.php" class="button" id="signout">Sign Out</a></li>

                    </ul>
                </nav>
                <div class="col-sm-12 col-md-8 col-lg-10" id="main">
<?php
$id = $_GET["id"];
//echo $id;


$user_profile = new User($mysqli);
$user_login = new Login($mysqli);
$user_type = new UserType($mysqli);
$user_result = $user_profile->readAll($user_type, $user_login, $id);

echo "<div id='titlehead'>
									<h4>Office Details</h4>
									<br>
									<p>$user_profile->first_name $user_profile->last_name</p>
								</div>
								<form method='post' id='myForm' action='insertoffice.php'>
									<fieldset>
										<div class='row responsive-label'>
											<div class='col-sm-12 col-md-2'>
												<label for='room'>Room</label>
											</div>
											<div class='col-sm-12 col-md'>
												<input type='text' value='' name='room' style='width:65%;'>
											</div>
										</div>
										<div class='row responsive-label'>
											<div class='col-sm-12 col-md-2'>
												<label for='address'>Address</label>
											</div>
											<div class='col-sm-12 col-md'>
												<input type='text' value='' name='address' style='width:65%;'>
											</div>
										</div>
										<div class='row responsive-label'>
											<div class='col-sm-12 col-md-2'>
												<label for='extension'>Extension</label>
											</div>
											<div class='col-sm-12 col-md'>
												<input type='text' value='' name='extension' style='width:65%;'>
											</div>
										</div>
										<div class='hide-form'>
											<input type='number' name='user' class='hidden' value='$id' id='hideform'>
										</div>
										<div class='row'>
											<input type='submit' class='primary' value='Submit'>
										</div>
									</fieldset>
								</form>";
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