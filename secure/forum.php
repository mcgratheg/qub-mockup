<?php
session_start();

if (!isset($_SESSION["cater_40105701"])) {
    header("Location: ../login.php");
}

include("connect/database.php");
include("objects/user.php");
include("objects/login.php");
include("objects/subject.php");
include("objects/topic.php");
include("objects/reply.php");
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
<?php echo"<li><a href='displayprofile.php?userid=" . $user->get_id() . "' class='button'>" . $user->get_first_name() . " " .  $user->get_last_name() . "</a></li>
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
                    <?php
                    $code = $_GET['subject'];
                    //echo "<h2>$subjectid</h2>";
                    $class_details = new ClassDetails($mysqli);
                    $class_result = $class_details->read_class_details($user->id);
                    if ($class_result->num_rows == 1 || $user->type != 3) {
                        $subject = new Subject($mysqli);
                        $subject_result = $subject->read($code);
                        if ($subject_result->num_rows > 0) {
                            while ($row = $subject_result->fetch_array(MYSQLI_ASSOC)) {
                                $subject->set_name($row["SubjectName"]);
                                $subject->set_code($row["SubjectCode"]);
                                echo "<div id='titlehead'>
									<h2>" . $subject->get_code() . " : " . $subject->get_name() . "</h2>
									<div class='row'>
										<p><a href='displaysubject.php?subject=" . $subject->get_code() . "'>Information</a></p>
										<span>|</span>
										<p><a href='documents.php?subject=" . $subject->get_code() . "'>Resources</a></p>
										<span>|</span>
										<h5>Forum</h5>
									</div>	
								</div><br>";


                                $topic = new Topic($mysqli);
                                $topic_user = new User($mysqli);
                                $reply = new Reply($mysqli);
                                $reply_user = new User($mysqli);
                                $topic_result = $topic->read_topic_subject($code);
                                if ($topic_result->num_rows > 0) {
                                    while ($row = $topic_result->fetch_array(MYSQLI_ASSOC)) {
                                        $topic->set_id($row["TopicID"]);
                                        $topic->set_title($row["TopicTitle"]);
                                        $topic->set_content($row["TopicContent"]);
                                        $topicsubcont = substr($topic->content, 0, 50);
                                        $topic->set_date(date('d/m/y', strtotime($row["TopicDate"])));
                                        $topic_user->set_first_name($row["FirstName"]);
                                        $topic_user->set_last_name($row["LastName"]);



                                        echo "<div class='col-sm-12'>
										<div class='card fluid'>
											<div class='section'>
												<a href='displaytopic.php?topicid=" . $topic->get_id() . "'><h3>" . $topic->get_title() . "</h3></a>
												<p>$topicsubcont...</p>
												<div class='row'>
													<p>By " . $topic_user->get_first_name() . " " . $topic_user->get_last_name() . "</p>
													<p>|</p>
													<p>Created " . $topic->get_date() . "</p>";
                                        $reply_result = $reply->read_reply_user($topic->id);
                                        if ($reply_result->num_rows == 1) {
                                            while ($r = $reply_result->fetch_array(MYSQLI_ASSOC)) {
                                                $reply_user->set_first_name($r["FirstName"]);
                                                $reply_user->set_last_name($r["LastName"]);
                                                echo "<p>|</p>
															<p>Last reply by " . $reply_user->get_first_name() . " " . $reply_user->get_last_name() . "</p>";
                                            }
                                        }
                                        echo "</div>
											</div>
										</div>
									</div>";
                                    }
                                } else {
                                    echo "<div class='row'>
									<p>No topics available</p>
								</div>";
                                }
                            }
                        }


                        echo "<br><div class='row' id='nav'>
								<a href='addtopic.php?subject=$code'><button class='primary'>Add Topic</button></a>
							</div>";
                    } else {
                        echo "<p>Oops! You are not permitted to view this page.</p>";
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