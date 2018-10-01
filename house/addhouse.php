<?php
     require_once '../../system/database/db_required/dblogin.php';
     require_once '../../system/database/db_required/functions.php';
	 
	 session_start();
	 if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['user_id']) && isset($_SESSION['phone']) 
		 && isset($_SESSION['usertype']) && isset($_SESSION['email']) && isset($_SESSION['first_name']) && isset($_SESSION['last_name'])
	     && isset($_SESSION['gender']) && isset($_SESSION['address']) && isset($_SESSION['photo']))
	 {
	     $sysusername = $_SESSION['username'];
	     $syspassword = $_SESSION['password'];
		 
	     $sysuser_id = $_SESSION['user_id'];
	     $sysphone = $_SESSION['phone'];
	     $sysusertype = $_SESSION['usertype'];
	     $sysemail = $_SESSION['email'];
		 
		 $sysfirst_name = $_SESSION['first_name'];
		 $syslast_name =  $_SESSION['last_name'];
		 $sysgender = $_SESSION['gender'];
		 $sysaddress = $_SESSION['address'];
		 $sysphoto = $_SESSION['photo'];
		 
		 if($_SESSION['usertype'] == '1'){
		     /*Do nothing*/
		 } else {
			 destroySession(); /*Deleting the session*/
			 header('Location: ../../login/');
		 }
	 }
	 else
	 {
		 destroySession(); /*Deleting the session*/
		 header('Location: ../../login');
	 }
?>

<!doctype html>
<html lang="en">
<head>
     <title>Eduke - Add House</title>
	 <link rel="stylesheet" type="text/css" href="../css/index.css">
	  <script rel="text/javascript" src="../../system/scripts/jquery-1.11.1.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery-ui-1.10.4.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jQueryRotate.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/library.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery.spritely.js"></script>
