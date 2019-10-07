<?php
session_start();

if (!isset($_SESSION["cater_40105701"])) {
    header("Location: ../login.php");
}

include("connect/database.php");
include("objects/user.php");
include("objects/login.php");

$email = $_SESSION["cater_40105701"];

$db = Database::getInstance();
$mysqli = $db->getConnection();

$user = new User($mysqli);
$login = new Login($mysqli);

$stmt = $user->read_user($email);

//variables for 7062prouser update
$user_id = $_POST["user"];
$user_type = $_POST["usertype"];
$update_first = $mysqli->real_escape_string($_POST["firstname"]);
$update_last = $mysqli->real_escape_string($_POST["lastname"]);
$dob = $mysqli->real_escape_string($_POST["dateofbirth"]);
$update_dob = date('Y-m-d', strtotime($dob));
$update_address = $mysqli->real_escape_string($_POST["address"]);
$update_city = $mysqli->real_escape_string($_POST["city"]);
$update_postcode = $mysqli->real_escape_string($_POST["postcode"]);
$update_home = $mysqli->real_escape_string($_POST["homenumber"]);
$update_mobile = $mysqli->real_escape_string($_POST["mobilenumber"]);

$update_user = new User($mysqli);

$result = $update_user->update($update_first, $update_last, $update_dob, $update_address, $update_city, $update_postcode, $update_home, $update_mobile, $user_id);

header("Location: displayprofile.php?userid=$user_id");
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

            jQuery(document).ready(function () {


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
			<a href='displayprofile.php?userid=" . $user->get_id() . "' class='button' id='userbutton'>" . $user->get_first_name() . " " . $user->get_last_name() . "</a>
                        <span>|</span>
                        <a href='signout.php' class='button'>Sign Out</a>"; ?>
        </header>
        <div class="container">
            <div class="row">
                <input type="checkbox" id="drawer-control" class="drawer">
                <nav class="drawer col-md-4 col-lg-2">
                    <label for="drawer-control" class="drawer-close"></label>
                    <ul>
                        <li><h4>Navigation</h4></li>
<?php echo"<li><a href='displayprofile.php?userid=" . $user->get_id() . "' class='button'>" . $user->get_first_name() . " " . $user->get_last_name() . "</a></li>
					<li><a href='index.php' class='button'>Home</a></li>"; ?>
                        <li><a href="subjectsearch.php" class="button">Subjects</a></li>
                        <li><a href="staffsearch.php" class="button">Staff</a></li>
                        <?php if ($user->get_type() == 1) {
                            echo"<li><a href='admin/index.php' class='button'>Admin Portal</a></li>";
                        } ?>
                        <li><a href="signout.php" class="button" id="signout">Sign Out</a></li>
                    </ul>
                </nav>
                <div class="col-sm-12 col-md-8 col-lg-10" id="main">
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
	$mysqli->close();
?>