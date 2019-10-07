<?php
session_start();

if (!isset($_SESSION["cater_40105701"])) {
    header("Location: ../login.php");
}

include("connect/database.php");
include("objects/user.php");
include("objects/login.php");
include("objects/tutor.php");
include("objects/subject.php");
include("objects/classdetails.php");


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

            jQuery(document).ready(function () {

                jQuery('input[type="file"]').change(function (e) {

                    var fileName = e.target.files[0].name;
                    var fileSize = e.target.files[0].size;
                    //alert('The file "' + fileName +  '" has been selected.');
                    jQuery('#filepath').data("image", fileName);

                    if (fileSize > 2097152) {
                        alert('File cannot be more than 2MB!');
                        jQuery('#imginput').val("");
                        jQuery('#filepath').removeData("image");
                    }


                    jQuery("#file").text(fileName);

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
                        <?php
                        if ($user->get_type() == 1) {
                            echo"<li><a href='admin/index.php' class='button'>Admin Portal</a></li>";
                        }
                        ?>
                        <li><a href="signout.php" class="button" id="signout">Sign Out</a></li>
                    </ul>
                </nav>
                <div class="col-sm-12 com-md-8 col-lg-10" id="main">
<?php
$id = $_GET['id'];
//echo "$userid";

$staff_user = new User($mysqli);
$staff_login = new Login($mysqli);
$staff_tutor = new Tutor($mysqli);

$staff_result = $staff_tutor->search_tutor($id);
if ($staff_result->num_rows > 0) {
    while ($row = $staff_result->fetch_array(MYSQLI_ASSOC)) {
        $staff_user->set_first_name($row["FirstName"]);
        $staff_user->set_last_name($row["LastName"]);
        $staff_user->set_profile_image($row["ProfileImage"]);
        $staff_login->set_email($row["Email"]);
        $staff_tutor->set_room_number($row["RoomNumber"]);
        $staff_tutor->set_room_address($row["RoomAddress"]);
        $staff_tutor->set_phone_ext($row["PhoneExtension"]);

        echo "<div class='col-sm-12 col-md'>
									<div class='card fluid'>
										<div class='section'>
											<div class='row'>
												<div class='col-sm-12 col-md-2' id='profileimage'>
													<img src='../img/" . $staff_user->get_profile_image() . "'>
												</div>
												<div class='col-sm-12 col-md'>
													<h4 class='search'>" . $staff_user->get_first_name() . " " . $staff_user->get_last_name() . "</h4>";

        $class_details = new ClassDetails($mysqli);
        $subject = new Subject($mysqli);
        $subjectresult = $class_details->read_tutor_details($id);
        if ($subjectresult->num_rows > 0) {
            echo "<div class='row'>
										<div class='col-sm-3 col-md-1' id='labels'>
											<p>Subjects:</p>
										</div>
										<div class='col-sm-9 col-md-11' id='info'>";
            while ($row = $subjectresult->fecth_array(MYSQLI_ASSOC)) {
                $subject->set_code($row["SubjectCode"]);
                $subject->set_name($row["SubjectName"]);
                echo "<p>" . $subject->get_code() . " : " .  $subject->get_name() . "</p>";
            }
            echo "</div>
										</div>
										<br>";
        }
        echo "<div class='row'>
														<div class='col-sm-3 col-md-1' id='labels'>
															<p>Email:</p>
															<p>Room:</p>
														</div>
														<div class='col-sm-9 col-md-11' id='info'>
															<p><a href='mailto:" . $staff_login->get_email() . "' data-rel='external'>" . $staff_login->get_email() . "</a></p>
															<a href='https://maps.google.com/?q=" . $staff_tutor->get_room_address() . "'><p>" . $staff_tutor->get_room_number() . "," .  $staff_tutor->get_room_address() . "</p></a>
														</div>
													</div>
													<div class='row'>
														<div class='col-sm-3 col-md-1' id='labels'>
															<p>Phone:</p>
														</div>
														<div class='col-sm-9 col-md-11' id='info'>
															<p>" . $staff_tutor->get_phone_ext() . "</p>
														</div>
													</div>
												</div>	
											</div>
										</div>
									</div>
								</div>";
    }
} else {
    echo "<p>No information available</p>";
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
	$mysqli->close();
?>