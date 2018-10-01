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
	 
	 $db_server = mysql_connect($db_hostname, $db_username, $db_password);
	 if(!$db_server) die("Unable to connect to MySQL: ". mysql_error());
	 
	 mysql_select_db($db_database) 
	     or die("Unable to select database; ".mysql_error());
 
     $action=$_POST["action"];
     
	 /*Adding a notice*/
	 if($action == "showstudentlistaftersearch") {
		 $search_student = $_POST["search_student"];
		 $search_student = sanitizeString($search_student);
		 
		 $studentstatus = $_POST["studentstatus"];
		 
		 
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
						 
		 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
					 <span style=\"width:50px;\"><b>ID</b></span>
					 <span style=\"width:130px;\"><b>ADMISSION NO.</b></span>
					 <span style=\"width:240px;\"><b>STUDENT NAME</b></span>
					 <span style=\"width:80px;\"><b>GENDER</b></span>
					 <span style=\"width:150px;\"><b>CLASS</b></span> 
					 <span style=\"width:150px;\"><b>ADMISSION PERIOD</b></span>
					 <span style=\"width:150px;\"><b>STATUS</b></span>
				 </p>";
				 
				 $query="SELECT * FROM schoolstudents WHERE status = '$studentstatus' AND (student_firstname LIKE '%$search_student%' OR student_lastname LIKE '%$search_student%')
				 ORDER BY student_id ASC LIMIT $start_from, $results_per_page";
				 $result = mysql_query($query);
				 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 
				 echo "<ul>";
					 while($row=mysql_fetch_array($result)){
						 $student_id = $row['student_id'];
						 $admission_number = $row['admission_number'];
						 $student_firstname = $row['student_firstname'];
						 $student_lastname = $row['student_lastname'];
						 $gender = $row['gender'];
						 $status = $row['status'];
						 
						 //-display the result of the array
						 
						 /*Checking for class*/
						 $queryex = "SELECT MAX(class_id) FROM classenrolled WHERE student_id = '$student_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $class_id = $rowex[0];
						 }
						 /*Checking for class alias*/
						 $queryex = "SELECT class_alias FROM schoolclass WHERE class_id = '$class_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							$rowex = mysql_fetch_row($resultex);
							$class_alias = $rowex[0];
						 }
						 if ($rowsex == 0){
							 $class_alias = "";
						 }
										 /*END of Checking for class alias*/
						 /*END of Checking for class*/
						 
						 /*Checking for class*/
						 $queryex = "SELECT MIN(class_id), academic_term_id FROM classenrolled WHERE student_id = '$student_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $academic_term_id = $rowex[1];
						 }
						 /*END of Checking for class*/
						 
						 /*Checking for admission_date*/
						 $queryex = "SELECT academic_year,academic_term FROM schoolterm WHERE academic_term_id = '$academic_term_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $admission_year = $rowex[0];
							 $admission_term = $rowex[1];
						 }
						 if ($rowsex == 0){
							 $admission_year = "";
							 $admission_term = "";
						 }
						 /*END of Checking for admission_date*/
						 
						 echo "<li>
								 <a  href=\"viewstudent.php?student_id=$student_id\">
								 <span style=\"width:50px;\">$student_id</span>
								 <span style=\"width:130px;\">$admission_number</span>
								 <span style=\"width:240px;\">$student_firstname $student_lastname</span>
								 <span style=\"width:80px;\">$gender</span>
								 <span style=\"width:150px;\">$class_alias</span>
								 <span style=\"width:150px;\">$admission_year - $admission_term</span>
								 <span style=\"width:150px;color:green;\">$status</span>
								 </a>
							</li>";
					 }
				 echo "</ul>";
						 
				 $query = "SELECT COUNT(student_id) FROM schoolstudents WHERE status = '$studentstatus' AND (student_firstname LIKE '%$search_student%' OR student_lastname LIKE '%$search_student%')";
				 $result = mysql_query($query);
				 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
				 $rows = mysql_num_rows($result);
						 
				 $row = mysql_fetch_row($result);
				 echo "<div id=\"list-footer\">";
				 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
				 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
					 echo "<a href=\"javascript:moreSearchStudents($i,'$studentstatus')\"";
					 if ($i==$page)  
						 echo " class='curPage'";
					 echo ">$i</a> ";
				 };
				 echo "</div>";
		 
		 
	 }
	 /*Showing student list*/
	 else if($action == "showstudentlist"){
		 $studentstatus = $_POST["studentstatus"];
		 
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
						 
		 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
					 <span style=\"width:50px;\"><b>ID</b></span>
					 <span style=\"width:130px;\"><b>ADMISSION NO.</b></span>
					 <span style=\"width:240px;\"><b>STUDENT NAME</b></span>
					 <span style=\"width:80px;\"><b>GENDER</b></span>
					 <span style=\"width:150px;\"><b>CLASS</b></span> 
					 <span style=\"width:150px;\"><b>ADMISSION PERIOD</b></span>
					 <span style=\"width:150px;\"><b>STATUS</b></span>
				 </p>";
						 
				 $query = "SELECT * FROM schoolstudents WHERE status = '$studentstatus' ORDER BY student_id ASC LIMIT $start_from, $results_per_page";
				 $result = mysql_query($query);
				 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 
				 echo "<ul>";
					 while($row=mysql_fetch_array($result)){
						 $student_id = $row['student_id'];
						 $admission_number = $row['admission_number'];
						 $student_firstname = $row['student_firstname'];
						 $student_lastname = $row['student_lastname'];
						 $gender = $row['gender'];
						 $status = $row['status'];
						 
						 //-display the result of the array
						 
						 /*Checking for class*/
						 $queryex = "SELECT MAX(class_id) FROM classenrolled WHERE student_id = '$student_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $class_id = $rowex[0];
						 }
						 /*Checking for class alias*/
						 $queryex = "SELECT class_alias FROM schoolclass WHERE class_id = '$class_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							$rowex = mysql_fetch_row($resultex);
							$class_alias = $rowex[0];
						 }
						 if ($rowsex == 0){
							 $class_alias = "";
						 }
										 /*END of Checking for class alias*/
						 /*END of Checking for class*/
						 
						 /*Checking for class*/
						 $queryex = "SELECT MIN(class_id), academic_term_id FROM classenrolled WHERE student_id = '$student_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $academic_term_id = $rowex[1];
						 }
						 /*END of Checking for class*/
						 
						 /*Checking for admission_date*/
						 $queryex = "SELECT academic_year,academic_term FROM schoolterm WHERE academic_term_id = '$academic_term_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $admission_year = $rowex[0];
							 $admission_term = $rowex[1];
						 }
						 if ($rowsex == 0){
							 $admission_year = "";
							 $admission_term = "";
						 }
						 /*END of Checking for admission_date*/
						 
						 echo "<li>
								 <a  href=\"viewstudent.php?student_id=$student_id\">
								 <span style=\"width:50px;\">$student_id</span>
								 <span style=\"width:130px;\">$admission_number</span>
								 <span style=\"width:240px;\">$student_firstname $student_lastname</span>
								 <span style=\"width:80px;\">$gender</span>
								 <span style=\"width:150px;\">$class_alias</span>
								 <span style=\"width:150px;\">$admission_year - $admission_term</span>
								 <span style=\"width:150px;color:green;\">$status</span>
								 </a>
							</li>";
					 }
				 echo "</ul>";
						 
				 $query = "SELECT COUNT(student_id) FROM schoolstudents WHERE status = '$studentstatus'";
				 $result = mysql_query($query);
				 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
				 $rows = mysql_num_rows($result);
						 
				 $row = mysql_fetch_row($result);
				 echo "<div id=\"list-footer\">";
				 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
				 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
					 echo "<a href=\"javascript:moreStudents($i,'$studentstatus')\"";
					 if ($i==$page)  
						 echo " class='curPage'";
					 echo ">$i</a> ";
				 };
				 echo "</div>";
	 }
	 /*showing stduent list by class id*/
	 else if($action == "showstudentlistbyclassid"){
		 $class_id = $_POST["class_id"];
		 $studentstatus = $_POST["studentstatus"];
		 
		 
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
						 
		 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
					 <span style=\"width:50px;\"><b>ID</b></span>
					 <span style=\"width:130px;\"><b>ADMISSION NO.</b></span>
					 <span style=\"width:240px;\"><b>STUDENT NAME</b></span>
					 <span style=\"width:80px;\"><b>GENDER</b></span>
					 <span style=\"width:150px;\"><b>CLASS</b></span> 
					 <span style=\"width:150px;\"><b>ADMISSION PERIOD</b></span>
					 <span style=\"width:150px;\"><b>STATUS</b></span>
				 </p>";
				 
				 $query="SELECT * FROM schoolstudents WHERE class_id = '$class_id' AND status = '$studentstatus' ORDER BY student_id ASC LIMIT $start_from, $results_per_page";
				 $result = mysql_query($query);
				 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 
				 echo "<ul>";
					 while($row=mysql_fetch_array($result)){
						 $student_id = $row['student_id'];
						 $admission_number = $row['admission_number'];
						 $student_firstname = $row['student_firstname'];
						 $student_lastname = $row['student_lastname'];
						 $gender = $row['gender'];
						 $status = $row['status'];
						 
						 //-display the result of the array
						 
						 /*Checking for class*/
						 $queryex = "SELECT MAX(class_id) FROM classenrolled WHERE student_id = '$student_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $class_id = $rowex[0];
						 }
						 /*Checking for class alias*/
						 $queryex = "SELECT class_alias FROM schoolclass WHERE class_id = '$class_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							$rowex = mysql_fetch_row($resultex);
							$class_alias = $rowex[0];
						 }
										 /*END of Checking for class alias*/
						 /*END of Checking for class*/
						 
						 /*Checking for class*/
						 $queryex = "SELECT MIN(class_id), academic_term_id FROM classenrolled WHERE student_id = '$student_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $academic_term_id = $rowex[1];
						 }
						 /*END of Checking for class*/
						 
						 /*Checking for admission_date*/
						 $queryex = "SELECT academic_year,academic_term FROM schoolterm WHERE academic_term_id = '$academic_term_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $admission_year = $rowex[0];
							 $admission_term = $rowex[1];
						 }
						 /*END of Checking for admission_date*/
						 
						 echo "<li>
								 <a  href=\"viewstudent.php?student_id=$student_id\">
								 <span style=\"width:50px;\">$student_id</span>
								 <span style=\"width:130px;\">$admission_number</span>
								 <span style=\"width:240px;\">$student_firstname $student_lastname</span>
								 <span style=\"width:80px;\">$gender</span>
								 <span style=\"width:150px;\">$class_alias</span>
								 <span style=\"width:150px;\">$admission_year - $admission_term</span>
								 <span style=\"width:150px;color:green;\">$status</span>
								 </a>
							</li>";
					 }
				 echo "</ul>";
						 
				 $query = "SELECT COUNT(student_id) FROM schoolstudents WHERE class_id = '$class_id' AND status = '$studentstatus'";
				 $result = mysql_query($query);
				 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
				 $rows = mysql_num_rows($result);
						 
				 $row = mysql_fetch_row($result);
				 echo "<div id=\"list-footer\">";
				 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
				 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
					 echo "<a href=\"javascript:moreSearchStudentsByID($i,$class_id,'$studentstatus')\"";
					 if ($i==$page)  
						 echo " class='curPage'";
					 echo ">$i</a> ";
				 };
				 echo "</div>";
     }
     else if($action == "checkexamsforterm"){
		 $academic_term_id = $_POST["academic_term_id"];
		 $class_id = $_POST["class_id"];
		 $sub_class_id = $_POST["sub_class_id"];
		 $student_id = $_POST["student_id"];
		 
		 /*Checking for class_category_id*/
					     $queryex = "SELECT class_category_id FROM schoolsubclass WHERE sub_class_id = '$sub_class_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $class_category_id = $rowex[0];
						 }
						 if($rowsex == 0){
							 $class_category_id = 0;
						 }
						 /*END of Checking for class_category_id*/
		 
		 $queryex = "SELECT exam_id, examtypes_id FROM exams WHERE academic_term_id = '$academic_term_id' ORDER BY academic_term_id DESC";
		 $resultex = mysql_query($queryex);
		 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsex = mysql_num_rows($resultex);
		 
		 echo "<p><b>EXAMS IN THIS PERIOD</b> <br> <select name=\"academic_term_id\"><option>- Select Exam -</option>";
		 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
		 {
			 $rowex = mysql_fetch_row($resultex);
 
			 for ($kex = 0 ; $kex < 1 ; ++$kex)
			 /*Checking for exam_abreviation*/
			 $querytype = "SELECT exam_abreviation FROM examtypes WHERE examtypes_id = '$rowex[1]'";
			 $resulttype = mysql_query($querytype);
			 if(!$resulttype) die("DB access failed(derro internal error): " . mysql_error());
			 $rowstype = mysql_num_rows($resulttype);
			 for ($jtype = 0 ; $jtype < $rowstype ; ++$jtype)
			 {
				 $rowtype = mysql_fetch_row($resulttype);
				 $displayexamtype = $rowtype[0];
			 }
			 /*END of Checking for exam_abreviation*/
				 echo "<option value=$rowex[0] onclick=\"studentMarks($student_id, $rowex[0],$class_id,$sub_class_id)\">$displayexamtype</option>";
		 }
	     echo "</select></p>";
	 }
	 else if($action == "showreportbutton"){
		 $term_id = $_POST["academic_term_id"];
		 $class_id = $_POST["class_id"];
		 $sub_class_id = $_POST["sub_class_id"];
		 $student_id = $_POST["student_id"];
		 
		 /*Looking for exam abreviation*/
		 $queryq1 = "SELECT classlevel_id FROM schoolclass WHERE class_id = '$class_id'";
		 $resultq1 = mysql_query($queryq1);
		 if(!$resultq1) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsq1 = mysql_num_rows($resultq1);
		
		 for ($jq1 = 0 ; $jq1 < $rowsq1 ; ++$jq1)
		 {
			 $rowq1 = mysql_fetch_row($resultq1);
			 $classlevel_id = $rowq1[0];
		 }
		 /*End Looking for exam abreviation*/
		 
		 /*Looking for exam abreviation*/
		 $queryq1 = "SELECT report_type FROM classlevel WHERE classlevel_id = '$classlevel_id'";
		 $resultq1 = mysql_query($queryq1);
		 if(!$resultq1) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsq1 = mysql_num_rows($resultq1);
		
		 for ($jq1 = 0 ; $jq1 < $rowsq1 ; ++$jq1)
		 {
			 $rowq1 = mysql_fetch_row($resultq1);
			 $report_type = $rowq1[0];
		 }
		 /*End Looking for exam abreviation*/
		 if ($report_type == "Type A"){
			 $report_typevalue == "studentreport_a";
		 }
		 if ($report_type == "Type B"){
			 $report_typevalue = "studentreport_b";
		 }
		 if ($report_type == "Type C"){
			 $report_typevalue = "studentreport_c";
		 }
		 
		 echo "<a href=\"$report_typevalue.php?term_id=$term_id&class_id=$class_id&sub_class_id=$sub_class_id&student_id=$student_id\" target=\"_blank\"
			 style=\"width:100px;background-color:darkorange;color:#fff;border-radius:3px;text-decoration:none;text-align:center;\">Report</a>";
	 }
	 else if($action == "studentsubjectmarks"){
		 
		 $student_id = $_POST["student_id"];
		 $exam_id = $_POST["exam_id"];
		 $class_id = $_POST["class_id"];
		 $sub_class_id = $_POST["sub_class_id"];
		 
		 /*Checking for class_category_id*/
					     $queryex = "SELECT class_category_id FROM schoolsubclass WHERE sub_class_id = '$sub_class_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $class_category_id = $rowex[0];
						 }
						 if($rowsex == 0){
							 $class_category_id = 0;
						 }
						 /*END of Checking for class_category_id*/
		 
		 /*Looking for level of class*/
		 $queryq = "SELECT classlevel_id FROM schoolclass WHERE class_id = '$class_id'";
		 $resultq = mysql_query($queryq);
		 if(!$resultq) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsq = mysql_num_rows($resultq);
							 
		 for ($jq = 0 ; $jq < $rowsq ; ++$jq)
		 {
			 $rowq = mysql_fetch_row($resultq);
			 $classlevel_id = $rowq[0]; /*variable for button display*/
		 }
		 /*End Looking for level of class*/
		 
		 echo "<div class=\"subject-marks-headings\">";
		     $querycount = "SELECT COUNT(*) FROM schoolsubjects WHERE classlevel_id = '$classlevel_id' AND class_category_id = '$class_category_id'";
			 $resultcount = mysql_query($querycount);
			 if(!$resultcount) die("DB access failed(derro internal error): " . mysql_error());
						 
			 $rowscount = mysql_num_rows($resultcount);
			 for ($jcount = 0 ; $jcount < $rowscount ; ++$jcount)
			 {
				 $row = mysql_fetch_row($resultcount);
				 echo "<div id=\"dashboadview\" style=\"background-color:skyblue;\">
						 <p><img src=\"../../system/images/sys-nav/subject-white.png\" height=\"40px\"> <b>$row[0]</b></p>
						 <p>SUBJECTS</p>
				     </div>";
				 /*Checking for student name*/
					 $queryex = "SELECT student_firstname, student_lastname  FROM schoolstudents WHERE student_id = '$student_id'";
					 $resultex = mysql_query($queryex);
					 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
					 $rowsex = mysql_num_rows($resultex);
					 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
					 {
						 $rowex = mysql_fetch_row($resultex);
						 $student_firstname = $rowex[0];
						 $student_lastname = $rowex[1];
				     }
				 /*END of Checking for student name*/
				 echo "<div>";
				     /*Looking for sub class name*/
					 $queryq = "SELECT sub_class_alias FROM schoolsubclass WHERE sub_class_id = '$sub_class_id'";
					 $resultq = mysql_query($queryq);
					 if(!$resultq) die("DB access failed(derro internal error): " . mysql_error());
					 $rowsq = mysql_num_rows($resultq);
										 
					 for ($jq = 0 ; $jq < $rowsq ; ++$jq)
					 {
						 $rowq = mysql_fetch_row($resultq);
						 $sub_class_alias = $rowq[0]; /*variable for button display*/
					 }
					 /*End Looking for sub class name*/
					 
					 /*Looking for class to display name*/
					 $queryq = "SELECT class_alias FROM schoolclass WHERE class_id = '$class_id'";
					 $resultq = mysql_query($queryq);
					 if(!$resultq) die("DB access failed(derro internal error): " . mysql_error());
					 $rowsq = mysql_num_rows($resultq);
										 
					 for ($jq = 0 ; $jq < $rowsq ; ++$jq)
					 {
						 $rowq = mysql_fetch_row($resultq);
						 $class_alias = $rowq[0]; /*variable for button display*/
						 echo "<p style=\"font-size:22px;padding:20px!important;\">CLASS: $class_alias - STREAM: $sub_class_alias</p>";
						 echo "<p style=\"font-size:18px;padding:20px!important;\">$student_firstname $student_lastname</p>";
					 }
					 /*End Looking for class to display name*/
				 echo "</div>";
				 
			 }
		 echo "</div>";
		 
		 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
			 <span style=\"width:200px;\"><b>SUBJECT</b></span>
			 <span style=\"width:50px;\"><b>PAPER</b></span>
			 <span style=\"width:70px;\"><b>SCORE</b></span>
		     <span style=\"width:130px;\"><b>ACTION</b></span>
		     </p>";
			 
		 $query = "SELECT * FROM schoolsubjects WHERE classlevel_id = '$classlevel_id' AND class_category_id = '$class_category_id'";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		
		 echo "<ul>";
		 while($row=mysql_fetch_array($result))
		 {
			 $subject_id = $row['subject_id'];
			 $number_of_papers = $row['number_of_papers'];
			 $subject_name = $row['subject_name'];
			 //-display the result of the array
				 
			 echo "<li>
			     <span style=\"width:200px;font-size:16px;\"><b>$subject_name</b></span>
				 
				 <span style=\"width:50px;\">";
				 for($count = 1; $count <= $number_of_papers; $count++){
					 echo "<br><b style=\"line-height:32px;\">P$count</b>";
				 }
				 echo "</span>";
				 
				 echo "<span style=\"width:200px;\">";
				 for($count = 1; $count <= $number_of_papers; $count++)
				 {
					 $queryp = "SELECT student_marks_id,score FROM studentmarks WHERE student_id = '$student_id' AND subject_id = '$subject_id' AND 
					 class_id = '$class_id' AND exam_id = '$exam_id' AND subject_paper = '$count'";
										 
					 $resultp = mysql_query($queryp);
					 if(!$resultp) die("DB access failed(derro internal error): " . mysql_error());
					 $rows1 = mysql_num_rows($resultp);
										 
					 for ($jq = 0 ; $jq < $rows1 ; ++$jq)
					 {
					     $rowq = mysql_fetch_row($resultp);
						 $student_marks_id = $rowq[0]; /*picked subject name variable for future display*/
						 $marks = $rowq[1]; /*picked subject name variable for future display*/
						 echo "<br><input style=\"width:50px;\" type=\"text\" value=\"$marks\">
						 <input style=\"background-color:#33333f;color:red;border:solid 1px #33333f;cursor:pointer;\" 
						     type=\"button\" value=\"Delete\" onclick=\"deleteStudentMark($student_id,$class_id,$sub_class_id,$exam_id,$student_marks_id)\">";
					 }
					 if ($rows1 == 0){
						 $id = "$student_id$subject_id$count$class_id$exam_id";
						 echo "<br><input style=\"width:50px;\" type=\"text\" id=\"$id\" value=\"\">
							 <input style=\"background-color:green;color:white;border:solid 1px green;cursor:pointer;\" 
							 type=\"button\" value=\"Add\" onclick=\"insertStudentMark($student_id,$subject_id,$count,$class_id,$sub_class_id,$exam_id,$id)\">";
					 }
				 }
				 echo "</span>";
				 
				 
			 echo "</li>";
		 }
	echo "</ul>";
	 }
	 else if($action == "insertstudentmark"){
		 $student_id = $_POST["student_id"];
		 $subject_id = $_POST["subject_id"];
		 $subject_paper = $_POST["subject_paper"];
		 $class_id = $_POST["class_id"];
		 $sub_class_id = $_POST["sub_class_id"];
		 $exam_id = $_POST["exam_id"];
		 $score = $_POST["score"];
		 
		 $query1 = "SELECT MAX(student_marks_id) FROM studentmarks";
		 $result = mysql_query($query1);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $row = mysql_fetch_row($result);
		 $student_marks_id = $row[0]+1;
						 
		 // This is where you would enter the posted fields into a database
		 $query = "INSERT INTO studentmarks(student_marks_id,student_id,subject_id,subject_paper,class_id,sub_class_id,exam_id,score)
				VALUES('$student_marks_id', '$student_id', '$subject_id', '$subject_paper', '$class_id', '$sub_class_id', '$exam_id', '$score')";
						 
		 queryMysql($query);
	 }
	 else if($action == "deletestudentmark"){
		 $student_marks_id = $_POST["student_marks_id"];
		 
		 $query = "DELETE FROM studentmarks WHERE student_marks_id = '$student_marks_id'";
		 queryMysql($query);
	 }
	 else if($action == "makepayment"){
		 $query1 = "SELECT MAX(schoolfees_id) FROM schoolfees";
		 $result = mysql_query($query1);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $row = mysql_fetch_row($result);
		 
		 $schoolfees_id = $row[0]+1;
		 
		 $priority = $_POST["priority"];
		 $student_id = $_POST["student_id"];
		 $class_id = $_POST["class_id"];
		 $bank_slip_number = $_POST["bank_slip_number"];
		 $bank_slip_number = sanitizeString($bank_slip_number);
		 $fees_paid = $_POST["fees_paid"];
		 $fees_paid = sanitizeString($fees_paid);
		 
		 $academic_term_id = $_POST["academic_term_id"];
		 $user_id = $_POST["user_id"];
		 $status = "Pending";
		 
		 if($priority == 'Compulsary'){
			 
			 
			 /*Checking for maximum schol fees paid*/
			 $queryex1 = "SELECT MAX(schoolfees_id) FROM schoolfees WHERE student_id = '$student_id' AND academic_term_id = '$academic_term_id'
			 AND class_id = '$class_id' AND priority = '$priority'";
			 $resultex1 = mysql_query($queryex1);
			 if(!$resultex1) die("DB access failed(derro internal error): " . mysql_error());
			 $rowsex1 = mysql_num_rows($resultex1);
			 for ($jex1 = 0 ; $jex1 < $rowsex1 ; ++$jex1)
			 {
				 $rowex = mysql_fetch_row($resultex1);
				 $schoolfees_id_ref = $rowex[0];
				 
				 /*Checking for last fees balance*/
				 $queryex = "SELECT fees_balance FROM schoolfees WHERE schoolfees_id = '$schoolfees_id_ref'";
				 $resultex = mysql_query($queryex);
				 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
				 $rowsex = mysql_num_rows($resultex);
				 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
				 {
					 $rowex = mysql_fetch_row($resultex);
					 $latest_fees_balance = $rowex[0];
					 $fees_balance = $latest_fees_balance - $fees_paid ;
				 }
				 /*END of Checking for last fees balance*/
				 
			 }
			 /*END of Checking for maximum schol fees paid*/
			 if($schoolfees_id_ref == null){
				 /*Checking for class fees of the class for the term selected*/
				 $queryex2 = "SELECT class_fees FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id' 
				 AND priority = '$priority'";
				 $resultex2 = mysql_query($queryex2);
				 if(!$resultex2) die("DB access failed(derro internal error): " . mysql_error());
				 $rowsex2 = mysql_num_rows($resultex2);
				 
				 $summingcompulsaryfees = 0;
				 while($rowsex2=mysql_fetch_array($resultex2))
				 {
					 $class_fees = $rowsex2['class_fees'];
					 $summingcompulsaryfees = $summingcompulsaryfees + $class_fees;
				 }
				 $fees_balance = $summingcompulsaryfees - $fees_paid;
				 /*END of Checking for class fees of the class for the term selected*/
			 }
			 
			 /*This is where you would enter the posted fields into a database*/
			 $query = "INSERT INTO schoolfees 
			 VALUES('$schoolfees_id', '$priority', '$student_id', '$class_id', '$bank_slip_number', '$fees_paid',
			 '$fees_balance', '$academic_term_id', now(), '$user_id', '$status', '')";
							 
			 queryMysql($query);
		 }
		 else if($priority == 'Optional')
		 {
			 
			 /*Checking for maximum schol fees paid*/
			 $queryex1 = "SELECT MAX(schoolfees_id) FROM schoolfees WHERE student_id = '$student_id' AND academic_term_id = '$academic_term_id'
			 AND class_id = '$class_id' AND priority = '$priority'";
			 $resultex1 = mysql_query($queryex1);
			 if(!$resultex1) die("DB access failed(derro internal error): " . mysql_error());
			 $rowsex1 = mysql_num_rows($resultex1);
			 for ($jex1 = 0 ; $jex1 < $rowsex1 ; ++$jex1)
			 {
				 $rowex1 = mysql_fetch_row($resultex1);
				 $schoolfees_id_ref = $rowex1[0];
				 
				 /*Checking for last fees balance*/
				 $queryex = "SELECT fees_balance FROM schoolfees WHERE schoolfees_id = '$schoolfees_id_ref'";
				 $resultex = mysql_query($queryex);
				 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
				 $rowsex = mysql_num_rows($resultex);
				 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
				 {
					 $rowex = mysql_fetch_row($resultex);
					 $latest_fees_balance = $rowex[0];
					 $fees_balance = $latest_fees_balance - $fees_paid ;
				 }
				 /*END of Checking for last fees balance*/
				 
			 }
			 /*END of Checking for maximum schol fees paid*/
			 if($schoolfees_id_ref == null){
				 /*Checking for class fees of the class for the term selected*/
				 $queryex2 = "SELECT class_fees FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id' 
				 AND priority = '$priority'";
				 $resultex2 = mysql_query($queryex2);
				 if(!$resultex2) die("DB access failed(derro internal error): " . mysql_error());
				 $rowsex2 = mysql_num_rows($resultex2);
				 
				 $summingcompulsaryfees = 0;
				 while($rowsex2=mysql_fetch_array($resultex2))
				 {
					 $class_fees = $rowsex2['class_fees'];
					 $summingcompulsaryfees = $summingcompulsaryfees + $class_fees;
				 }
				 $fees_balance = $summingcompulsaryfees - $fees_paid;
				 /*END of Checking for class fees of the class for the term selected*/
			 }
			 
			 /*This is where you would enter the posted fields into a database*/
			 $query = "INSERT INTO schoolfees 
			 VALUES('$schoolfees_id', '$priority', '$student_id', '$class_id', '$bank_slip_number', '$fees_paid',
			 '$fees_balance', '$academic_term_id', now(), '$user_id', '$status', '')";
							 
			 queryMysql($query);
		 }
		 
	 }
	 else if($action == "allocatepayment"){
		 $query1 = "SELECT MAX(schoolfees_id) FROM schoolfees";
		 $result = mysql_query($query1);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $row = mysql_fetch_row($result);
		 
		 $schoolfees_id = $row[0]+1;
		 
		 $schoolclassfees_id = $_POST["schoolclassfees_id"];
		 $student_id = $_POST["student_id"];
		 $class_id = $_POST["class_id"];
		 $bank_slip_number = $_POST["bank_slip_number"];
		 $bank_slip_number = sanitizeString($bank_slip_number);
		 $fees_paid = $_POST["fees_paid"];
		 $fees_paid = sanitizeString($fees_paid);
		 
		 $academic_term_id = $_POST["academic_term_id"];
		 $user_id = $_POST["user_id"];
		 $status = "RECIEVE";
		 
		 
		 /*Checking for class alias*/
		 $queryex = "SELECT MAX(schoolfees_id) FROM schoolfees WHERE student_id = '$student_id' AND academic_term_id = '$academic_term_id'
		 AND class_id = '$class_id' AND schoolclassfees_id = '$schoolclassfees_id'";
		 $resultex = mysql_query($queryex);
		 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsex = mysql_num_rows($resultex);
		 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
		 {
			 $rowex = mysql_fetch_row($resultex);
			 $schoolfees_id_ref = $rowex[0];
			 
			 /*Checking for class alias*/
			 $queryex = "SELECT fees_balance FROM schoolfees WHERE schoolfees_id = '$schoolfees_id_ref'";
			 $resultex = mysql_query($queryex);
			 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
			 $rowsex = mysql_num_rows($resultex);
			 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
			 {
				 $rowex = mysql_fetch_row($resultex);
				 $latest_fees_balance = $rowex[0];
				 $fees_balance = $latest_fees_balance - $fees_paid ;
			 }
			 /*END of Checking for class alias*/
			 
		 }
		 /*END of Checking for class alias*/
		 if($rowsex == 0){
			 /*Checking for class alias*/
			 $queryex2 = "SELECT class_fees FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id' 
			 AND schoolclassfees_id = '$schoolclassfees_id'";
			 $resultex2 = mysql_query($queryex2);
			 if(!$resultex2) die("DB access failed(derro internal error): " . mysql_error());
			 $rowsex2 = mysql_num_rows($resultex2);
			 for ($jex2 = 0 ; $jex2 < $rowsex2 ; ++$jex2)
			 {
				 $rowex2 = mysql_fetch_row($resultex2);
				 $paid_class_fees = $rowex2[0];
				 $fees_balance = $paid_class_fees - $fees_paid; 
			 }
			 /*END of Checking for class alias*/
		 }
		 
		 
		 /*This is where you would enter the posted fields into a database*/
		 $query = "INSERT INTO schoolfees 
		 VALUES('$schoolfees_id', '$schoolclassfees_id', '$student_id', '$class_id', '$bank_slip_number', '$fees_paid',
		 '$fees_balance', '$academic_term_id', now(), '$user_id', '$status', '')";
		 
		 queryMysql($query);
		 
		 
		 /*Second Insertion*/
		 $queryee = "SELECT MAX(schoolfees_id) FROM schoolfees";
		 $resultee = mysql_query($queryee);
		 if(!$resultee) die("DB access failed(derro internal error): " . mysql_error());
		 $rowee = mysql_fetch_row($resultee);
		 
		 $schoolfees_idee = $rowee[0]+1;
		 
		 $schoolclassfees_id_picked_from = $_POST["schoolclassfees_id_picked_from"];
		 $status2 = "TRANSFER";
		 
		 $query2 = "INSERT INTO schoolfees
		 VALUES('$schoolfees_idee', '$schoolclassfees_id_picked_from', '$student_id', '$class_id', '-', '-$fees_paid',
		 '0', '$academic_term_id', now(), '$user_id', '$status2', '')";
		 
		 queryMysql($query2);
	 }
	 else if($action == "showpaymentdetails"){
		 $student_id = $_POST["student_id"];
		 $class_id = $_POST["class_id"];
		 $admission_academic_term_id = $_POST["admission_academic_term_id"];
		 
		 echo "<h3>PAYMENT DETAILS - COMPULSARY</h3>";
		 
		 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
				 <span style=\"width:100px;\"><b>PAYMENT ID</b></span>
				 <span style=\"width:150px;\"><b>PRIORITY</b></span>
				 <span style=\"width:100px;\"><b>BANK SLIP</b></span>
				 <span style=\"width:110px;\"><b>PAID</b></span>
				 <span style=\"width:110px;\"><b>BALANCE</b></span>
				 <span style=\"width:120px;\"><b>PAYMENT DATE</b></span>
				 <span style=\"width:100px;\"><b>USER ID</b></span>
				 <span style=\"width:90px;\"><b>STATUS</b></span>
				 </p>";
							 
		 $query = "SELECT * FROM schoolfees WHERE student_id = '$student_id' AND academic_term_id = '$admission_academic_term_id'
			 AND class_id = '$class_id' ORDER BY schoolfees_id ASC";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 
		 $feespaidcount = 0;
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
			 
			 if ($priority == 'Compulsary')
			 {
				 /*Checking for user*/
				 $queryex = "SELECT username FROM users WHERE user_id = '$user_id'";
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
						<span style=\"width:150px;\">$priority</span>
						<span style=\"width:100px;\">$bank_slip_number</span>
						<span style=\"width:110px;\">$fees_paid</span>
						<span style=\"width:110px;\">$fees_balance</span>
						<span style=\"width:120px;\">$payment_date</span>
						<span style=\"width:100px;\">$username</span>
						<span style=\"width:90px;\">$status</span>";
				 /*Checking for the maximum record*/
				 $querychk = "SELECT MAX(schoolfees_id) FROM schoolfees WHERE student_id = '$student_id' AND academic_term_id = '$admission_academic_term_id'
				 AND class_id = '$class_id' AND priority = '$priority'";
				 $resultchk = mysql_query($querychk);
				 if(!$resultchk) die("DB access failed(derro internal error): " . mysql_error());
				 $rowschk = mysql_num_rows($resultchk);
				 for ($jchk = 0 ; $jchk < $rowschk ; ++$jchk)
				 {
					 $rowchk = mysql_fetch_row($resultchk);
					 $max_row = $rowchk[0];
				 }
				 /*END of Checking for the maximum record*/
				 
				 if (($schoolfees_id == $max_row) && ($status == 'Pending'))
				 {
					 echo "<span style=\"width:50px;\">
							 <input type=\"button\" class=\"deletepaymentbutton\" onclick=\"deleteFeesPayment($student_id,$class_id,$admission_academic_term_id,$schoolfees_id)\" value=\"Delete\">
						 </span>";
				 }

				 echo "</li>";
				 /*Counting fees paid*/
				 $feespaidcount = $feespaidcount + $fees_paid;
			 }
			 
		 }
         echo "</ul>";
		 
		 echo "<div id=\"declaration\">";
		     
			  /*Checking for old term balance*/
			 $queryexold111 = "SELECT academic_term_id FROM classenrolled WHERE student_id = '$student_id' AND class_id = '$class_id'";
				 $resultexold111 = mysql_query($queryexold111);
				 if(!$resultexold111) die("DB access failed(derro internal error): " . mysql_error());
				 
				 $rowsexold111 = mysql_num_rows($resultexold111);
				 
				 $old_fees_balance = 0;$totalwaiversum = 0;
				 while($rowexold111=mysql_fetch_array($resultexold111))
			     {
					 $old_term_id = $rowexold111['academic_term_id'];
					 
					 if ($old_term_id <= $admission_academic_term_id) /*if the term is less*/
					 {
						 /*Checking for fee waiver of term*/
						 $queryexoldwaiver = "SELECT fee_waiver_percentage FROM fee_waiver WHERE academic_term_id = '$old_term_id'
						 AND student_id = '$student_id'";
						 $resultexoldwaiver = mysql_query($queryexoldwaiver);
						 if(!$resultexoldwaiver) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsexoldwaiver = mysql_num_rows($resultexoldwaiver);
						 for ($jexoldwaiver = 0 ; $jexoldwaiver < $rowsexoldwaiver; ++$jexoldwaiver)
						 {
							 $rowexoldwaiver = mysql_fetch_row($resultexoldwaiver);
							 $fee_waiver_percentage = $rowexoldwaiver[0];
							 $waiverdivided = $fee_waiver_percentage / 100;
						 }
						 if($rowsexoldwaiver == null){
							 /*Do nothing*/
						 } else {
							 /*getting to know fee for class so we can calulate the waiver*/
							 $queryexold11waiversum = "SELECT class_fees FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$old_term_id'
							 AND priority = 'Compulsary'";
							 $resultexold11waiversum = mysql_query($queryexold11waiversum);
							 if(!$resultexold11waiversum) die("DB access failed(derro internal error): " . mysql_error());
							 $rowsexold11waiversum = mysql_num_rows($resultexold11waiversum);
							 for ($jexold11waiversum = 0 ; $jexold11waiversum < $rowsexold11waiversum; ++$jexold11waiversum)
							 {
								 $rowexold11waiversum = mysql_fetch_row($resultexold11waiversum);
								 $class_fees_to_calculate_waiver = $rowexold11waiversum[0];
								 $waiversum = $waiverdivided * $class_fees_to_calculate_waiver;
								 $totalwaiversum = $totalwaiversum + $waiversum;
							 }
						 }
						 /*End of checking for fee waiver of term*/
					 }
					 
					 
					 if ($old_term_id < $admission_academic_term_id) /*if the term is less*/
					 {
						 
						 $queryexold = "SELECT MAX(schoolfees_id) FROM schoolfees WHERE student_id = '$student_id' 
						 AND academic_term_id = '$old_term_id' AND class_id = '$class_id' AND priority = 'Compulsary'";
						 $resultexold = mysql_query($queryexold);
						 if(!$resultexold) die("DB access failed(derro internal error): " . mysql_error());
						 
						 $rowsexold = mysql_num_rows($resultexold);
						 
						 for ($jexold = 0 ; $jexold < $rowsexold; ++$jexold)
						 {
							 $rowexold = mysql_fetch_row($resultexold);
							 $schoolfees_id = $rowexold[0];
								 
							 $queryexold1 = "SELECT fees_balance FROM schoolfees WHERE schoolfees_id = '$schoolfees_id'";
							 $resultexold1 = mysql_query($queryexold1);
							 if(!$resultexold1) die("DB access failed(derro internal error): " . mysql_error());
							 $rowsexold1 = mysql_num_rows($resultexold1);
							 for ($jexold1 = 0 ; $jexold1 < $rowsexold1; ++$jexold1)
							 {
								 $rowexold1 = mysql_fetch_row($resultexold1);
								 $old_fees_balance_got = $rowexold1[0];
								 $old_fees_balance  = $old_fees_balance + $old_fees_balance_got;
							 }
						 }
						 if($schoolfees_id == null){ /*if there is no payment at all in that term*/
							 $queryexold11 = "SELECT class_fees FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$old_term_id'
							 AND priority = 'Compulsary'";
							 $resultexold11 = mysql_query($queryexold11);
							 if(!$resultexold11) die("DB access failed(derro internal error): " . mysql_error());
							 $rowsexold11 = mysql_num_rows($resultexold11);
							 for ($jexold11 = 0 ; $jexold11 < $rowsexold11; ++$jexold11)
							 {
								 $rowexold11 = mysql_fetch_row($resultexold11);
								 $class_fees = $rowexold11[0];
								 $old_fees_balance = $old_fees_balance + $class_fees;
							 }
						 }
					 }
					 
			     }
				 
			 /*End of Checking for old term balance*/
			 
			 $query = "SELECT * FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$admission_academic_term_id'
			 AND priority = 'Compulsary'";
			 $result = mysql_query($query);
			 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
			 $rows = mysql_num_rows($result);
			 
			 $sum = 0;
			 while($row=mysql_fetch_array($result))
			 {
				 $fee_name = $row['fee_name'];
				 $class_fees = $row['class_fees'];
				 $priority = $row['priority'];
				 
				 $sum = $sum + $class_fees;
			 }
			 
			 $sum2 = 0;
			 /*Checking for compulsary class fees*/
			 $queryex = "SELECT class_fees FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$admission_academic_term_id'
			 AND priority = 'Compulsary'";
			 $resultex = mysql_query($queryex);
			 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
			 $rowsex = mysql_num_rows($resultex);
			 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
			 {
				 $rowex = mysql_fetch_row($resultex);
				 $class_fees = $rowex[0];
				 $sum2 = $sum2 + $class_fees;
			 }
			 if ($rowsex == 0){
				 echo "<h3>QUICK COMPULSARY SUMMARY (TERM-WISE)</h3>";
				 echo "<p><b style=\"width:210px;display:inline-block;vertical-align:top;\">OLD BALANCE: $old_fees_balance</b>";
				 echo "<b style=\"width:270px;display:inline-block;vertical-align:top;\">AMOUNT TO BE PAID: $sum2</b>";
				 echo "<b style=\"width:150px;display:inline-block;vertical-align:top;\">PAID: $feespaidcount</b>";
				 echo "<b style=\"width:150px;display:inline-block;vertical-align:top;\">TOTAL WAIVER: $totalwaiversum</b>";
				 $finalbalance = $sum2 - $feespaidcount;
				 $finalbalance = $finalbalance + $old_fees_balance;
				 $finalbalance = $finalbalance - $totalwaiversum;
				 echo "<b style=\"width:220px;display:inline-block;vertical-align:top;\">TOTAL BALANCE: $finalbalance</b></p><br>
				 <p style=\"color:red;padding:10px;font-size:13px;\">New payments for old terms should be paid in their respective terms for easier tracking</p>";
			 }
			 else {
				 echo "<h3>QUICK COMPULSARY SUMMARY (TERM-WISE)</h3>";
				 echo "<p><b style=\"width:210px;display:inline-block;vertical-align:top;\">OLD BALANCE: $old_fees_balance</b>";
				 echo "<b style=\"width:270px;display:inline-block;vertical-align:top;\">AMOUNT TO BE PAID: $sum</b>";
				 echo "<b style=\"width:150px;display:inline-block;vertical-align:top;\">PAID: $feespaidcount</b>";
				 echo "<b style=\"width:150px;display:inline-block;vertical-align:top;\">TOTAL WAIVER: $totalwaiversum</b>";
				 $finalbalance = $sum - $feespaidcount;
				 $finalbalance = $finalbalance + $old_fees_balance;
				 $finalbalance = $finalbalance - $totalwaiversum;
				 echo "<b style=\"width:220px;display:inline-block;vetical-align:top;\">TOTAL BALANCE: $finalbalance</b></p><br>
				 <p style=\"color:red;padding:10px;font-size:13px;\">New payments for old terms should be paid in their respective terms for easier tracking</p>";
			 }
			 
		 echo "</div>";
		
		 /*Optional payments*/
		 echo "<h3>PAYMENT DETAILS - OPTIONAL</h3>";
		 
		 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
				 <span style=\"width:100px;\"><b>PAYMENT ID</b></span>
				 <span style=\"width:150px;\"><b>PRIORITY</b></span>
				 <span style=\"width:100px;\"><b>BANK SLIP</b></span>
				 <span style=\"width:110px;\"><b>PAID</b></span>
				 <span style=\"width:110px;\"><b>BALANCE</b></span>
				 <span style=\"width:120px;\"><b>PAYMENT DATE</b></span>
				 <span style=\"width:100px;\"><b>USER ID</b></span>
				 <span style=\"width:90px;\"><b>STATUS</b></span>
				 </p>";
							 
		 $queryo = "SELECT * FROM schoolfees WHERE student_id = '$student_id' AND academic_term_id = '$admission_academic_term_id'
			 AND class_id = '$class_id' ORDER BY schoolfees_id ASC";
		 $resulto = mysql_query($queryo);
		 if(!$resulto) die("DB access failed(derro internal error): " . mysql_error());
		 
		 $feespaidcountoptional = 0;
		 echo "<ul>";
		 while($row=mysql_fetch_array($resulto))
		 {
			 $schoolfees_idm = $row['schoolfees_id'];
			 $prioritym = $row['priority'];
			 $bank_slip_numberm = $row['bank_slip_number'];
			 $fees_paidm = $row['fees_paid'];
			 $fees_balancem = $row['fees_balance'];
			 $payment_datem = $row['payment_date'];
			 $user_idm = $row['user_id'];
			 $statusm = $row['status'];
			 
			 if ($prioritym == 'Optional')
			 {
				 /*Checking for user*/
				 $queryex = "SELECT username FROM users WHERE user_id = '$user_idm'";
				 $resultex = mysql_query($queryex);
				 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
				 $rowsex = mysql_num_rows($resultex);
				 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
				 {
					 $rowex = mysql_fetch_row($resultex);
					 $usernamem = $rowex[0];
				 }
				 /*END of Checking for user*/
				
				 echo "<li>
						<span style=\"width:100px;\">$schoolfees_idm</span>
						<span style=\"width:150px;\">$prioritym</span>
						<span style=\"width:100px;\">$bank_slip_numberm</span>
						<span style=\"width:110px;\">$fees_paidm</span>
						<span style=\"width:110px;\">$fees_balancem</span>
						<span style=\"width:120px;\">$payment_datem</span>
						<span style=\"width:100px;\">$usernamem</span>
						<span style=\"width:90px;\">$statusm</span>";
				 /*Checking for the maximum record*/
				 $querychko = "SELECT MAX(schoolfees_id) FROM schoolfees WHERE student_id = '$student_id' AND academic_term_id = '$admission_academic_term_id'
				 AND class_id = '$class_id' AND priority = '$prioritym'";
				 $resultchko = mysql_query($querychko);
				 if(!$resultchko) die("DB access failed(derro internal error): " . mysql_error());
				 $rowschk = mysql_num_rows($resultchko);
				 for ($jchk = 0 ; $jchk < $rowschk ; ++$jchk)
				 {
					 $rowchk = mysql_fetch_row($resultchko);
					 $max_row = $rowchk[0];
				 }
				 /*END of Checking for the maximum record*/
				 
				 if (($schoolfees_idm == $max_row) && ($status == 'Pending'))
				 {
					 echo "<span style=\"width:50px;\">
							 <input type=\"button\" class=\"deletepaymentbutton\" onclick=\"deleteFeesPayment($student_id,$class_id,$admission_academic_term_id,$schoolfees_id)\" value=\"Delete\">
						 </span>";
				 }

				 echo "</li>";
				 /*Counting fees paid for optional*/
			     $feespaidcountoptional = $feespaidcountoptional + $fees_paidm;
			 }
			 
		 }
        echo "</ul>";	
		  echo "<div id=\"declaration\">";
			 
			 $querym = "SELECT * FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$admission_academic_term_id'
							 AND priority = 'Optional'";
							 $resultm = mysql_query($querym);
							 if(!$resultm) die("DB access failed(derro internal error): " . mysql_error());
							 $rowsm = mysql_num_rows($resultm);
							 
							 $summ = 0;
								 while($row=mysql_fetch_array($resultm))
								 {
									 $fee_namem = $row['fee_name'];
									 $class_feesm = $row['class_fees'];
									 $prioritym = $row['priority'];
									 
									 $summ = $summ + $class_feesm;
								 }
								 $summ2 = 0;
								 /*Checking for optional class fees*/
								 $queryexm = "SELECT class_fees FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$admission_academic_term_id'
								 AND priority = 'Optional'";
								 $resultexm = mysql_query($queryexm);
								 if(!$resultexm) die("DB access failed(derro internal error): " . mysql_error());
							     $rowsexm = mysql_num_rows($resultexm);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowexm = mysql_fetch_row($resultexm);
									 $class_feesm = $rowexm[0];
								     $summ2 = $summ2 + $class_feesm;
								 }
								 if ($rowsexm == 0){
									 echo "<h3>QUICK OPTIONAL SUMMARY (TERM-WISE)</h3>";
									 echo "<p><b style=\"width:270px;display:inline-block;\">AMOUNT TO BE PAID: $summ2</b>";
									 echo "<b style=\"width:150px;display:inline-block;\">PAID: $feespaidcountoptional</b>";
									 $finalbalancem = $summ2 - $feespaidcountoptional;
									 echo "<b style=\"width:150px;display:inline-block;\">BALANCE: $finalbalancem</b></p>";
								 }
								 else {
									 echo "<h3>QUICK OPTIONAL SUMMARY (TERM-WISE)</h3>";
									 echo "<p><b style=\"width:270px;display:inline-block;\">AMOUNT TO BE PAID: $summ</b>";
									 echo "<b style=\"width:150px;display:inline-block;\">PAID: $feespaidcountoptional</b>";
									 $finalbalancem = $summ - $feespaidcountoptional;
									 echo "<b style=\"width:150px;display:inline-block;\">BALANCE: $finalbalancem</b></p>";
								 }
			 
		 echo "</div>";
	 }
	 else if($action == "deletefeespayment"){
		 $schoolfees_id = $_POST["schoolfees_id"];
		 
		 $querylast = "SELECT * FROM schoolfees WHERE schoolfees_id = '$schoolfees_id'";
		 $resultlast = mysql_query($querylast);
		 if(!$resultlast) die("DB access failed(derro internal error): " . mysql_error());
		 $rowslast = mysql_num_rows($resultlast);
		 while($rowlast=mysql_fetch_array($resultlast))
		 {
			 $status = $rowlast['status'];
			 
		     if($status == 'TRANSFER')
			 {
				 $query = "DELETE FROM schoolfees WHERE schoolfees_id = '$schoolfees_id'";
		         queryMysql($query);
				 
				 $schoolfees_id_down = $schoolfees_id - 1;
				 $query2 = "DELETE FROM schoolfees WHERE schoolfees_id = '$schoolfees_id_down'";
		         queryMysql($query2);
			 } 
			 else if($status == 'RECIEVE'){
				 $query = "DELETE FROM schoolfees WHERE schoolfees_id = '$schoolfees_id'";
		         queryMysql($query);
				 
				 $schoolfees_id_up = $schoolfees_id + 1;
				 $query2 = "DELETE FROM schoolfees WHERE schoolfees_id = '$schoolfees_id_up'";
		         queryMysql($query2);
			 }
			 else {
				 $query = "DELETE FROM schoolfees WHERE schoolfees_id = '$schoolfees_id'";
		         queryMysql($query);
			 }
	     }
	 }
	 else if($action == "showfeesdetails"){
		 $student_id = $_POST["student_id"];
		 $class_id = $_POST["class_id"];
		 $academic_term_id = $_POST["academic_term_id"];
		 
		 /*Checking for student name*/
						 $queryex = "SELECT student_firstname, student_lastname  FROM schoolstudents WHERE student_id = '$student_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
						     $rowex = mysql_fetch_row($resultex);
							 $student_firstname = $rowex[0];
							 $student_lastname = $rowex[1];
						 }
					     /*END of Checking for student name*/
						 
						 /*Checking for class alias*/
						 $queryex = "SELECT class_alias FROM schoolclass WHERE class_id = '$class_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
						     $rowex = mysql_fetch_row($resultex);
							 $class_alias = $rowex[0];
						 }
					     /*END of Checking for class alias*/
						 
						 /*Checking for admission_date*/
						 $queryex = "SELECT academic_year,academic_term FROM schoolterm WHERE academic_term_id = '$academic_term_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $admission_year = $rowex[0];
							 $admission_term = $rowex[1];
						 }
						 /*END of Checking for admission_date*/
						 
						 echo "<div id=\"fees-student-box\">
						     <h3>STUDENT DETAILS</h3>
							 <p>NAME: <b>$student_firstname $student_lastname</b></p>
							 <p>CLASS: <b>$class_alias</b></p>
							 <p>TERM: <b>$admission_year - $admission_term</b></p>
							 ";
						     
						 echo "</div>";
						 
						 echo "<div id=\"fees-box\">
						 <h3>COMPULSARY TERM FEES</h3>";
							 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
							 <!--<span style=\"width:80px;\"><b>FEE ID</b></span>-->
							 <span style=\"width:160px;\"><b>FEE NAME</b></span>
							 <span style=\"width:120px;\"><b>FEE AMOUNT</b></span>
							 <!--<span style=\"width:120px;\"><b>PRIORITY</b></span>-->
							 
							 </p>";
							 
							 $query = "SELECT * FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id'
							 AND priority = 'Compulsary'";
							 $result = mysql_query($query);
							 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
							 $rows = mysql_num_rows($result);
							 
							 $sum = 0;
							 echo "<ul>";
								 while($row=mysql_fetch_array($result))
								 {
									 $fee_name = $row['fee_name'];
									 $class_fees = $row['class_fees'];
									 $priority = $row['priority'];
									 
									 $sum = $sum + $class_fees;
									echo "<li>
											<span style=\"width:160px;\">$fee_name</span>
											<span style=\"width:120px;\">$class_fees</span>
											<!--<span style=\"width:120px;\">$priority</span>-->
									 </li>";
								 }
								 $sum2 = 0;
								 /*Checking for compulsary class fees*/
								 $queryex = "SELECT class_fees FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id'
								 AND priority = 'Compulsary'";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
							     $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $class_fees = $rowex[0];
								     $sum2 = $sum2 + $class_fees;
								 }
								 if ($rowsex == 0){
									 echo "<p style=\"width:350px;text-align:right;padding:10px;\">TOTAL COMPULSARY FEE: <b>$sum2</b></p>";
								 }
								 else {
									 echo "<p style=\"width:350px;text-align:right;padding:10px;\">TOTAL COMPULSARY FEE: <b>$sum2</b></p>";
								 }
								 
							 echo "</ul>";
							 
						 echo "</div>";
						 
						 echo "<div id=\"fees-box\">
						 <h3>OPTIONAL TERM FEES</h3>";
							 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
							 <!--<span style=\"width:80px;\"><b>FEE ID</b></span>-->
							 <span style=\"width:160px;\"><b>FEE NAME</b></span>
							 <span style=\"width:120px;\"><b>FEE AMOUNT</b></span>
							 <!--<span style=\"width:120px;\"><b>PRIORITY</b></span>-->
							 
							 </p>";
							 
							 $query = "SELECT * FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id'
							 AND priority = 'Optional'";
							 $result = mysql_query($query);
							 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
							 $rows = mysql_num_rows($result);
							 
							 $sum = 0;
							 echo "<ul>";
								 while($row=mysql_fetch_array($result))
								 {
									 $schoolclassfees_id = $row['schoolclassfees_id'];
									 $fee_name = $row['fee_name'];
									 $class_fees = $row['class_fees'];
									 $priority = $row['priority'];
									 
									 $sum = $sum + $class_fees;
									echo "<li>
											<!--<span style=\"width:80px;\">$schoolclassfees_id</span>-->
											<span style=\"width:160px;\">$fee_name</span>
											<span style=\"width:120px;\">$class_fees</span>
											<!--<span style=\"width:120px;\">$priority</span>-->
									 </li>";
								 }
								 $sum2 = 0;
								 /*Checking for compulsary class fees*/
								 $queryex = "SELECT class_fees FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id'
								 AND priority = 'Optional'";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
							     $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $class_fees = $rowex[0];
								     $sum2 = $sum2 + $class_fees;
								 }
								 if ($rowsex == 0){
									 echo "<p style=\"width:350px;text-align:right;padding:10px;\">TOTAL OPTIONAL FEE: <b>$sum2</b></p>";
								 }
								 else {
									 echo "<p style=\"width:350px;text-align:right;padding:10px;\">TOTAL OPTIONAL FEE: <b>$sum2</b></p>";
								 }
								 
							 echo "</ul>";
							 
						 echo "</div>";
						 
						 
						 echo "<div id=\"list-payments\"><p>No results</p></div>";
						 
						 
						 echo "<div id=\"make-payment\">
						  <h3>MAKE PAYMENT</h3>";
						  
						 echo "<p><b>Priority:</b> <br><select id=\"priority\" name=\"priority\"><option value=\"0\">- Select Priority -</option>";
							 echo "<option value=\"Compulsary\">Compulsary</option>";
							 echo "<option value=\"Optional\">Optional</option>";
						 echo "</select><p>";
						  
						 echo "<p><b>Bank Slip Number:</b> <br><input type=\"text\" id=\"bank_slip_number\" placeholder=\"Bank Slip Number\"></p>
						  <p><b>Amount paid:</b> <br><input type=\"text\" id=\"fees_paid\" placeholder=\"Ammount Paid\"></p>
						  <input type=\"button\" onclick=\"makePayment($student_id,$class_id,$academic_term_id,$sysuser_id)\" 
						  value=\"Make Payment\" style=\"background-color:green;color:#fff;border:solid 1px green;cursor:pointer;\">
						 </div>";
	 }
	 else if($action == "promotestudent"){
		 $student_id = $_POST["student_id"];
		 $class_id = $_POST["class_id"];
		 $sub_class_id = $_POST["sub_class_id"];
		 $term_id = $_POST["term_id"];
		 
		 /*Looking for number of class terms*/
		 $queryq = "SELECT number_of_terms FROM settings WHERE school_id = '1'";
		 $resultq = mysql_query($queryq);
		 if(!$resultq) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsq = mysql_num_rows($resultq);
		 for ($jq = 0 ; $jq < $rowsq ; ++$jq)
		 {
			 $rowq = mysql_fetch_row($resultq);
			 $number_of_terms = $rowq[0]; /*variable for button display*/
		 }
		 /*End of looking for number of class terms*/
		
		 $academic_term_id_for_increment = $term_id;
		 for ($start = 0; $start < $number_of_terms; ++$start){
			 $query22 = "SELECT MAX(classesenrolled_id) FROM classenrolled";
			 $result22 = mysql_query($query22);
			 if(!$result22) die("DB access failed(derro internal error): " . mysql_error());
			 $row22 = mysql_fetch_row($result22);
			 $classesenrolled_id = $row22[0]+1;
			 
			 $query222 = "INSERT INTO classenrolled VALUES('$classesenrolled_id', '$academic_term_id_for_increment', '$student_id','$class_id','$sub_class_id')";queryMysql($query222);
			 $academic_term_id_for_increment++;
		 }
		 
		 
		 $query = "UPDATE schoolstudents SET class_id = '$class_id' WHERE student_id = '$student_id';";queryMysql($query);
		 $query = "UPDATE schoolstudents SET sub_class_id = '$sub_class_id' WHERE student_id = '$student_id';";queryMysql($query);
	 }
	 else if($action == "depromotestudent"){
		 $student_id = $_POST["student_id"];
		 
		 /*finding out maximum class*/
		 $queryex = "SELECT MAX(class_id) FROM classenrolled WHERE student_id = '$student_id'";
		 $resultex = mysql_query($queryex);
		 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsex = mysql_num_rows($resultex);
		 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
		 {
			 $rowex = mysql_fetch_row($resultex);
			 $maxclass = $rowex[0];
		 }
		 /*END of finding out maximum claass*/
								 
		 $query = "DELETE FROM classenrolled WHERE student_id = '$student_id' AND class_id = '$maxclass'";
		 queryMysql($query);
		 
		 /*finding out maximum class the second time*/
		 $queryex = "SELECT MAX(class_id) FROM classenrolled WHERE student_id = '$student_id'";
		 $resultex = mysql_query($queryex);
		 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsex = mysql_num_rows($resultex);
		 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
		 {
			 $rowex = mysql_fetch_row($resultex);
			 $maxclass = $rowex[0];
		 }
		 /*END of finding out maximum claass*/
		 
		 $query = "UPDATE schoolstudents SET class_id = '$maxclass' WHERE student_id = '$student_id';";
		 queryMysql($query);
	 }
	 else if($action == "showstudentclasses"){
		 $student_id = $_POST["student_id"];
		 
		 echo "<input type=\"button\" value=\"Add Class\" style=\"padding:10px;background-color:skyblue;color:#fff;float:right;
			cursor:pointer;border:solid 1px skyblue;border-radius:3px;\" onclick=addClass()>";
		 echo "<h3>STUDENT CLASSES</h3>";
 
		 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
			 <span style=\"width:140px;\"><b>CLASS</b></span>
			 <span style=\"width:100px;\"><b>STREAM</b></span>
			 <span style=\"width:120px;\"><b>ADMS. TERM</b></span>
			 <span style=\"width:120px;\"><b>ACADEMICS</b></span>
			 <span style=\"width:150px;\"><b>FEES DETAILS</b></span>
			 </p>";
								 
			 /*finding out maximum class*/
			 $queryex = "SELECT MAX(class_id) FROM classenrolled WHERE student_id = '$student_id'";
			 $resultex = mysql_query($queryex);
			 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
			 $rowsex = mysql_num_rows($resultex);
			 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
			 {
				 $rowex = mysql_fetch_row($resultex);
				 $maxclass = $rowex[0];
			 }
			 /*END of finding out maximum claass*/
								 
			 $query = "SELECT * FROM classenrolled WHERE student_id = '$student_id' ORDER BY class_id DESC";
			 $result = mysql_query($query);
			 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
			
			 echo "<ul>";$alreadydisplayed = "No";
			 while($row=mysql_fetch_array($result))
			 {
				 $academic_term_id = $row['academic_term_id'];
				 $class_id = $row['class_id'];
				 $sub_class_id = $row['sub_class_id'];
									     
				 /*Checking for class alias*/
				 $queryex = "SELECT class_alias FROM schoolclass WHERE class_id = '$class_id'";
				 $resultex = mysql_query($queryex);
				 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
				 $rowsex = mysql_num_rows($resultex);
				 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
				 {
					 $rowex = mysql_fetch_row($resultex);
					 $class_alias = $rowex[0];
				 }
				 /*END of Checking for class alias*/
				 
				 /*Checking for sub class alias*/
				 $queryex = "SELECT sub_class_alias FROM schoolsubclass WHERE sub_class_id = '$sub_class_id'";
				 $resultex = mysql_query($queryex);
				 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
				 $rowsex = mysql_num_rows($resultex);
				 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
				 {
					 $rowex = mysql_fetch_row($resultex);
					 $sub_class_alias = $rowex[0];
				 }
				 /*END of Checking for sub class alias*/
										 
				 /*Checking for admission_date*/
				 $queryex = "SELECT academic_year,academic_term FROM schoolterm WHERE academic_term_id = '$academic_term_id'";
				 $resultex = mysql_query($queryex);
				 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
				 $rowsex = mysql_num_rows($resultex);
				 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
				 {
					 $rowex = mysql_fetch_row($resultex);
					 $admission_year = $rowex[0];
					 $admission_term = $rowex[1];
				 }
				 if ($rowsex == 0){
					 $admission_year = "";
					 $admission_term = "";
				 }
				 /*END of Checking for admission_date*/
										 
				 echo "<li>
					 <span style=\"width:150px;color:#bc3226;font-weight:bold;\">$class_alias</span>
					 <span style=\"width:100px;color:#bc3226;font-weight:bold;\">$sub_class_alias</span>
					 <span style=\"width:100px;\">$admission_year - $admission_term</span>
					 <span style=\"width:130px;\">
					     <a href=\"academics.php?student_id=$student_id&class_id=$class_id&sub_class_id=$sub_class_id&admission_academic_term_id=$academic_term_id\"
							 style=\"padding:8px;background-color:skyblue;color:white;\">Academics</a>
					 </span>
					 <span style=\"width:120px;\">
						 <a href=\"feesdetails.php?student_id=$student_id&class_id=$class_id&admission_academic_term_id=$academic_term_id\"
							 style=\"padding:8px;background-color:#456784;color:white;width:80px;\">Fees</a>
					 </span>";
											 
					 /*CHECKING MAXIMUM CLASS*/
					 if(($class_id == $maxclass) && ($alreadydisplayed == "No"))
					 {
						 $alreadydisplayed = "Yes";
						 $id = "1232$class_id";
						 echo " <span><select id=\"$id\">";
						 $querylast = "SELECT * FROM schoolclass";
						 $resultlast = mysql_query($querylast);
						 if(!$resultlast) die("DB access failed(derro internal error): " . mysql_error());
						 $rowslast = mysql_num_rows($resultlast);
						 while($rowlast=mysql_fetch_array($resultlast))
						 {
							 $class_id_check = $rowlast['class_id'];
							 $class_alias = $rowlast['class_alias'];
													 
							 if(($class_id_check == $class_id) || ($class_id_check < $class_id))
							 {
								 /*Do nothing*/
							 } else {
								 echo "<option value=\"$class_id_check\">$class_alias</option>:";
							 }
						 }
						 echo "</select></span>";
						 
						 
						 echo " <span><select id=\"subclassid\">";
						 $querylast = "SELECT * FROM schoolsubclass WHERE class_id = '$class_id'";
						 $resultlast = mysql_query($querylast);
						 if(!$resultlast) die("DB access failed(derro internal error): " . mysql_error());
						 $rowslast = mysql_num_rows($resultlast);
						 while($rowlast=mysql_fetch_array($resultlast))
						 {
							 $sub_class_id = $rowlast['sub_class_id'];
							 $sub_class_alias = $rowlast['sub_class_alias']; 
													 
							 echo "<option value=\"$sub_class_id\">$sub_class_alias</option>:";
						 }
						 echo "</select></span>";
												 
						 $id2 = "12333$class_id";
						 echo " <span><select id=\"$id2\" style=\"width:100px;\"> <option value=\"\">-Select Term-</option>";
						 $querylast = "SELECT academic_term_id, academic_term, academic_year FROM schoolterm ORDER BY academic_term_id DESC";
						 $resultlast = mysql_query($querylast);
						 if(!$resultlast) die("DB access failed(derro internal error): " . mysql_error());
						 $rowslast = mysql_num_rows($resultlast);
						 while($rowlast=mysql_fetch_array($resultlast))
						 {
							 $academic_term_id_check = $rowlast['academic_term_id'];
							 $academic_term_check = $rowlast['academic_term'];
							 $academic_year_check = $rowlast['academic_year'];
													 
							 if(($academic_term_id_check == $academic_term_id) || ($academic_term_id_check < $academic_term_id))
							 {
								 /*Do nothing*/
							 } else {
								 if($academic_term_check == 1) /*Check if academic_term_check is equal to one because its the starting semester*/
								     echo "<option value=\"$academic_term_id_check\">$academic_year_check - $academic_term_check</option>:";
							 }
						 }
						 echo "</select></span>
							 <span style=\"width:100px;\"><input type=\"button\" value=\"Promote\" style=\"width:80px;padding:5px;background-color:green;color:#fff;border:solid 1px green;cursor:pointer;\"
									 onclick=promoteStudent($student_id,$id,$id2)></span>
							 <span style=\"width:100px;\"><input type=\"button\" value=\"De-promote\" style=\"width:80px;padding:5px;background-color:#bc3226;color:#fff;border:solid 1px #bc3226;cursor:pointer;\"
									 onclick=dePromoteStudent($student_id)></span>";
					 } else {
						 /*Dont display anyhting*/
					 }
					 /*END OF CHECKING MAXIMUM CLASS*/
			     echo "</li>";
			 }
		 echo "</ul>";
	 }
	 else if($action == "deletestudentphoto"){
		 $student_id = $_POST["student_id"];
		 $photo = $_POST["photo"];
		 
		 $photo = $_POST['photo'];
		 if(file_exists($photo)) {
			 unlink($photo);
			 echo 'File '.$photo.' has been deleted';
			 $query = "UPDATE schoolstudents SET photo = 'default' WHERE student_id = '$student_id';";
			 queryMysql($query);
		 } else {
			 echo 'Could not delete '.$photo.', file does not exist';
		 }
	 }
	 else if($action == "deletestudent"){
		 $student_id = $_POST["student_id"];
		 $photo = $_POST['photo'];
		 
		 $query = "DELETE FROM fee_waiver WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "DELETE FROM studentmarks WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "DELETE FROM classenrolled WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "DELETE FROM schoolfees WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "DELETE FROM studentparent WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "DELETE FROM student_behaviour WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "DELETE FROM rolebystudent WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "DELETE FROM schoolstudents WHERE student_id = '$student_id'";queryMysql($query);

		 if(file_exists($photo)) {
			 unlink($photo);
			 echo 'File '.$photo.' has been deleted';
		 } else {
			 echo 'Could not delete '.$photo.', file does not exist';
		 }
	 }
     else if($action == "savestudentdata"){

		 $admission_number = $_POST["admission_number"];$admission_number = sanitizeString($admission_number);
		 $student_firstname = $_POST["student_firstname"];$student_firstname = sanitizeString($student_firstname);$student_firstname = string_to_uppecase($student_firstname);
		 $student_lastname = $_POST["student_lastname"];$student_lastname = sanitizeString($student_lastname);$student_lastname = string_to_uppecase($student_lastname);
		 $dateofbirth = $_POST["dateofbirth"];$dateofbirth = sanitizeString($dateofbirth);
		 $gender = $_POST["gender"];$gender = sanitizeString($gender);$gender = string_to_uppecase($gender);
		 $address = $_POST["address"];$address = sanitizeString($address);$address = string_to_uppecase($address);
		 $religion = $_POST["religion"];$religion = sanitizeString($religion);$religion = string_to_uppecase($religion);
		 $house_id = $_POST["house_id"];$house_id = sanitizeString($house_id);
		 $status = $_POST["status"];$status = sanitizeString($status);
		 $student_id = $_POST["student_id"];$student_id = sanitizeString($student_id);
		 
		 $query = "UPDATE schoolstudents SET admission_number = '$admission_number' WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "UPDATE schoolstudents SET student_firstname = '$student_firstname' WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "UPDATE schoolstudents SET student_lastname = '$student_lastname' WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "UPDATE schoolstudents SET dateofbirth = '$dateofbirth' WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "UPDATE schoolstudents SET gender = '$gender' WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "UPDATE schoolstudents SET address = '$address' WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "UPDATE schoolstudents SET religion = '$religion' WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "UPDATE schoolstudents SET house_id = '$house_id' WHERE student_id = '$student_id'";queryMysql($query);
		 $query = "UPDATE schoolstudents SET status = '$status' WHERE student_id = '$student_id'";queryMysql($query);
	 }
	 else if($action == "addstudentroledata"){
		 $student_roles_name = $_POST["student_roles_name"];$student_roles_name = sanitizeString($student_roles_name);$student_roles_name = string_to_uppecase($student_roles_name);
		 $description = $_POST["description"];$description = sanitizeString($description);
		 
		 $query1 = "SELECT MAX(student_roles_id) FROM student_roles";
		 $result = mysql_query($query1);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $row = mysql_fetch_row($result);
		 $student_roles_id = $row[0]+1;

		 $query2 = "INSERT INTO student_roles VALUES('$student_roles_id', '$student_roles_name', '$description')";
		 queryMysql($query2);
	 }
	 else if($action == "deletestudentrole"){
		 $student_roles_id = $_POST["student_roles_id"];
		 
		 $query = "DELETE FROM rolebystudent WHERE student_roles_id = '$student_roles_id'";queryMysql($query);
		 $query = "DELETE FROM student_roles WHERE student_roles_id = '$student_roles_id'";queryMysql($query);
	 }
	 else if($action == "deleteroleforstudent"){
		 $student_roles_id = $_POST["student_roles_id"];
		 $student_id = $_POST["student_id"];
		 $term_id = $_POST["term_id"];
		 
		 $query = "DELETE FROM rolebystudent WHERE student_roles_id = '$student_roles_id' AND student_id = '$student_id' 
		 AND academic_term_id = '$term_id'";
		 queryMysql($query);
	 }
	 else if($action == "addroletostudent"){
		 $student_roles_id = $_POST["student_roles_id"];
		 $student_id = $_POST["student_id"];
		 $addacademictermperiod = $_POST["addacademictermperiod"];
		 
		 /*Looking for number of class terms*/
		 $queryq = "SELECT number_of_terms FROM settings WHERE school_id = '1'";
		 $resultq = mysql_query($queryq);
		 if(!$resultq) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsq = mysql_num_rows($resultq);
		 for ($jq = 0 ; $jq < $rowsq ; ++$jq)
		 {
			 $rowq = mysql_fetch_row($resultq);
			 $number_of_terms = $rowq[0]; /*variable for button display*/
		 }
		 /*End of looking for number of class terms*/
		
		 $academic_term_id_for_increment = $addacademictermperiod;
		 for ($start = 0; $start < $number_of_terms; ++$start){
			 $query22 = "SELECT MAX(rolebystudent_id) FROM rolebystudent";
			 $result22 = mysql_query($query22);
			 if(!$result22) die("DB access failed(derro internal error): " . mysql_error());
			 $row22 = mysql_fetch_row($result22);
			 $rolebystudent_id = $row22[0]+1;
			 
			 $query222 = "INSERT INTO rolebystudent VALUES('$rolebystudent_id', '$student_id', '$student_roles_id','$academic_term_id_for_increment')";queryMysql($query222);
			 $academic_term_id_for_increment++;
		 }
		 
	 }
	 else if($action == "showsubclasspan"){
		 $class_id = $_POST["class_id"];
		 
		 $query = "SELECT sub_class_id,sub_class_alias FROM schoolsubclass WHERE class_id = '$class_id'";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
							 
		 echo "<p><b>STREAM:</b> <br><select id=\"addsubclassid\"><option value=\"NONE\">-Select Stream-</option>";
		 for ($j = 0 ; $j < $rows ; ++$j)
		 {
			 $row = mysql_fetch_row($result);
			 for ($k = 0 ; $k < 1 ; ++$k)
				 echo "<option value=\"$row[0]\">$row[1]</option>";
		 }
		 echo "</select></p>";
		 
	 }