</head>
<body>
     <div id="frame">
	     <div id="status">
		     <?php 
			     echo "<h2 class=\"left-display\">
					 <p class=\"menu\"><img src=\"../../system/images/sys-nav/menu.png\" width=\"25\"></p>";
					 
					 $db_server = mysql_connect($db_hostname, $db_username, $db_password);
					 if(!$db_server) die("Unable to connect to MySQL: ". mysql_error());
						 
					 mysql_select_db($db_database) 
						 or die("Unable to select database; ".mysql_error());
						 
					 $query1 = "SELECT MAX(academic_term_id) FROM schoolterm";
					 $result = mysql_query($query1);
					 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
					 $row = mysql_fetch_row($result);
					 $academic_term_id = $row[0];
					 
					 $query1 = "SELECT academic_year, academic_term FROM schoolterm WHERE academic_term_id = '$academic_term_id'";
					 $result = mysql_query($query1);
					 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
					 $row = mysql_fetch_row($result);
					 $academic_year = $row[0];
					 $academic_term = $row[1];
					 
					  echo " <span style=\"margin-left:20px;color:#bc3226;\">YEAR</span> : <b style=\"color:black;\">$academic_year</b> 
							 <span style=\"color:#bc3226;\">TERM</span> : <b style=\"color:black;\">$academic_term</b>
				 </h2>";
				  
				  echo "<div class=\"right-display\">";
				         if ($sysphoto == 'default'){
						     echo "<p><span style=\"color:#bc3226;\"><img src=\"../users/users photos/default.jpg\" height=\"25px\"></span> 
						     <b style=\"color:black;\">$sysusername</b></p>";
						 } else {
							 echo "<p><span style=\"color:#bc3226;\"><img src=\"../users/$sysphoto\" height=\"25px\"></span> 
						     <b style=\"color:black;\">$sysusername</b></p>";
						 }
							 
					     echo "<div class=\"user\">
			                 <p><a href=\"../users/viewuser.php?user_id=$sysuser_id\"><img src=\"../../system/images/sys-nav/user.png\" 
									 width=\"20px\" height=\"20px\" style=\"vertical-align:middle;margin-right:10px;\"> Profile</a></p>
									 
				             <p><a href=\"../../logout/logout.php\"><img src=\"../../system/images/sys-nav/logout.png\" 
								 style=\"vertical-align:middle;margin-right:10px;\" height=\"20px\" width=\"20px\"> Log Out</a></p>
			             </div>
			     </div>";
			 ?>
		 </div>
		 
	     <div id="school-logo-info">
			 <?php				 
					 $query = "SELECT * FROM settings";
					 $result = mysql_query($query);
					 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
					 $rows = mysql_num_rows($result);
					 
					 for ($j = 0 ; $j < $rows ; ++$j)
					 {
						 $row = mysql_fetch_row($result);
                         echo "<div id=\"\">
						 <div class=\"logo\">";
						     if ($row[10] == "")
							 {
								 $photo = "";
								 echo "<img src=\"../../system/images/school-logo/default.jpg\" height=\"60\">";
							 } 
							 elseif ($row[10] == "default")
							 {
								 $photo = "";
								 echo "<img src=\"../../system/images/school-logo/default.jpg\" height=\"60\">";
							 } 
							 else {
								 $photo = $row[10];
								 echo "<img src=\"$row[10]\" height=\"60\">";
							 }
						 
						 echo "</div>
				         <div class=\"\">
				             <h1 style=\"font-weight:lighter;\">$row[1]</h1>
					     </div>
				     </div>";
					 }
					 
				 ?>
		 </div>
		 
	     <div id="navigation">
			 <p class="dashboard-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
			     <span class="extra-dashboard-nav">
				     <a href="../dashboard/notices.php">Manage Notices</a>
				 </span>
			     <a href="../dashboard/dashboard.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/dashboard.png" height="15px" width="15px"> Dashboard</a>
			 </p>
		     <p class="student-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
			     <span class="extra-student-nav">
				     <a href="../student/addstudent.php">Add Student</a>
				     <a href="../student/alumnistudents.php">Alumni Students</a>
				     <a href="../student/studentroles.php">Student Roles</a>
				 </span>
			     <a href="../student/student.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/student.png" height="15px" width="15px"> Student</a>
			 </p>
		     <p class="teacher-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
			     <span class="extra-teacher-nav">
				     <a href="../teacher/addteacher.php">Add Teacher</a>
				 </span>
			     <a href="../teacher/teacher.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/teacher.png" height="15px" width="15px"> Teacher</a>
			 </p>
		     <p class="class-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
			     <span class="extra-class-nav">
				     <a href="../class/addclass.php">Add Class</a>
				     <a href="../class/classcategory.php">Class Category</a>
				     <a href="../class/classlevel.php">Class Level</a>
				 </span>
			     <a href="../class/class.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/class.png" height="15px" width="15px"> Class</a>
			 </p>
		     <p class="subject-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
				 <span class="extra-subject-nav">
				     <a href="../subjects/addsubject.php">Add Subject</a>
				     <a href="../subjects/gradingtype1.php">Grading Type 1</a>
				     <a href="../subjects/gradingtype2.php">Grading Type 2</a>
				     <a href="../subjects/advancedgrading.php">Advanced Grading</a>
					 <a href="../subjects/graderemarks.php">Grade Remarks</a>
				 </span>
			     <a href="../subjects/subject.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/subject.png" height="15px" width="15px"> Subject</a>
			 </p>
		     <p class="exam-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
			     <span class="extra-exam-nav">
				     <a href="../exams/addexam.php">Add Exam</a>
				     <a href="../exams/examtype.php">Set Exam Type</a>
				     <a href="../exams/insertmarks.php">Insert Marks</a>
				 </span>
			    <a href="../exams/exam.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/exam.png" height="15px" width="15px"> Exam</a></p>
		     <p class="fees-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
				 <span class="extra-fees-nav">
				     <a href="../fees/makepayment.php">Make Payments</a>
				     <a href="../fees/approvepayments.php">Approve Payments</a>
				     <a href="../fees/feewaiver.php">Fee Waiver</a>
				 </span>
			     <a href="../fees/fees.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/fees.png" height="15px" width="15px"> Fees</a>
			 </p>
		     <p class="events-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
				 <span class="extra-events-nav">
				     <a href="../events/addevents.php">Add Event</a>
				 </span>
			     <a href="../events/events.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/events.png" height="15px" width="15px"> Events</a>
			 </p>
		     <p class="term-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
				 <span class="extra-term-nav">
				     <a href="../term/addterm.php">Add Term</a>
				 </span>
			     <a href="../term/semester.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/term.png" height="15px" width="15px"> Term</a>
			 </p>
		     <p class="house-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
				 <span class="extra-house-nav">
				     <a href="../house/addhouse.php" class="selected-nav">Add House</a>
				 </span>
			     <a href="../house/house.php" class="selected-nav"><img style="vertical-align:middle;" src="../../system/images/sys-nav/house.png" height="15px" width="15px"> House</a>
			 </p>
		     <p class="users-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
				 <span class="extra-users-nav">
				     <a href="../users/adduser.php">Add User</a>
				 </span>
			     <a href="../users/users.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/user-white.png" height="15px" width="15px"> Users</a>
			 </p>
		     <p class="parent-nav">
			     <img class="arrow" src="../../system/images/sys-nav/arrow.png" height="10px">
				 <span class="extra-parent-nav">
				     <a href="../parent/addparent.php">Add Parent</a>
				 </span>
			     <a href="../parent/parent.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/parent.png" height="15px" width="15px"> Parent</a>
			 </p>
		     <p><a href="../settings/settings.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/settings.png" height="15px" width="15px"> Settings</a></p>
		     <p><a href="../../system/guide/guide.php" target="_blank"><img style="vertical-align:middle;" src="../../system/images/sys-nav/usermanual.png" height="15px" width="15px"> User manual</a></p>
		 </div>
		 
	     <div id="content-reload">
			 <div id="boxlist-content">
				 <h1>ADD HOUSE</h1>
				 <p><b>Directory: Houses</b> / <b>Add House</b></p>
				 
				 <div id="main">
				     <div id="addclass">
						 <form action="houseadded.php" id="form-content" method="POST" enctype="multipart/form-data">
							 <h3>CREATE HOUSE</h3>
								 <p>HOUSE NAME: <br><input type="text" name="house_name" required></p>
								 <p>DESCRIPTION: <br><input type="text" name="description" required></p>

							 <p><input style="background-color:green;color:#fff;width:80px;padding:10px;border:solid 1px green!important;
									 border-radius:3px;cursor:pointer;" type="submit" value="Add House"></p>
						 </form>
				     </div>
				 </div>
			 </div>
		 </div>
	 </div>
	 <div id="footer">
		 <div id="footer-whitecontent">
			 <a href="http://www.derrickedd.com/software/eduke" target="_blank"><img src="../../system/images/eduke.png" width="50"></a><br>
		 </div>
	 </div>
</body>
</html>