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
     
	 
	 if($action == "showsubclasspan"){
		 $class_id = $_POST["class_id"];
		 
		 $queryex = "SELECT sub_class_id, sub_class_alias FROM schoolsubclass WHERE class_id = '$class_id' ORDER BY sub_class_id DESC";
		 $resultex = mysql_query($queryex);
		 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsex = mysql_num_rows($resultex);
								 
		 echo "<p><b>STREAM</b> <br> <select name=\"sub_class_id\"><option>- Select Stream -</option>";
		 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
		 {
			 $rowex = mysql_fetch_row($resultex);
			 $sub_class_id = $rowex[0];
			 $sub_class_alias = $rowex[1];
			 echo "<option value=$sub_class_id onclick=\"showSubjectPan($class_id, $sub_class_id)\">$sub_class_alias</option>";
		 }
		 echo "</select></p>";
	 }
	 if($action == "showsubjectpan"){
		 $class_id = $_POST["class_id"];
		 $sub_class_id = $_POST["sub_class_id"];
		 
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
		 
		 $queryex = "SELECT subject_id,subject_name FROM schoolsubjects WHERE classlevel_id = '$classlevel_id' AND class_category_id = '$class_category_id'";
		 $resultex = mysql_query($queryex);
		 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsex = mysql_num_rows($resultex);
		
		 echo "<p><b>SUBJECT</b> <br> <select name=\"subject_id\"><option>- Select Subject -</option>";
		 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
		 {
			 $rowex = mysql_fetch_row($resultex);
			 $subject_id = $rowex[0];
			 $subject_name = $rowex[1];
			 echo "<option value=$subject_id onclick=\"showAcademicTermPan($subject_id, $class_id, $sub_class_id, $sub_class_id)\">$subject_name</option>";
		 }
		 echo "</select></p>";
	 }
	 else if($action == "showacademictermpan"){
		 $subject_id = $_POST["subject_id"];
		 $class_id = $_POST["class_id"];
		 $sub_class_id = $_POST["sub_class_id"];
		 
		 $queryex = "SELECT academic_term_id, academic_year, academic_term FROM schoolterm ORDER BY academic_term_id DESC";
		 $resultex = mysql_query($queryex);
		 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsex = mysql_num_rows($resultex);
								 
		 echo "<p><b>ACADEMIC TERM</b> <br> <select name=\"academic_term_id\"><option>- Select Term -</option>";
		 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
		 {
			 $rowex = mysql_fetch_row($resultex);
			 $term_id = $rowex[0];
			 $academic_year = $rowex[1];
			 $academic_term = $rowex[2];
			 echo "<option value=$rowex[0] onclick=\"checkExamsForTerm2($subject_id, $class_id, $sub_class_id, $term_id)\">$academic_year - $academic_term</option>";
		 }
		 echo "</select></p>";
	 }
     else if($action == "checkexamsforterm2"){
		 $subject_id = $_POST["subject_id"];
		 $term_id = $_POST["term_id"];
		 $class_id = $_POST["class_id"];
		 $sub_class_id = $_POST["sub_class_id"];
		 
		 
		 $queryex = "SELECT exam_id, examtypes_id FROM exams WHERE academic_term_id = '$term_id' ORDER BY academic_term_id DESC";
		 $resultex = mysql_query($queryex);
		 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsex = mysql_num_rows($resultex);
		 
		 echo "<p><b>EXAMS IN THIS PERIOD</b> <br> <select name=\"academic_term_id\"><option>- Select Exam -</option>";
		 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
		 {
			 $rowex = mysql_fetch_row($resultex);
			 $exam_id = $rowex[0];
			 $examtypes_id = $rowex[1];
 
			 for ($kex = 0 ; $kex < 1 ; ++$kex)
			 /*Checking for exam_abreviation*/
			 $querytype = "SELECT exam_abreviation FROM examtypes WHERE examtypes_id = '$examtypes_id'";
			 $resulttype = mysql_query($querytype);
			 if(!$resulttype) die("DB access failed(derro internal error): " . mysql_error());
			 $rowstype = mysql_num_rows($resulttype);
			 for ($jtype = 0 ; $jtype < $rowstype ; ++$jtype)
			 {
				 $rowtype = mysql_fetch_row($resulttype);
				 $displayexamtype = $rowtype[0];
			 }
			 /*END of Checking for exam_abreviation*/
				 echo "<option value=$exam_id onclick=\"classMarks($subject_id, $exam_id, $class_id, $sub_class_id, $term_id)\">$displayexamtype</option>";
		 }
	     echo "</select></p>";
	 }
	 else if($action == "studentclassmarks"){
		 $subject_id = $_POST["subject_id"];
		 $exam_id = $_POST["exam_id"];
		 $class_id = $_POST["class_id"];
		 $sub_class_id = $_POST["sub_class_id"];
		 $term_id = $_POST["term_id"];
		 
		 /*Looking for subject details*/
		 $queryq = "SELECT number_of_papers FROM schoolsubjects WHERE subject_id = '$subject_id'";
		 $resultq = mysql_query($queryq);
		 if(!$resultq) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsq = mysql_num_rows($resultq);
							 
		 for ($jq = 0 ; $jq < $rowsq ; ++$jq)
		 {
			 $rowq = mysql_fetch_row($resultq);
			 $number_of_papers = $rowq[0]; /*variable for button display*/
		 }
		 /*End Looking for level of class*/
		 
		 /*Looking for students from class enrolled*/
		 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
			 <span style=\"width:200px;\"><b>STUDENT</b></span>
			 <span style=\"width:50px;\"><b>PAPER</b></span>
			 <span style=\"width:70px;\"><b>SCORE</b></span>
		     <span style=\"width:130px;\"><b>ACTION</b></span>
		     </p>";
			 
		 $queryqp = "SELECT student_id FROM classenrolled WHERE class_id = '$class_id' AND sub_class_id = '$sub_class_id' AND academic_term_id = '$term_id'";
		 $resultqp = mysql_query($queryqp);
		 if(!$resultqp) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsqp = mysql_num_rows($resultqp);
							 
		 for ($jqp = 0 ; $jqp < $rowsqp ; ++$jqp)
		 {
			 $rowqp = mysql_fetch_row($resultqp);
			 $student_id = $rowqp[0]; /*variable for button display*/
			 
			 
			 $query = "SELECT * FROM schoolstudents WHERE student_id = '$student_id' AND status = 'Active'";
			 $result = mysql_query($query);
			 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
			
			 echo "<ul>";
			 while($row=mysql_fetch_array($result))
			 {
				 $student_id = $row['student_id'];
				 $student_firstname = $row['student_firstname'];
				 $student_lastname = $row['student_lastname'];

				 //-display the result of the array
					 
				 echo "<li>
					 <span style=\"width:200px;font-size:16px;\"><b>$student_firstname $student_lastname</b></span>
					 
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
								 type=\"button\" value=\"Delete\" onclick=\"deleteSubjectClassMark($student_id,$class_id,$exam_id,$student_marks_id,$subject_id,$term_id)\">";
						 }
						 if ($rows1 == 0){
							 $id = "$student_id$subject_id$count$class_id$exam_id";
							 echo "<br><input style=\"width:50px;\" type=\"text\" id=\"$id\" value=\"\">
								 <input style=\"background-color:green;color:white;border:solid 1px green;cursor:pointer;\" 
								 type=\"button\" value=\"Add\" onclick=\"insertSubjectClassMark($student_id,$subject_id,$count,$class_id,$exam_id,$id,$term_id)\">";
						 }
					 }
					 echo "</span>";
					 
					 
				 echo "</li>";
			 }
		echo "</ul>";
		 }
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
	 else if($action == "promotestudent"){
		 $student_id = $_POST["student_id"];
		 $class_id = $_POST["class_id"];
		 $academic_term_id = $_POST["academic_term_id"];
		 
		 $query1 = "SELECT MAX(classesenrolled_id) FROM classenrolled";
		 $result = mysql_query($query1);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $row = mysql_fetch_row($result);
		 $classesenrolled_id = $row[0]+1;
		 
		 $query = "INSERT INTO classenrolled VALUES('$classesenrolled_id', '$academic_term_id', '$student_id', '$class_id')";
		 queryMysql($query);
		 
		 $query = "UPDATE schoolstudents SET class_id = '$class_id' WHERE student_id = '$student_id';";
		 queryMysql($query);
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
								 
		 $query = "DELETE FROM classenrolled WHERE student_id = '$student_id' AND class_id = $maxclass";
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
								 cursor:pointer;border:solid 1px skyblue;border-radius:3px;\">";
		 echo "<h2>STUDENT CLASSES</h2>";
 
		 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
			 <span style=\"width:140px;\"><b>CLASS</b></span>
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
			
			 echo "<ul>";
			 while($row=mysql_fetch_array($result))
			 {
				 $academic_term_id = $row['academic_term_id'];
				 $class_id = $row['class_id'];
									     
				 /*Checking for admission_date*/
				 $queryex = "SELECT class_alias FROM schoolclass WHERE class_id = '$class_id'";
				 $resultex = mysql_query($queryex);
				 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
				 $rowsex = mysql_num_rows($resultex);
				 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
				 {
					 $rowex = mysql_fetch_row($resultex);
					 $class_alias = $rowex[0];
				 }
				 /*END of Checking for admission_date*/
										 
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
					 <span style=\"width:150px;color:#bc3226;font-weight:bold;\">$class_alias</span>
					 <span style=\"width:100px;\">$admission_year - $admission_term</span>
					 <span style=\"width:130px;\">
					     <a href=\"academics.php?student_id=$student_id&class_id=$class_id&admission_academic_term_id=$academic_term_id\"
							 style=\"background-color:skyblue;color:white;\">ACADEMICS</a>
					 </span>
					 <span style=\"width:120px;\">
						 <a href=\"feesdetails.php?student_id=$student_id&class_id=$class_id&admission_academic_term_id=$academic_term_id\"
							 style=\"background-color:#456784;color:white;width:80px;\">FEES</a>
					 </span>";
											 
					 /*CHECKING MAXIMUM CLASS*/
					 if($class_id == $maxclass)
					 {
						 $id = "12322$class_id";
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
												 
						 $id2 = "12333$class_id";
						 echo " <span><select id=\"$id2\" style=\"width:100px;\">";
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
								 echo "<option value=\"$academic_term_id_check\">$academic_year_check - $academic_term_check</option>:";
							 }
						 }
						 echo "</select></span>
							 <span style=\"width:100px;\"><input type=\"button\" value=\"Promote\" style=\"width:100px;padding:10px;background-color:green;color:#fff;border:solid 1px green;cursor:pointer;\"
									 onclick=promoteStudent($student_id,$id,$id2)></span>
							 <span style=\"width:100px;\"><input type=\"button\" value=\"De-promote\" style=\"width:100px;padding:10px;background-color:#bc3226;color:#fff;border:solid 1px #bc3226;cursor:pointer;\"
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
	 else if($action == "showexamlist"){
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
	     
		 echo "<div id=\"list-exams-overide\">";
					 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
							 <span style=\"width:50px;\"><b>ID</b></span>
							 <span style=\"width:150px;\"><b>ACADEMIC TERM</b></span>
							 <span style=\"width:130px;\"><b>ABREVIATION</b></span>
							 <span style=\"width:120px;\"><b>EXAM DATE</b></span>
							 <span style=\"width:170px;\"><b>EXAM COMMENT</b></span>
							 <span style=\"width:125px;\"><b>ACTION</b></span>
						 </p>";
						 
						 $query = "SELECT * FROM exams ORDER BY exam_id DESC LIMIT $start_from, $results_per_page";
						 $result = mysql_query($query);
						 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 
						 echo "<ul>";
							 while($row=mysql_fetch_array($result)){
								 $exam_id = $row['exam_id'];
								 $academic_term_id = $row['academic_term_id'];
								 $examtypes_id = $row['examtypes_id'];
								 $exam_date = $row['exam_date'];
								 $exam_comment = $row['exam_comment'];
								 
								 /*Checking for admission_date*/
								 $queryex = "SELECT academic_year,academic_term FROM schoolterm WHERE academic_term_id = '$academic_term_id'";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
								 $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $academic_year = $rowex[0];
									 $academic_term = $rowex[1];
								 }
								 /*END of Checking for admission_date*/
								 
								 /*Checking for class alias*/
								 $queryex = "SELECT exam_abreviation FROM examtypes WHERE examtypes_id = '$examtypes_id'";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
								 $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $exam_abreviation = $rowex[0];
								 }
								 /*END of Checking for class*/
								 
								 echo "<li>
									 <span style=\"width:50px;\">$exam_id</span>
									 <span style=\"width:150px;\">$academic_year - $academic_term</span>
									 <span style=\"width:130px;\">$exam_abreviation</span>
									 <span style=\"width:120px;\">$exam_date</span>
									 <span style=\"width:170px;\">$exam_comment</span>
									 
									 <span style=\"width:100px;\">
									 <input style=\"width:100px;background-color:green;color:white;cursor:pointer;padding:5px;margin:0px;border:solid 1px green;
									 border-radius:3px;\" type=\"button\" value=\"Performance\" onclick=checkPerformance($exam_id)>
									 </span>
									 <span style=\"width:100px;\">
									 <input style=\"width:100px;background-color:#33333f;color:red;cursor:pointer;padding:5px;margin:0px;border-radius:3px;\" 
										 type=\"button\" value=\"Delete\" onclick=deleteExam($exam_id)>
									 </span>
								 </li>";
							 }
						 echo "</ul>";
					echo "</div>";
		 
		 $query = "SELECT COUNT(exam_id) FROM exams";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
						 
		 $row = mysql_fetch_row($result);
		 echo "<div id=\"list-footer\">";
		 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
		 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
			 echo "<a href=\"javascript:moreExams($i)\"";
			 if ($i==$page)  
				 echo " class='curPage'";
			 echo ">$i</a> ";
		 };
		 echo "</div>";
	 }
	 if($action == "deleteexam"){
		 $exam_id = $_POST["exam_id"];
		 
		 $query = "DELETE FROM exams WHERE exam_id = '$exam_id'";queryMysql($query);
	 }
	 if($action == "deleteexamtype"){
		 $examtypes_id = $_POST["examtypes_id"];
		 
		 $query = "DELETE FROM examtypes WHERE examtypes_id = '$examtypes_id'";queryMysql($query);
	 }