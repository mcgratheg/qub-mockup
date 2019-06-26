<?php
session_start();

if (!isset($_SESSION["cater_40105701"])) {
    header("Location: ../../login.php");
}

include("../connect/database.php");
include("../objects/user.php");
include("../objects/usertype.php");
include("../objects/login.php");

$email = $_SESSION["cater_40105701"];

$db = Database::getInstance();
$mysqli = $db->getConnection();

$user = new User($mysqli);
$login = new Login($mysqli);

$stmt = $user->readUser($email);

//variables for 7062prouser insert
$user_type = $_POST["usertype"];
$first_name = trim($_POST["firstname"]);
$last_name = trim($_POST["lastname"]);
$dob = $_POST["dateofbirth"];
$date_of_birth = date('Y-m-d', strtotime($dob));
$address = trim($_POST["address"]);
$city = trim($_POST["city"]);
$postcode = trim($_POST["postcode"]);

$user_insert = new User($mysqli);
$user_result = $user_insert->create($user_type, $first_name, $last_name, $date_of_birth, $address, $city, $postcode);

if ($user_result) {
    $msg = "New user was added successfully";
} else {
    $msg = "Request was unsuccessful";
}

$user_id = $mysqli->insert_id;

//variables for 7062prologindetails insert
$user_email = trim($_POST["emailnew"]);
$password = trim($_POST["password"]);

$user_login = new Login($mysqli);
$login_result = $user_login->create($user_id, $user_email, $password);


if ($login_result) {
    $logmsg = "Login details were successfully added";
} else {
    $logmsg = "Request was unsuccesful";
}
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
<?php echo"<li><a href='displayprofile.php?userid=$user->id' class='button'>$user->first_name $user->last_name</a></li>
					<li><a href='index.php' class='button'>Home</a></li>"; ?>
                        <li><a href="../subjectsearch.php" class="button">Subjects</a></li>
                        <li><a href="../staffsearch.php" class="button">Staff</a></li>
                        <li><a href="../signout.php" class="button" id="signout">Sign Out</a></li>
                    </ul>
                </nav>
                <div class="col-sm-12 col-md-8 col-lg-10" id="main">
<?php
if ($user_result) {
    echo "<p>$msg</p>";

    echo "<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>
								<p>Name:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>
								<p>$first_name $last_name</p>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>
								<p>User Type:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>
								<p>$user_type</p>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>
								<p>Date Of Birth:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>	
								<p>$dob</p>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>		
								<p>Address:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>		
								<p>$address<br>$city<br>$postcode</p>
							</div>
						</div>";
} else {
    echo "<p>$msg</p>";
}

if ($login_result) {
    echo "<p>$logmsg</p>";

    echo "<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>
								<p>Email:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>
								<p>$user_email</p>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-4 col-md-2' id='labels'>
								<p>Password:</p>
							</div>
							<div class='col-sm-8 col-md-10' id='info'>	
								<p>********</p>
							</div>
						</div>";
} else {
    echo "<p>$logmsg</p>";
}

echo "<div class='row' id='nav'>
							<button class='primary'><a href='usersearch.php'>Return to Users</a></button>
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