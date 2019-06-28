<?php
session_start();

if (!isset($_SESSION["cater_40105701"])) {
    header("Location: ../../login.php");
}

include("../connect/database.php");
include("../objects/user.php");
include("../objects/usertype.php");
include("../objects/login.php");
include("../objects/tutor.php");
include("../objects/subject.php");
include("../objects/classdetails.php");

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
                <div class="col-sm-12 com-md-8 col-lg-10" id="main">
<?php
$id = $_GET['id'];
//echo "$userid";

$user_profile = new User($mysqli);
$user_login = new Login($mysqli);
$user_type = new UserType($mysqli);
$result = $user_profile->read_all($user_type, $user_login, $id);
$displaydate = date('d/m/Y', strtotime($user_profile->date_of_birth));


echo "<div id='titlehead'>
									<h4>Personal Details</h4>
								</div>	
									<div class='col-sm-12'>
										<fieldset>
											<legend>Basic Info</legend>
											<div id='profileimage'>
												<img src='../../img/$user_profile->profile_image' width='150px'>
											</div>";
if ($user_profile->type != 3) {
    echo "<form method='post' id='uploadForm' action='updateimage.php?userid=$id' enctype='multipart/form-data'>
												<div class='row responsive-label'>
													<label for='imginput' id='upload-file' class='button'>Upload Image</label>
													<input type='file' id='imginput' class='hidden' name='profileimg'>
													<div id='filepath' style='margin-left:10px;'>File Name: <div id='file'></div></div>
												</div>
												<div class='hide-form'>
													<input type='number' name='user' class='hidden' value='$id' id='hideform'>
												</div>
												<div class='row'>
													<input type='submit' class='primary' value='Submit' style='margin-left:10px;'>
												</div>
											</form>";
}

echo "<div class='row'>
											<div class='col-sm-4 col-md-2' id='labels'>
												<p>Type:</p>
											</div>
											<div class='col-sm-8 col-md-10' id='info'>
												<p>$user_type->name</p>
											</div>
										</div>
										<div class='row'>
											<div class='col-sm-4 col-md-2' id='labels'>
												<p>Name:</p>
											</div>
											<div class='col-sm-8 col-md-10' id='info'>
												<p>$user_profile->first_name $user_profile->last_name</p>
											</div>
										</div>
										<div class='row'>
											<div class='col-sm-4 col-md-2' id='labels'>
												<p>Date Of Birth:</p>
											</div>
											<div class='col-sm-8 col-md-10' id='info'>	
												<p>$displaydate</p>
											</div>
										</div>
										<div class='row'>
											<div class='col-sm-4 col-md-2' id='labels'>		
												<p>Address:</p>
											</div>
											<div class='col-sm-8 col-md-10' id='info'>		
												<p>$user_profile->address<br>$user_profile->city<br>$user_profile->postcode</p>
											</div>
										</div>	
										</fieldset>
										<br>
										<fieldset>
											<legend>Login Details</legend>
											<div class='row'>
												<div class='col-sm-4 col-md-2' id='labels'>
													<p>Email:</p>
												</div>
												<div class='col-sm-8 col-md-10' id='info'>
													<p>$user_login->email</p>
												</div>
											</div>
											<div class='row'>
												<div class='col-sm-4 col-md-2' id='labels'>
													<p>Password:</p>
												</div>
												<div class='col-sm-8 col-md-10' id='info'>
													<p>********</p>
												</div>
											</div>	
										</fieldset>
										<br>";



echo "<fieldset>
												<legend>Contact Details</legend>
												<div class='row'>
													<div class='col-sm-4 col-md-2' id='labels'>
														<p>Home No:</p>
													</div>
													<div class='col-sm-8 col-md-10' id='info'>";

if ($user_profile->home_number != NULL) {
    echo "<p>$user_profile->home_number</p>";
} else {
    echo "<p>N/A</p>";
}
echo "</div>
											</div>
											<div class='row'>
												<div class='col-sm-4 col-md-2' id='labels'>
													<p>Mobile No:</p>
												</div>
												<div class='col-sm-8 col-md-10' id='info'>";

if ($user_profile->mobile_number != NULL) {
    echo "<p>$user_profile->mobile_number</p>";
} else {
    echo "<p>N/A</p>";
}
echo "</div>
										</div>";

if ($user_profile->type == 2) {
    $tutor_details = new Tutor($mysqli);
    $tutor_result = $tutor_details->read_tutor($id);
    if ($tutor_result->num_rows == 1) {
        while ($row = $tutor_result->fetch_array(MYSQLI_ASSOC)) {
            $tutor_details->room_number = $row["RoomNumber"];
            $tutor_details->room_address = $row["RoomAddress"];
            $tutor_details->phone_ext = $row["PhoneExtension"];

            echo "<div class='row'>
														<div class='col-sm-4 col-md-2' id='labels'>
															<p>Room:</p>
														</div>
														<div class='col-sm-8 col-md-10' id='info'>
															<p>$tutor_details->room_number</p>
														</div>
													</div>
													<div class='row'>
														<div class='col-sm-4 col-md-2' id='labels'>
															<p>Address:</p>
														</div>
														<div class='col-sm-8 col-md-10' id='info'>
															<p>$tutor_details->room_address</p>
														</div>
													</div>
													<div class='row'>
														<div class='col-sm-4 col-md-2' id='labels'>
															<p>Phone Extension:</p>
														</div>
														<div class='col-sm-8 col-md-10' id='info'>
															<p>$tutor_details->phone_ext</p>
														</div>	
													</div>";
        }
        echo "<div class='row' id='nav'>
											<button class='primary'><a href='editoffice.php?id=$id'>Edit Details</a></button>
										</div>";
    } else {
        echo "<div class='row'>
														<div class='col-sm-4 col-md-2' id='labels'>
															<p>Room:</p>
														</div>
														<div class='col-sm-8 col-md-10' id='info'>
															<p>N/A</p>
														</div>
													</div>
													<div class='row'>
														<div class='col-sm-4 col-md-2' id='labels'>
															<p>Address:</p>
														</div>
														<div class='col-sm-8 col-md-10' id='info'>
															<p>N/A</p>
														</div>
													</div>
													<div class='row'>
														<div class='col-sm-4 col-md-2' id='labels'>
															<p>Phone Extension:</p>
														</div>
														<div class='col-sm-8 col-md-10' id='info'>
															<p>N/A</p>
														</div>	
													</div>";



        echo "<div class='row' id='nav'>
											<button class='primary'><a href='addoffice.php?id=$id'>Add Details</a></button>
										</div>";
    }
}

echo "</fieldset>
									<br>";

$subject = new Subject($mysqli);
$class_details = new ClassDetails($mysqli);
$class_result = $class_details->read_all_classes($subject, $id);

echo "<fieldset>
									<legend>Subjects</legend>";
if ($class_result->num_rows > 0) {
    while ($row = $class_result->fetch_array(MYSQLI_ASSOC)) {
        $subject->code = $row["SubjectCode"];
        $subject->name = $row["SubjectName"];

        echo "<div class='row'>
										<p>$subject->code : $subject->name</p>
									</div>";
    }
} else {
    echo "<div class='row'>
										<p>This user is not a part of any classes</p>
									</div>";
}
echo "<div class='row' id='nav'>
									<button class='primary'><a href='addclass.php?id=$id'>Add Class</a></button>
								</div>
								</fieldset><br>";

echo "<div class='row' id='nav'>
								<a href='../editprofile.php?userid=$id'><button class='primary'>Edit Profile</button></a>
							</div>
							<br>
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