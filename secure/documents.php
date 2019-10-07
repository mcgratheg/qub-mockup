<?php
	session_start();
	
	if(!isset($_SESSION["cater_40105701"]))
	{
		header("Location: ../login.php");
		
	}
        
include("connect/database.php");
include("objects/user.php");
include("objects/login.php");
include("objects/subject.php");
include("objects/classdetails.php");
include("objects/document.php");

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

			jQuery(document).ready(function(){
				
					jQuery('input[type="file"]').change(function(e){
						
						var fileName = e.target.files[0].name;
						var fileSize = e.target.files[0].size;
						//alert('The file "' + fileName +  '" has been selected.');
						jQuery('#filepath').data("filename", fileName);
						
						if (fileSize>2097152) {
							alert('File cannot be more than 2MB!');
							jQuery('#fileinput').val("");
							jQuery('#filepath').removeData("filename");
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
                        <a href='signout.php' class='button'>Sign Out</a>";?>
		</header>
		<div class="container">
		<div class="row">
		<input type="checkbox" id="drawer-control" class="drawer">
			<nav class="drawer col-md-4 col-lg-2">
				<label for="drawer-control" class="drawer-close"></label>
				<ul>
					<li><h4>Navigation</h4></li>
					<?php echo"<li><a href='displayprofile.php?userid=" . $user->get_id() . "' class='button'>" . $user->get_first_name() . " " . $user->get_last_name() . "</a></li>
					<li><a href='index.php' class='button'>Home</a></li>";?>
					<li><a href="subjectsearch.php" class="button">Subjects</a></li>
					<li><a href="staffsearch.php" class="button">Staff</a></li>
                                        <?php if($user->get_type() == 1){ echo"<li><a href='admin/index.php' class='button'>Admin Portal</a></li>";}?>
					<li><a href="signout.php" class="button" id="signout">Sign Out</a></li>
					
				</ul>
			</nav>
			<div class="col-sm-12 col-md-8 col-lg-10" id="main">
			<?php 
				$code = $_GET["subject"];
				
                                $class_details = new ClassDetails($mysqli);
                                $class_result = $class_details->read_class_details($user->id);
				if($class_result->num_rows == 1 || $user->type!=3){
                                        $subject = new Subject($mysqli);
                                        $subject_result = $subject->read($code);
						if($subject_result->num_rows > 0) {
						while ($row = $subject_result->fetch_array(MYSQLI_ASSOC)) {
							$subject->set_id($row["SubjectID"]);
							$subject->set_subject_level_id($row["SubjectLevel_ID"]);
							$subject->set_name($row["SubjectName"]);
							echo "<div id='titlehead'>
									<h2>$code : " . $subject->get_name() . "</h2>
									<div class='row'>
										<p><a href='displaysubject.php?subject=$code'>Information</a></p>
										<span>|</span>
										<h5>Resources</h5>
										<span>|</span>
										<p><a href='forum.php?subject=$code'>Forum</a></p>
									</div>	
								</div><br>";	
					

				$document = new Document($mysqli);
                                $document_user = new User($mysqli);
				$document_result = $document->read_document($code);
				if($document_result->num_rows > 0) {
					//echo "<p>Stuff found in table</p>";
					echo "<table>
							<thead>
								<tr>
									<th>Name</th>
									<th>Tutor</th>
									<th>Added</th>
									<th>Link</th>
								</tr>	
							</thead>
							<tbody id='myTable'>";
					while($row = $document_result->fetch_array(MYSQLI_ASSOC)){
						$document->set_doc_path($row["Docpath"]);
						$fileext = pathinfo($document->get_doc_path(), PATHINFO_EXTENSION);
						$filename = basename($document->get_doc_path());
						$document->set_user_id($row["User_ID"]);
						$document_user->set_first_name($row["FirstName"]);
						$document_user->set_last_name($row["LastName"]);
						$document->set_date_added(date('d/m/y', strtotime($row["DateAdded"])));
						
						echo "<tr>
								<td data-label='Name'><a href='uploads/" . $document->get_doc_path() . "'>$filename</a></td>
								<td data-label='Tutor'><a href='displaystaff.php?id=" . $document->get_user_id() . "'>" . $document_user->get_first_name() . " " . $document_user->get_last_name() . "</a></td>
								<td data-label='Added'>" . $document->get_date_added() . "</td>
								<td data-label='Link'><a href='uploads/" . $document->get_doc_path() . "' download><img src='../img/Download-01.png' width='40px;'></a></td>
							</tr>";
					}
					echo "</tbody>
					</table>";
				}else{
					echo "<p>No documents available</p>";
				}
				
				if($user->get_type() !=3) {	
						echo "<form method='post' id='uploadForm' action='uploadfile.php?userid=" . $user->get_id() . "' enctype='multipart/form-data'>
								<div class='row responsive-label'>
									<label for='fileinput' id='upload-file' class='button'>Upload File</label>
									<input type='file' id='fileinput' name='uploadfile' class='hidden'>
									<div id='filepath' style='margin-left:10px;'>File Name: <div id='file'></div></div>
								</div>
								<div class='hide-form'>
									<input type='number' name='user' class='hidden' value='" . $user->get_id() . "' id='hideform'>
									<input type='number' name='subject' class='hidden' value='" . $subject->get_id() . "' id='hideform'>
									<input type='number' name='subjectlevel' class='hidden' value='" . $subject->get_subject_level_id() . "' id='hideform'>
									<input type='text' name='subjectcode' class='hidden' value='$code' id='hideform'>
								</div>
									<div class='row'>
										<input type='submit' class='primary' value='Submit' style='margin-left:10px;'>
									</div>
								</form>";
							}
						}
					}
				}else{
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