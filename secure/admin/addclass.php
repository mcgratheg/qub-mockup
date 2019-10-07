<?php
session_start();

if (!isset($_SESSION["cater_40105701"])) {
    header("Location: ../../login.php");
}

include("../connect/database.php");
include("../objects/user.php");
include("../objects/usertype.php");
include("../objects/login.php");
include("../objects/subject.php");

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
        <link rel="icon" href="../../img/bird-bluetit.png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://gitcdn.link/repo/Chalarangelo/mini.css/master/dist/mini-default.min.css">
        <link rel="stylesheet" href="../../css/style.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>

            jQuery(document).ready(function () {

                jQuery('#myInput').on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $('#myTable tr').filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
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
			<img src='../../img/bird-bluetit.png' width='50px'></a>
			<a href='index.php' class='button'>McG VLE</a>
			<a href='../displayprofile.php?userid=" . $user->get_id() . "' class='button' id='userbutton'>" . $user->get_first_name() . " " . $user->get_last_name() . "</a>
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
<?php echo"<li><a href='../displayprofile.php?userid=" . $user->get_id() . "' class='button'>" . $user->get_first_name() . " " . $user->get_last_name() . "</a></li>
					<li><a href='index.php' class='button'>Home</a></li>"; ?>
                        <li><a href="../subjectsearch.php" class="button">Subjects</a></li>
                        <li><a href="../staffsearch.php" class="button">Staff</a></li>
                        <li><a href="../signout.php" class="button" id="signout">Sign Out</a></li>
                    </ul>
                </nav>
                <div class="col-sm-12 col-md-8 col-lg-10" id="main">
<?php
$id = $_GET["id"];

echo "<h3>Add Class</h3><br>";

$user_profile = new User($mysqli);
$user_type = new UserType($mysqli);
$user_login = new Login($mysqli);
$user_result = $user_profile->read_all($user_type, $user_login, $id);

echo "<p>User: $user_profile->first_name $user_profile->last_name</p>";

$subject = new Subject($mysqli);
$subject_result = $subject->read_subject_search();

echo "<form method='POST' id='myForm' action='insertclass.php'>";

if ($subject_result->num_rows > 0) {
    echo "<div class='row responsive-label'>
							<div class='col-sm-12 col-md-1'>
								<label for='classsubject'>Subject</label>
							</div>
							<div class='col-sm-12 col-md'>
								<select name='subject'>";
    while ($row = $subject_result->fetch_array(MYSQLI_ASSOC)) {
        $subject->set_id($row["SubjectID"]);
        $subject->set_code($row["SubjectCode"]);
        $subject->set_name($row["SubjectName"]);

        echo "<option value='" . $subject->get_id() . "' name='subject'>" . $subject->get_code() . ": " . $subject->get_name() . "</option>";
    }
    echo "</select>
						</div>
					</div>
					<div class='hide-form'>
						<input type='number' name='user' class='hidden' value='$id' id='hideform'>
					</div>
					<br>
					<div class='row'>
						<input type='submit' class='primary' value='Submit'>
					</div>";
} else {
    echo "<p>No classes available</p>";
}
echo "</form>";
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
	$mysqli->close();
?>