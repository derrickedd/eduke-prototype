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
     <title>Eduke - Add Student</title>
	 <link rel="stylesheet" type="text/css" href="../css/index.css">
	 <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
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
				     <a href="../student/addstudent.php" class="selected-nav">Add Student</a>
				     <a href="../student/alumnistudents.php">Alumni Students</a>
				     <a href="../student/studentroles.php">Student Roles</a>
				 </span>
			     <a href="../student/student.php" class="selected-nav"><img style="vertical-align:middle;" src="../../system/images/sys-nav/student.png" height="15px" width="15px"> Student</a>
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
				     <a href="../house/addhouse.php">Add House</a>
				 </span>
			     <a href="../house/house.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/house.png" height="15px" width="15px"> House</a>
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
		         <h1>ADD STUDENT</h1>
				 <p><img src="../../system/images/sys-nav/house-red.png" height="15px"> <b>Students</b> / <b>Add Student</b></p>
				 
			     <div id="form-content">
				 <form action="studentadded.php" method="POST" enctype="multipart/form-data">
				     <div id="student-details">
					     <h2>PPERSONAL DETAILS</h2>
						 <h3>STUDENT DETAILS</h3>
					     <p>FIRST NAME: <br><input type="text" name="student_firstname" required></p>
					     <p>LAST NAME: <br><input type="text" name="student_lastname" required></p>
					     <p>ADMISSION NUMBER: <br><input type="text" name="admission_number" required></p>
						 <p>GENDER: <br><select name="gender">
							 <option value="NONE">SELECT GENDER</option>
							 <option value="M">MALE</option>
							 <option value="F">FEMALE</option>
						 </select></p>
						 <p>DATE OF BIRTH: <br><input type="text" name="dateofbirth" id="datepicker" required></p>
						 <?php
						     $query = "SELECT class_id,class_alias FROM schoolclass";
							 $result = mysql_query($query);
							 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
							 $rows = mysql_num_rows($result);
							 
							 echo "<p>CLASS: <br><select name=\"class_id\"><option value=\"NONE\">SELECT CLASS</option>";
							 for ($j = 0 ; $j < $rows ; ++$j)
							 {
								 $row = mysql_fetch_row($result);
								 echo "<tr>";
								 for ($k = 0 ; $k < 1 ; ++$k)
									 echo "<option value=$row[0]>$row[1]</option>";
								 echo "</tr>";
							 }
							 echo "</select></p>";
						 ?>
					 
					     <p>RELIGION: <br><input type="text" name="religion" required></p>
						 <?php
						     $query = "SELECT house_id,house_name FROM schoolhouses";
							 $result = mysql_query($query);
							 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
							 $rows = mysql_num_rows($result);
							 
							 echo "<p>HOUSE ID: <br><select name=\"house_id\"><option value=\"NONE\">SELECT HOUSE</option>";
							 for ($j = 0 ; $j < $rows ; ++$j)
							 {
								 $row = mysql_fetch_row($result);
								 for ($k = 0 ; $k < 1 ; ++$k)
									 echo "<option value=$row[0]>$row[1]</option>";
								 $pickendrow = $row[0]; /*variable for button display*/
							 }
							 echo "</select></p>";
						 ?>
						 <p>ADDRESS: <br><input type="text" name="address" required></p>
						 <?php
						     $query = "SELECT academic_term_id,academic_year,academic_term FROM schoolterm";
							 $result = mysql_query($query);
							 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
							 $rows = mysql_num_rows($result);
							 
							 echo "<p>ADMISSION PERIOD: <br><select name=\"academic_term_id\"><option value=\"NONE\">ADMISSION PERIOD</option>";
							 for ($j = 0 ; $j < $rows ; ++$j)
							 {
								 $row = mysql_fetch_row($result);
								 for ($k = 0 ; $k < 1 ; ++$k)
									 echo "<option value=$row[0]>$row[1] - $row[2]</option>";
							 }
							 echo "</select></p>";
						 ?>
						 <!--<p>PHOTO: <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" ></p>-->
						 </div>
					     <div id="guardian-details">
						     <div id="father-details">
							     <h2>GUARDIAN DETAILS</h2>
								 <h3>FATHER DETAILS</h3>
								 <p>FIRST NAME: <input type="text" name="fathers_firstname" ></p>
								 <p>LAST NAME: <input type="text" name="fathers_lastname" ></p>
								 <p>PHONE: <input type="text" name="fathers_phone" ></p>
								 <p>EMAIL: <input type="text" name="fathers_email" ></p>
							 </div>
							 <div id="mother-details">
								 <h3>MOTHER DETAILS</h3>
								 <p>FIRST NAME: <input type="text" name="mothers_firstname" ></p>
								 <p>LAST NAME: <input type="text" name="mothers_lastname" ></p>
								 <p>PHONE: <input type="text" name="mothers_phone" ></p>
								 <p>EMAIL: <input type="text" name="mothers_email" ></p>
							 </div>
							 <div id="other-details">
								 <h3>OTHER</h3>
								 <p>FIRST NAME: <input type="text" name="other_firstname" ></p>
								 <p>LAST NAME: <input type="text" name="other_lastname" ></p>
								 <p>PHONE: <input type="text" name="others_phone" ></p>
								 <p>EMAIL: <input type="text" name="others_email" ></p>
							 </div>
						 </div>
					     
					 <p style="text-align:right;width:600px;"><input style="background-color:green;color:#fff;border:solid 1px green!important;
					 border-radius:3px;padding:15px;
					 cursor:pointer;" type="submit" value="Add Student"></p>
				 </form>
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