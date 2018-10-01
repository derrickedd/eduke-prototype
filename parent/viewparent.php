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
     <title>Eduke - View Parents</title>
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
			     <a href="../parent/parent.php" class="selected-nav"><img style="vertical-align:middle;" src="../../system/images/sys-nav/parent.png" height="15px" width="15px"> Parent</a>
			 </p>
		     <p><a href="../settings/settings.php"><img style="vertical-align:middle;" src="../../system/images/sys-nav/settings.png" height="15px" width="15px"> Settings</a></p>
		     <p><a href="../../system/guide/guide.php" target="_blank"><img style="vertical-align:middle;" src="../../system/images/sys-nav/usermanual.png" height="15px" width="15px"> User manual</a></p>
		 </div>
		 
	     <div id="content-reload">
			 <div id="boxlist-content">
			     <h1>VIEW PARENTS</h1>
				 <p><b>Directory: View Parents</b></p>
				 
				 <div id="popup">
		             <div class="popupwhitecontent">
					     <div><img src="../../system/images/sys-nav/close.png" class="closeopup" onclick=closePopup()>
						 <h3>ADD STUDENT TO PARENT</h3>
						     <p><b>RELATIONSHIP</b> <br><select id="relationship">
							     <option>- Select Relation -</option>
							     <option value="MOTHER" onclick=enableSearch()>MOTHER</option>
							     <option value="FATHER" onclick=enableSearch()>FATHER</option>
							     <option value="GUARDIAN" onclick=enableSearch()>GUARDIAN</option>
							 </select></p>
							 <p><b>SEARCH STUDENT</b> <br><input type="text\" id="search" style="display:none;" placeholder="Student Name"></p>
						 </div>
					     <p id="displaysearchstudentandmakepayment"></p>
					 </div>
		         </div>
				 
			      <div id="main">
				 <?php
				     if(isset($_GET['parent_id']))
					 {
						 $parent_id = $_GET['parent_id'];
						 
						 $query = "SELECT * FROM parents WHERE parent_id = '$parent_id'";
						 $result = mysql_query($query);
						 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 $rows = mysql_num_rows($result);
						 
						 
						 $row = mysql_fetch_row($result);
						 
						 echo "<div style=\"display:inline-block;vertical-align:top;\" id=\"view-student\">";
						 echo "<h3>USER DETAILS</h3>";
						 echo "<p><b>PARENT ID</b> <br><input type=\"text\" value=\"$row[0]\" id=\"user_id\" disabled></p>";
						 echo "<p><b>FIRST NAME</b> <br><input type=\"text\" value=\"$row[1]\" id=\"parent_firstname\"></p>";
						 echo "<p><b>LAST NAME</b> <br><input type=\"text\" value=\"$row[2]\" id=\"parent_lastname\"></p>";
						 
						 echo "<p><b>GENDER</b> <br><select id=\"gender\">";
						     if ($row[3] == "F"){
								 echo "<option value=\"F\">FEMALE</option>";
						         echo "<option value=\"M\">MALE</option>";
							 } elseif($row[3] == "M") {
								 echo "<option value=\"M\">MALE</option>";
								 echo "<option value=\"F\">FEMALE</option>";
							 }
							 
						 echo "</select></p>";
						 
						 echo "<p><b>ADDRESS</b> <br><input type=\"text\" value=\"$row[4]\" id=\"address\"></p>";
						 echo "<p><b>PHONE</b> <br><input type=\"text\" value=\"$row[5]\" id=\"phone\"></p>";
						 echo "<p><b>OTHER PHONE</b> <br><input type=\"text\" value=\"$row[6]\" id=\"phone_alt\"></p>";
						 echo "<p><b>EMAIL</b> <br><input type=\"text\" value=\"$row[7]\" id=\"email\"></p>";
						 
						 echo "<br>";
						 echo "<p style=\"width:590px;text-align:center;margin:8px;\">
							 <input type=\"button\" value=\"Save\" style=\"background-color:green;border:solid 1px green;border-radius:3px;cursor:pointer;
							 color:white;float:left;text-decoration:none;\" onclick=saveParentsData()>
						 
						     <input type=\"button\" value=\"Delete Parent\" style=\"background-color:black;border:solid 1px black;border-radius:3px;cursor:pointer;
							 color:red;float:right;text-decoration:none;\" onclick=deleteParent()>
					     </p>
						 </div>";
						 
						 echo "<div id=\"photobox\" style=\"display:inline-block;vertical-align:top;\">
						 <h3>PARENT PHOTO</h3>";
							 if ($row[9] == "")
							 {
								 $photo = "";
								 echo "<img src=\"parent photos/default.jpg\" width=\"300\">";
							 } 
							 elseif ($row[9] == "default")
							 {
								 $photo = "";
								 echo "<img src=\"parent photos/default.jpg\" width=\"300\">";
							 } 
							 else {
								 $photo = $row[9];
								 echo "<input type=\"button\" value=\"Delete Photo\" onclick=deleteParentPhoto()
								 style=\"position:absolute;cursor:pointer;padding:10px;background-color:#bc3226;border:solid 1px #bc3226;
								 border-radius:3px;color:#fff;width:100px;\"> <img src=\"$row[9]\" width=\"300\">";
							 }
							 /*echo "$row[9]";*/
							 echo "<form action=\"uploadphoto.php?parent_id=$parent_id\" method=\"POST\" enctype=\"multipart/form-data\">
								 <p><input type=\"file\" name=\"fileToUpload\" style=\"border:none;width:200px;\" 
								 id=\"fileToUpload\" accept=\"image/*\" required> 
								 <input type=\"submit\" value=\"Upload Photo\" style=\"padding:10px;background-color:green;color:#fff;border:solid 1px green;
								 border-radius:3px;cursor:pointer;width:100px;\"></p>
							 </form>";
							 echo "</div>";
							 
							 echo "<div id=\"parent-list-on-viewstudent\">";
							     echo "<input type=\"button\" value=\"Add Student\" style=\"padding:10px;background-color:skyblue;color:#fff;width:160px;
								 cursor:pointer;border:solid 1px skyblue;border-radius:3px;float:right;\" onclick=addStudentToParent()>";
							     echo "<h3>STUDENTS</h3>";
								 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
										 <span style=\"width:100px;\"><b>STUDENT ID</b></span>
										 <span style=\"width:120px;\"><b>RELATIONSHIP</b></span>
										 <span style=\"width:190px;\"><b>STUDENT NAME</b></span>
									 </p>";
									 
									 $query = "SELECT * FROM studentparent WHERE parent_id = '$parent_id'";
									 $result = mysql_query($query);
									 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
									 
									 echo "<ul>";
										 while($row=mysql_fetch_array($result)){
											 $student_id = $row['student_id'];
											 $relationship = $row['relationship'];
											 
											 /*Checking for class*/
											 $queryex = "SELECT student_firstname, student_lastname FROM schoolstudents WHERE student_id = '$student_id'";
											 $resultex = mysql_query($queryex);
											 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
											 $rowsex = mysql_num_rows($resultex);
											 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
											 {
												 $rowex = mysql_fetch_row($resultex);
												 $student_firstname = $rowex[0];
												 $student_lastname = $rowex[1];
											 }
											 /*END of Checking for class*/
											 
											 echo "<li><a href=\"../student/viewstudent.php?student_id=$student_id\" style=\"display:inline-block!important;\">
												 <span style=\"width:100px;\">$student_id</span>
												 <span style=\"width:120px;\">$relationship</span>
												 <span style=\"width:190px;\">$student_firstname $student_lastname</span>
												 </a>
												 <span style=\"width:150px;display:inline-block;\">
												     <input type=\"button\" value=\"Delete\" style=\"background-color:black;border:solid 1px black;
													 border-radius:3px;color:red;cursor:pointer;padding:5px;\" onclick=deleteParentAssociation($student_id)>
												 </span>
											 </li>";
										 }
									 echo "</ul>";
								 echo "</div>";
						 
					 } else {
					     echo "<div style=\"width:600px;margin-left:auto;margin-right:auto;\"><h1>SYSTEM ERROR</h1><br>
						 <p style=\"line-height:2;\"><b>Some thing went wrong while using this system. This maybe as a result of wrong data entry to the system.
						 For assistance check the <a href=\"../../system/guide/guide.php\">Guide</a> or contact the support
						 team if problem persists</b></p></div>";
					 }
				 ?>
				</div>
			 </div>
		 </div>
	 </div>
	 <div id="footer">
		 <div id="footer-whitecontent">
			 <a href="http://www.derrickedd.com/software/eduke" target="_blank"><img src="../../system/images/eduke.png" width="50"></a><br>
		 </div>
	 </div>
	 <script>
		 <?php
		 echo "function deleteParentPhoto(){
			 
			 if (confirm('Are you sure you want to delete the photo?')) {
				 photo = \"$photo\";
				 photo = photo.trim().replace(/ /g, '%20');
				 $.ajax({
					 type:\"post\",
					 url:\"parent-process-function.php\",
					 data:\"photo=\"+photo+\"&parent_id=\"+$parent_id+\"&action=deleteparentphoto\",
					 success:function(data){
						 location.reload();
					 }
				 });
			 }
		 }";
		 echo "function deleteParent(){
			 
			 if (confirm('Are you sure you want to delete the parent?')) {
			     photo = \"$photo\";
				 photo = photo.trim().replace(/ /g, '%20');
				 $.ajax({
					 type:\"post\",
					 url:\"parent-process-function.php\",
					 data:\"photo=\"+photo+\"&parent_id=\"+$parent_id+\"&action=deleteparent\",
					 success:function(data){
						 window.location.href = \"parent.php\";
					 }
				 });
			 }
		 }"; 
		 echo "function deleteParentAssociation(student_id){
			 
			 if (confirm('Are you sure you want to remove the parent student association?')) {
				 $.ajax({
					 type:\"post\",
					 url:\"parent-process-function.php\",
					 data:\"parent_id=\"+$parent_id+\"&student_id=\"+student_id+\"&action=deleteparentassociation\",
					 success:function(data){
						 location.reload();
					 }
				 });
			 }
		 }";
		 echo "function addStudentToParent(){
			 $('#popup').css('display','block');
		 }";
		 echo "function enableSearch(){
			 $('#search').css('display','inline-block');
		 }";
		 echo "function assignStudentToParent(student_id, parent_id,relationship){
			 $.ajax({
					 type:\"post\",
					 url:\"parent-process-function.php\",
					 data:\"relationship=\"+relationship+\"&student_id=\"+student_id+\"&parent_id=\"+parent_id+\"&action=assignstudenttoparent\",
					 success:function(data){
						 $('#popup').css('display','none');
						 location.reload();
					 }
				 });
		 }";
		 echo "function closePopup(){
			     $('#popup').css('display','none');
		 }";
		 echo "function saveParentsData(){
			 var parent_firstname = $(\"#parent_firstname\").val();
			 var parent_lastname = $(\"#parent_lastname\").val();
			 var gender = $(\"#gender\").val();
			 var address = $(\"#address\").val();
			 var phone = $(\"#phone\").val();
			 var phone_alt = $(\"#phone_alt\").val();
			 var email = $(\"#email\").val();
			 
			 $.ajax({
				 type:\"post\",
				 url:\"parent-process-function.php\",
				 data:\"parent_firstname=\"+parent_firstname+\"&parent_lastname=\"+parent_lastname+\"&gender=\"+gender+
				 \"&address=\"+address+\"&phone=\"+phone+\"&phone_alt=\"+phone_alt+
				 \"&email=\"+email+\"&parent_id=\"+$parent_id+
				 \"&action=saveparentsdata\",
				 success:function(data){
					 location.reload();
				 }
			 });
		 }";
		 
		 echo "$(document).ready(function() {
			 $(\"#displaysearchstudentandmakepayment\").hide();
				 $(\"#search\").keyup(function() {
					 var student_name = $(\"#search\").val();
					 var relationship = $(\"#relationship\").val();
					 
					 if (student_name == \"\") {
						 $(\"#displaysearchstudentandmakepayment\").html(\"\");
						 $(\"#displaysearchstudentandmakepayment\").hide();
					 }
					 else {
						 $.ajax({
							 type: \"POST\",
							 url: \"parent-process-function.php\",
							 data:\"relationship=\"+relationship+\"&student_name=\"+student_name+\"&parent_id=\"+$parent_id+\"&action=searchstudentandmakepayment\",
							 success: function(html) {
								 $(\"#displaysearchstudentandmakepayment\").html(html).show();
							 }
						 });
					 }
				 });
			 });";
		 ?>
	 
     </script>
     <noscript>
	     <div style="position:absolute;width:100%;height:100%;background-color:#33333f;">
		     <p>Please enable javascript</p>
		 </div>
	 </noscript>
</body>
</html>