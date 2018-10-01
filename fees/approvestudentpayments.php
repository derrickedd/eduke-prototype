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
     <title>Eduke - Approve Payments Student wise</title>
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
				     <a href="../fees/approvepayments.php" class="selected-nav">Approve Payments</a>
				     <a href="../fees/feewaiver.php">Fee Waiver</a>
				 </span>
			     <a href="../fees/fees.php" class="selected-nav"><img style="vertical-align:middle;" src="../../system/images/sys-nav/fees.png" height="15px" width="15px"> Fees</a>
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
			     <h1>APPROVE PAYMENT OVERVIEW - STUDENT WISE</h1>
				 <p><b>Directory: Fees</b> / <b>Approve Payments</b> / <b>Student wise</b></p>
				 
				 <div id="main">
				 <?php
				     if(isset($_GET['academic_term_id']) && isset($_GET['class_id']) && isset($_GET['student_id']))
				     {
						 $academic_term_id = $_GET['academic_term_id'];						 
						 $class_id = $_GET['class_id'];						 
						 $student_id = $_GET['student_id'];						 
						 
						 
						 echo "<div id=\"list-payments\">";
						     echo "<h3>PAYMENT DETAILS</h3>";
		 
							 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
									 <span style=\"width:100px;\"><b>PAYMENT ID</b></span>
									 <span style=\"width:120px;\"><b>PAYMENT FOR</b></span>
									 <span style=\"width:100px;\"><b>BANK SLIP</b></span>
									 <span style=\"width:110px;\"><b>PAID</b></span>
									 <span style=\"width:110px;\"><b>BALANCE</b></span>
									 <span style=\"width:120px;\"><b>PAYMENT DATE</b></span>
									 <span style=\"width:100px;\"><b>USER ID</b></span>
									 <!--<span style=\"width:90px;\"><b>STATUS</b></span>-->
									 <span style=\"width:90px;\"><b>APPROVED</b></span>
									 </p>";
												 
							 $query = "SELECT * FROM schoolfees WHERE student_id = $student_id AND academic_term_id = '$academic_term_id'
								 AND class_id = '$class_id' ORDER BY schoolfees_id ASC";
							 $result = mysql_query($query);
							 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
												 
							 echo "<ul>";
							 while($row=mysql_fetch_array($result))
							 {
								 $schoolfees_id = $row['schoolfees_id'];
								 $priority = $row['priority'];
								 $bank_slip_number = $row['bank_slip_number'];
								 $fees_paid = $row['fees_paid'];
								 $fees_balance = $row['fees_balance'];
								 $payment_date = $row['payment_date'];
								 $user_id = $row['user_id'];
								 $status = $row['status'];
								 $approved_by = $row['approved_by'];
														 
								 
														 
								 /*Checking for user*/
								 $queryex = "SELECT username FROM users WHERE user_id = $user_id";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
								 $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $username = $rowex[0];
								 }
								 /*END of Checking for user*/
								
								 echo "<li>
										<span style=\"width:100px;\">$schoolfees_id</span>
										<span style=\"width:120px;\">$priority</span>
										<span style=\"width:100px;\">$bank_slip_number</span>
										<span style=\"width:110px;\">$fees_paid</span>
										<span style=\"width:110px;\">$fees_balance</span>
										<span style=\"width:120px;\">$payment_date</span>
										<span style=\"width:100px;\">$username</span>
										<!--<span style=\"width:90px;\">$status</span>-->";
								 
								 /*Checking for the maximum record*/
								 $querychk = "SELECT MAX(schoolfees_id) FROM schoolfees WHERE student_id = $student_id AND academic_term_id = $academic_term_id
								 AND class_id = $class_id AND priority = '$priority'";
								 $resultchk = mysql_query($querychk);
								 if(!$resultchk) die("DB access failed(derro internal error): " . mysql_error());
								 $rowschk = mysql_num_rows($resultchk);
								 for ($jchk = 0 ; $jchk < $rowschk ; ++$jchk)
								 {
									 $rowchk = mysql_fetch_row($resultchk);
									 $max_row = $rowchk[0];
								 }
								 /*END of Checking for the maximum record*/
								 
								 if ($status == "Pending")
								 {
									 echo "<span style=\"width:90px;\">
										 <input type=\"button\" class=\"approvepaymentbutton\" onclick=\"approveFeesPayment($schoolfees_id,$sysuser_id)\" value=\"Approve\">
										 </span>";
								 } else if($status == "Approved"){
									 /*Checking for user*/
									 $queryex = "SELECT username FROM users WHERE user_id = $approved_by";
									 $resultex = mysql_query($queryex);
									 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
									 $rowsex = mysql_num_rows($resultex);
									 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
									 {
										 $rowex = mysql_fetch_row($resultex);
										 $approvedusername = $rowex[0];
									 }
									 /*END of Checking for user*/
									 echo "<span style=\"width:90px;\">$approvedusername</span>";
									 echo "<span style=\"width:90px;\">
										 <input type=\"button\" class=\"unapprovepaymentbutton\" onclick=\"unApproveFeesPayment($schoolfees_id,$sysuser_id)\" value=\"Un-Approve\">
										 </span>";
								 }

								 echo "</li>";
							 }
							echo "</ul>";
						 echo "</div>";
					 }						
					 else {
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
		 function approveFeesPayment(schoolfees_id,sysuser_id){
			 $.ajax({
				 type:"post",
				 url:"fees-process-function.php",
				 data:"sysuser_id="+sysuser_id+"&schoolfees_id="+schoolfees_id+"&action=approvefeespayment",
				 success:function(data){
					 location.reload();
				 }
			 });
		 }
		 function unApproveFeesPayment(schoolfees_id,sysuser_id){
			 $.ajax({
				 type:"post",
				 url:"fees-process-function.php",
				 data:"sysuser_id="+sysuser_id+"&schoolfees_id="+schoolfees_id+"&action=unapprovefeespayment",
				 success:function(data){
					 location.reload();
				 }
			 });
		 }
     </script>
	 <noscript>
	     <div style="position:absolute;width:100%;height:100%;background-color:#33333f;">
		     <p>Please enable javascript</p>
		 </div>
	 </noscript>
</body>
</html>