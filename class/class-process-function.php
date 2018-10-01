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
     
	 if($action == "showclassstudents"){
	     $class_id = $_POST['class_id'];
		 $studentstatus = "Active";
		 
		 if (isset($_POST["sub_class_id"])) /*If sub class is involved*/
		 { 
			 $sub_class_id = $_POST['sub_class_id'];
			 
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
				 <span style=\"width:150px;\"><b>TERM JOINED</b></span>
			 </p>";
									 
			 $query="SELECT * FROM schoolstudents WHERE class_id = '$class_id' AND sub_class_id = '$sub_class_id' 
			     AND status = '$studentstatus' ORDER BY student_id ASC LIMIT $start_from, $results_per_page";
			 $result = mysql_query($query);
			 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
			
			 echo "<ul>";
				 while($row=mysql_fetch_array($result))
				 {
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
						 $class_id_ref = $rowex[0];
						 
						 /*Checking for class*/
						 $queryex = "SELECT MIN(academic_term_id) FROM classenrolled WHERE class_id = '$class_id_ref' 
							 AND student_id = '$student_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $term_id = $rowex[0];
						 }
						  /*END of Checking for class*/
							
					 }
					 /*END of Checking for class*/
						
					 /*Checking for admission_date*/
					 $queryex = "SELECT academic_year,academic_term FROM schoolterm WHERE academic_term_id = '$term_id'";
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
						 <a  href=\"../student/viewstudent.php?student_id=$student_id\" style=\"display:inline-block!important;\">
							 <span style=\"width:50px;\">$student_id</span>
							 <span style=\"width:130px;\">$admission_number</span>
							 <span style=\"width:240px;\">$student_firstname $student_lastname</span>
							 <span style=\"width:80px;\">$gender</span>
							 <span style=\"width:80px;\">$admission_year - $admission_term</span>
						 </a>";
					
						 $id2 = $student_id+$admission_number;
						 echo " <span><select id=\"$id2\" style=\"width:100px;\">";
							 $querylast = "SELECT * FROM schoolterm ORDER BY academic_term_id DESC";
							 $resultlast = mysql_query($querylast);
							 if(!$resultlast) die("DB access failed(derro internal error): " . mysql_error());
							 $rowslast = mysql_num_rows($resultlast);
							 while($rowlast=mysql_fetch_array($resultlast))
							 {
								 $academic_term_id_check = $rowlast['academic_term_id'];
								 $academic_term_check = $rowlast['academic_term'];
								 $academic_year_check = $rowlast['academic_year'];
								 
								 if(($academic_term_id_check == $term_id) || ($academic_term_id_check < $term_id))
								 {
									 /*Do nothing*/
								 } else {
									 if($academic_term_check == 1) /*Check if academic_term_check is equal to one because its the starting semester*/
										 echo "<option value=\"$academic_term_id_check\">$academic_year_check - $academic_term_check</option>:";
								 }
							 }
						 echo "</select></span>";
							
						 echo "<input type=\"submit\" value=\"Promote\" style=\"padding:5px;width:80px;background-color:green;
							 border:solid 1px green;border-radius:3px;color:#fff;cursor:pointer;margin-right:10px;\"
							 onclick=promoteClassStudent($student_id,$class_id,$sub_class_id,$id2)>
							
							 <input type=\"submit\" value=\"De-Promote\" style=\"padding:5px;width:80px;background-color:#bc3226;
								 border:solid 1px #bc3226;border-radius:3px;color:#fff;cursor:pointer;\"
								 onclick=dePromoteClassStudent($student_id)>
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
					 echo "<a href=\"javascript:moreClassStudents($i,$class_id,$sub_class_id)\"";
					 if ($i==$page)  
						 echo " class='curPage'";
					 echo ">$i</a> ";
				 };
			 
		 } else { /*When sub class is not involved*/
			 
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
				 <span style=\"width:150px;\"><b>TERM JOINED</b></span>
			 </p>";
			 
			 $query="SELECT * FROM schoolstudents WHERE class_id = '$class_id' AND status = '$studentstatus' ORDER BY student_id ASC LIMIT $start_from, $results_per_page";
			 $result = mysql_query($query);
			 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
			
			 echo "<ul>";
				 while($row=mysql_fetch_array($result))
				 {
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
						 $class_id_ref = $rowex[0];
						 
						 /*Checking for class*/
						 $queryex = "SELECT MIN(academic_term_id) FROM classenrolled WHERE class_id = '$class_id_ref' 
							 AND student_id = '$student_id'";
						 $resultex = mysql_query($queryex);
						 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsex = mysql_num_rows($resultex);
						 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
						 {
							 $rowex = mysql_fetch_row($resultex);
							 $term_id = $rowex[0];
						 }
						  /*END of Checking for class*/
							
					 }
					 /*END of Checking for class*/
						
					 /*Checking for admission_date*/
					 $queryex = "SELECT academic_year,academic_term FROM schoolterm WHERE academic_term_id = '$term_id'";
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
						 <a  href=\"../student/viewstudent.php?student_id=$student_id\" style=\"display:inline-block!important;\">
							 <span style=\"width:50px;\">$student_id</span>
							 <span style=\"width:130px;\">$admission_number</span>
							 <span style=\"width:240px;\">$student_firstname $student_lastname</span>
							 <span style=\"width:80px;\">$gender</span>
							 <span style=\"width:80px;\">$admission_year - $admission_term</span>
						 </a>";
					     
						 /*Getting stream for class*/
						 $idsalt = "00";
						 $class_id_tobeused = $class_id + 1;
						 $id1 = $student_id+$admission_number;
						 echo " <span><select id=\"$id1\" style=\"width:100px;\">";
							 $querylast = "SELECT * FROM schoolsubclass WHERE class_id = '$class_id_tobeused' ORDER BY sub_class_id DESC";
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
						 /*End of Getting stream for class*/
						 
						 $id2 = $student_id+$admission_number;
						 echo " <span><select id=\"$id2\" style=\"width:100px;\">";
							 $querylast = "SELECT * FROM schoolterm ORDER BY academic_term_id DESC";
							 $resultlast = mysql_query($querylast);
							 if(!$resultlast) die("DB access failed(derro internal error): " . mysql_error());
							 $rowslast = mysql_num_rows($resultlast);
							 while($rowlast=mysql_fetch_array($resultlast))
							 {
								 $academic_term_id_check = $rowlast['academic_term_id'];
								 $academic_term_check = $rowlast['academic_term'];
								 $academic_year_check = $rowlast['academic_year'];
								 
								 if(($academic_term_id_check == $term_id) || ($academic_term_id_check < $term_id))
								 {
									 /*Do nothing*/
								 } else {
									 if($academic_term_check == 1) /*Check if academic_term_check is equal to one because its the starting semester*/
										 echo "<option value=\"$academic_term_id_check\">$academic_year_check - $academic_term_check</option>:";
								 }
							 }
						 echo "</select></span>";
							
						 echo "<input type=\"submit\" value=\"Promote\" style=\"padding:5px;width:80px;background-color:green;
							 border:solid 1px green;border-radius:3px;color:#fff;cursor:pointer;margin-right:10px;\"
							 onclick=promoteClassStudent($student_id,$class_id,$id1, $id2)>
							
							 <input type=\"submit\" value=\"De-Promote\" style=\"padding:5px;width:80px;background-color:#bc3226;
								 border:solid 1px #bc3226;border-radius:3px;color:#fff;cursor:pointer;\"
								 onclick=dePromoteClassStudent($student_id)>
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
					 echo "<a href=\"javascript:moreClassStudents($i,$class_id)\"";
					 if ($i==$page)  
						 echo " class='curPage'";
					 echo ">$i</a> ";
				 };
			 
		 }
	 }
	 else if($action == "promotestudent"){
		 $student_id = $_POST["student_id"];
		 $class_id = $_POST["class_id"] + 1;
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
							 
							 $query222 = "INSERT INTO classenrolled VALUES('$classesenrolled_id', '$academic_term_id_for_increment', '$student_id','$class_id', '$sub_class_id')";queryMysql($query222);
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
	 else if($action == "showclasssubjectslist"){
	     $classlevel_id = $_POST['classlevel_id'];
	     $class_category_id = $_POST['class_category_id'];
						 
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
			 $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
	     
          echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
								 <span style=\"width:50px;\"><b>ID</b></span>
								 <span style=\"width:130px;\"><b>NO. OF PAPERS</b></span>
								 <span style=\"width:170px;\"><b>SUBJECT NAME</b></span>
								 <span style=\"width:120px;\"><b>CLASS LEVEL</b></span>
								 <span style=\"width:150px;\"><b>CATEGORY</b></span>
								 <span style=\"width:150px;\"><b>DESCRIPTION</b></span>
								 
							 </p>";
							 
							 $query = "SELECT * FROM schoolsubjects WHERE classlevel_id = '$classlevel_id' AND class_category_id = '$class_category_id'
							 LIMIT $start_from, $results_per_page";
							 $result = mysql_query($query);
							 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
							 
							 echo "<ul>";
								 while($row=mysql_fetch_array($result)){
									 $subject_id = $row['subject_id'];
									 $number_of_papers = $row['number_of_papers'];
									 $subject_name = $row['subject_name'];
									 $classlevel_id = $row['classlevel_id'];
									 $class_category_id = $row['class_category_id'];
									 $description = $row['description'];
									 
									 /*Checking for class class level*/
									 $queryex = "SELECT classlevel_name FROM classlevel WHERE classlevel_id = '$classlevel_id'";
									 $resultex = mysql_query($queryex);
									 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
									 $rowsex = mysql_num_rows($resultex);
									 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
									 {
										 $rowex = mysql_fetch_row($resultex);
										 $classlevel_name = $rowex[0];
									 }
									 /*END of Checking for class level*/
									 
									 /*Checking for class class category*/
									 $queryex = "SELECT class_category FROM classcategory WHERE class_category_id = '$class_category_id'";
									 $resultex = mysql_query($queryex);
									 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
									 $rowsex = mysql_num_rows($resultex);
									 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
									 {
										 $rowex = mysql_fetch_row($resultex);
										 $class_category = $rowex[0];
									 }
									 /*END of Checking for class category*/
									 
									 echo "<li><a>
										 <span style=\"width:50px;\">$subject_id</span>
										 <span style=\"width:130px;\">$number_of_papers</span>
										 <span style=\"width:170px;\">$subject_name</span>
										 <span style=\"width:120px;\">$classlevel_name</span>
										 <span style=\"width:150px;\">$class_category</span>
										 <span style=\"width:150px;\">$description</span>
										 </a>
									 </li>";
								 }
							 echo "</ul>";
		 
		 $query = "SELECT COUNT(subject_id) FROM schoolsubjects WHERE classlevel_id = '$classlevel_id' AND class_category_id = '$class_category_id'";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
		
		 $row = mysql_fetch_row($result);
		 echo "<div id=\"list-footer\">";
		 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
		
		 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
			 echo "<a href=\"javascript:moreClassSubjectsList($i,$classlevel_id,$class_category_id)\"";
			 if ($i==$page)  
			     echo " class='curPage'";
			 echo ">$i</a> ";
		 };
	 }
	 else if($action == "deletesetclassfee"){
		 $schoolclassfees_id = $_POST["schoolclassfees_id"];
		 
		 $query = "DELETE FROM schoolclassfees WHERE schoolclassfees_id = '$schoolclassfees_id'";queryMysql($query);
	 }
	 else if($action == "deleteclass"){
		 $class_id = $_POST["class_id"];
		 
		 $query = "DELETE FROM classenrolled WHERE class_id = '$class_id'";queryMysql($query);
		 $query = "DELETE FROM schoolfees WHERE class_id = '$class_id'";queryMysql($query);
		 $query = "DELETE FROM schoolclassfees WHERE class_id = '$class_id'";queryMysql($query);
		 $query = "DELETE FROM schoolclass WHERE class_id = '$class_id'";queryMysql($query);
	 }
	 else if($action == "deleteclasscategory"){
		 $class_category_id = $_POST["class_category_id"];
		 
		 $query = "DELETE FROM classcategory WHERE class_category_id = '$class_category_id'";queryMysql($query);
	 }
	 else if($action == "deleteclasslevel"){
		 $classlevel_id = $_POST["classlevel_id"];
		 
		 $query = "DELETE FROM classlevel WHERE classlevel_id = '$classlevel_id'";queryMysql($query);
	 }
	 else if($action == "saveclassdata"){
		 $class_alias = $_POST["class_alias"];$class_alias = sanitizeString($class_alias);$class_alias = string_to_uppecase($class_alias);
		 $teacher_id = $_POST["teacher_id"];$teacher_id = sanitizeString($teacher_id);
		 $classlevel_id = $_POST["classlevel_id"];$classlevel_id = sanitizeString($classlevel_id);
		 $class_category_id = $_POST["class_category_id"];$class_category_id = sanitizeString($class_category_id);
		 $class_id = $_POST["class_id"];$class_id = sanitizeString($class_id);
		 
		 $query = "UPDATE schoolclass SET class_alias = '$class_alias' WHERE class_id = '$class_id'";queryMysql($query);
		 $query = "UPDATE schoolclass SET teacher_id = '$teacher_id' WHERE class_id = '$class_id'";queryMysql($query);
		 $query = "UPDATE schoolclass SET classlevel_id = '$classlevel_id' WHERE class_id = '$class_id'";queryMysql($query);
		 $query = "UPDATE schoolclass SET class_category_id = '$class_category_id' WHERE class_id = '$class_id'";queryMysql($query);
	 }
	 else if($action == "addclasscategorydata"){
		 $class_category = $_POST["class_category"];$class_category = sanitizeString($class_category);$class_category = string_to_uppecase($class_category);
		 
		 $query1 = "SELECT MAX(class_category_id) FROM classcategory";
		 $result = mysql_query($query1);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $row = mysql_fetch_row($result);
		 $class_category_id = $row[0]+1;

		 $query2 = "INSERT INTO classcategory VALUES('$class_category_id', '$class_category')";
		 queryMysql($query2);
	 }
	 else if($action == "addclassleveldata"){
		 $classlevel_name = $_POST["classlevel_name"];$classlevel_name = sanitizeString($classlevel_name);$classlevel_name = string_to_uppecase($classlevel_name);
		 $report_type = $_POST["report_type"];$report_type = sanitizeString($report_type);
		 
		 $query1 = "SELECT MAX(classlevel_id) FROM classlevel";
		 $result = mysql_query($query1);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $row = mysql_fetch_row($result);
		 $classlevel_id = $row[0]+1;

		 $query2 = "INSERT INTO classlevel VALUES('$classlevel_id', '$classlevel_name', '$report_type')";
		 queryMysql($query2);
	 }
?>