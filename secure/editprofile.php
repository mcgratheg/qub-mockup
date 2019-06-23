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

$stmt = $user->readUser($email);
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
        <link rel="stylesheet" href="../css/style.css">
        <script src="../js/myForm.js"></script>
        <script>

            jQuery(document).ready(function () {

                jQuery('#datepicker').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "1950:c",
                    navigationAsDateFormat: true

                });

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
			<a href='displayprofile.php?userid=$user->id' class='button' id='userbutton'>$user->first_name $user->last_name</a>
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
<?php echo"<li><a href='displayprofile.php?userid=$user->id' class='button'>$user->first_name $user->last_name</a></li>
					<li><a href='index.php' class='button'>Home</a></li>"; ?>
                        <li><a href="subjectsearch.php" class="button">Subjects</a></li>
                        <li><a href="staffsearch.php" class="button">Staff</a></li>
                        <?php if ($user->type == 1) {
                            echo"<li><a href='admin/index.php' class='button'>Admin Portal</a></li>";
                        } ?>
                        <li><a href="signout.php" class="button" id="signout">Sign Out</a></li>
                    </ul>
                </nav>
                <div class="col-sm-12 com-md-8 col-lg-10" id="main">
                    <?php
                    $id = $_GET['userid'];
                    //echo "$userid";

                    $user_profile = new User($mysqli);
                    $user_login = new Login($mysqli);
                    $user_result = $user_profile->readAll($user_login, $id);

                    echo "<div id='titlehead'>
									<h4>Edit Details</h4>
								</div>	
									<form method='post' id='myForm' action='updateuser.php?userid=$user_profile->id'>
										<fieldset>
											<legend>Basic Info</legend>
											<div class='row responsive-label'>
												<div class='col-sm-12 col-md-2'>
													<label for='firstname'>First Name</label>
												</div>
												<div class='col-sm-12 col-md'>
													<input type='text' value='$user_profile->first_name' name='firstname' maxlength='20' required='required' style='width:75%;'>
												</div>	
											</div>
											<div class='row responsive-label'>
												<div class='col-sm-12 col-md-2'>
													<label for='lastname'>Last Name</label>
												</div>
												<div class='col-sm-12 col-md'>
													<input type='text' value='$user_profile->last_name' name='lastname' maxlength='40' required='required' style='width:75%;'>
												</div>
											</div>
											<div class='row responsive-label'>
												<div class='col-sm-12 col-md-2'>
													<label for='dateofbirth'>Date Of Birth</label>
												</div>
												<div class='col-sm-12 col-md'>
													<input type='text' value='$user_profile->date_of_birth' name='dateofbirth' id='datepicker' required='required' style='width:50%;'>
												</div>
											</div>
											<div class='row responsive-label'>
												<div class='col-sm-12 col-md-2'>
													<label for='address'>Address Line</label>
												</div>
												<div class='col-sm-12 col-md'>
													<input type='text' value='$user_profile->address' name='address' required='required' style='width:75%;'>
												</div>
											</div>
											<div class='row responsive-label'>
												<div class='col-sm-12 col-md-2'>
													<label for='city'>City</label>
												</div>
												<div class='col-sm-12 col-md'>
													<input type='text' value='$user_profile->city' name='city' required='required' style='width:75%;'>
												</div>
											</div>
											<div class='row responsive-label'>
												<div class='col-sm-12 col-md-2'>
													<label for='postcode'>PostCode</label>
												</div>
												<div class='col-sm-12 col-md'>
													<input type='text' value='$user_profile->postcode' name='postcode' required='required' style='width:75%;'>
												</div>
											</div>
											<div class='hide-form'>
												<input type='number' name='user' class='hidden' value='$user_profile->id' id='hideform'>
												<input type='number' name='usertype' class='hidden' value='$user_profile->type' id='hideform'>
											</div>
										</fieldset>";



                    echo "<fieldset>
												<legend>Contact Details</legend>
												<div class='row responsive label'>
													<div class='col-sm-12 col-md-2'>
														<label for='roomnumber'>Home No.</label>
													</div>
													<div class='col-sm-12 col-md'>
														<input type='text' value='$user_profile->home_number' name='homenumber' style='width:75%;'>
													</div>
												</div>
												<div class='row responsive label'>
													<div class='col-sm-12 col-md-2'>
														<label for='roomnumber'>Mobile No.</label>
													</div>
													<div class='col-sm-12 col-md'>
														<input type='text' value='$user_profile->mobile_number' name='mobilenumber' style='width:75%;'>
													</div>
												</div>
											</fieldset>";

                    echo "<div class='row'>
									<input type='submit' class='primary' value='Submit' style='margin-left:10px;'>
								</div>
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