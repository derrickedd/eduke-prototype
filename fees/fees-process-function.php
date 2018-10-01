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
     
	 /*Searchng student and making payment*/
	 if($action == "searchstudentandmakepayment"){
		 if (isset($_POST['student_name'])) {
			 $search = $_POST['student_name'];
		     
			  echo "<div class=\"displaysearchstudentandmakepayment\">";
					 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
							 <span style=\"width:50px;\"><b>ID</b></span>
							 <span style=\"width:180px;\"><b>NAME</b></span>
							 <span style=\"width:180px;\"><b>CLASS</b></span>
							 <span style=\"width:120px;\"><b>GENDER</b></span>
							 
						 </p>";
			 
			 $query = "SELECT * FROM schoolstudents WHERE (student_firstname LIKE '%$search%' OR student_lastname LIKE '%$search%') 
			 AND status = 'Active' LIMIT 20";
		     $result = mysql_query($query);
			 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 
			 echo "<ul>";
		 
			 while($row=mysql_fetch_array($result)){
				 $student_id = $row['student_id'];
				 $student_firstname = $row['student_firstname'];
				 $student_lastname = $row['student_lastname'];
				 $class_id = $row['class_id'];
				 $gender = $row['gender'];
				 
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
				 /*END of Checking for class*/
				 if($rowsex == 0){
					 $class_alias = '-';
				 }
								 
				 echo "<li><a href=\"../student/feesdetails.php?student_id=$student_id&class_id=$class_id\">
						 <span style=\"width:50px;\">$student_id</span>
						 <span style=\"width:180px;\">$student_firstname $student_lastname</span>
						 <span style=\"width:180px;\">$class_alias</span>
						 <span style=\"width:50px;\">$gender</span>
						 </a>
					 </li>";
				 
			 }
			 echo "</ul>";
			 echo "</div>";
		}
	 }
	 else if($action == "searchstudentandaddfeewaiver"){
		 if (isset($_POST['student_name'])) {
			 $search = $_POST['student_name'];
		     
			  echo "<div class=\"displaysearchstudentandmakepayment\">";
					 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
							 <span style=\"width:50px;\"><b>ID</b></span>
							 <span style=\"width:200px;\"><b>NAME</b></span>
							 <span style=\"width:180px;\"><b>CLASS</b></span>
							 <span style=\"width:120px;\"><b>GENDER</b></span>
							 <span style=\"width:120px;\"><b>PERCENTAGE</b></span>
							 <span style=\"width:120px;\"><b>SET FOR</b></span>
							 
						 </p>";
			 
			 $query = "SELECT * FROM schoolstudents WHERE (student_firstname LIKE '%$search%' OR student_lastname LIKE '%$search%') 
			 AND status = 'Active' LIMIT 20";
		     $result = mysql_query($query);
			 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 
			 echo "<ul>";
		 
			 while($row=mysql_fetch_array($result)){
				 $student_id = $row['student_id'];
				 $student_firstname = $row['student_firstname'];
				 $student_lastname = $row['student_lastname'];
				 $class_id = $row['class_id'];
				 $gender = $row['gender'];
				 
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
				 /*END of Checking for class*/
				 if($rowsex == 0){
					 $class_alias = '-';
				 }
				
				 echo "<li style=\"cursor:pointer;\">
						 <span style=\"width:60px;\">$student_id</span>
						 <span style=\"width:200px;\">$student_firstname $student_lastname</span>
						 <span style=\"width:180px;\">$class_alias</span>
						 <span style=\"width:120px;\">$gender</span>
						 
						 <span style=\"width:120px;\">
						     <input type=\"text\" style=\"background-color:#eee;padding:5px;border:solid 1px silver;border-radius:3px;\" 
							 id=\"$student_id\" placeholder=\"Insert (%)\">
						 </span>
						 
						 <span>
						     <input type=\"button\" style=\"background-color:green;color:white;border:solid 1px green;border-radius:3px;cursor:pointer;\" 
							 value=\"Full Year\" onclick=fullYearWaiver($student_id)>
						 </span>
						 
						 <span>
						     <input type=\"button\" style=\"background-color:skyblue;color:white;border:solid 1px skyblue;border-radius:3px;cursor:pointer;\"
							 value=\"One Term\" onclick=oneTermWaiver($student_id)>
						 </span>
					 </li>";
				 
			 }
			 echo "</ul>";
			 echo "</div>";
		}
	 }
	 else if($action == "showfullyearwaiverpan"){
		 $student_id = $_POST["student_id"];
		 $inserted_percentage = $_POST["inserted_percentage"];
		 
		 $queryex = "SELECT academic_term_id, academic_year, academic_term FROM schoolterm ORDER BY academic_term_id DESC";
		 $resultex = mysql_query($queryex);
		 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsex = mysql_num_rows($resultex);
		 
		 echo "<p><b>YEAR</b> <br> <select name=\"academic_term_id\"><option>- Select Year -</option>";
		 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
		 {
			 $rowex = mysql_fetch_row($resultex);
			 $academic_term_id_check = $rowex[0];
			 $academic_year_check = $rowex[1];
			 $academic_term_check = $rowex[2];
			 
			 if(($academic_term_id_check == $academic_term_id) || ($academic_term_id_check < $academic_term_id))
			 {
				 /*Do nothing*/
			 } else {
				 if($academic_term_check == 1) /*Check if academic_term_check is equal to one because its the starting semester*/
					 echo "<option value=$academic_term_id_check onclick=\"insertWaiverForYear($student_id,$inserted_percentage,$academic_term_id_check)\">$academic_year_check - $academic_term_check</option>";
			 }
		 }
		 echo "</select></p>";
	 }
	 else if($action == "onetermwaiverpan"){
		 $student_id = $_POST["student_id"];
		 $inserted_percentage = $_POST["inserted_percentage"];
		 
		 $queryex = "SELECT academic_term_id, academic_year, academic_term FROM schoolterm ORDER BY academic_term_id DESC";
		 $resultex = mysql_query($queryex);
		 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
		 $rowsex = mysql_num_rows($resultex);
		
		 echo "<p><b>TERM</b> <br> <select name=\"academic_term_id\"><option>- Select Term -</option>";
		 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
		 {
			 $rowex = mysql_fetch_row($resultex);
			 $academic_term_id_check = $rowex[0];
			 $academic_year_check = $rowex[1];
			 $academic_term_check = $rowex[2];
			 echo "<option value=$academic_term_id_check onclick=\"insertWaiverForTerm($student_id,$inserted_percentage,$academic_term_id_check)\">$academic_year_check - $academic_term_check</option>";
		 }
		 echo "</select></p>";
	 }
	 else if($action == "insertwaiverforyear"){
		 $student_id = $_POST["student_id"];
		 $inserted_percentage = $_POST["inserted_percentage"];
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
			 $query22 = "SELECT MAX(fee_waiver_id) FROM fee_waiver";
			 $result22 = mysql_query($query22);
			 if(!$result22) die("DB access failed(derro internal error): " . mysql_error());
			 $row22 = mysql_fetch_row($result22);
			 $fee_waiver_id = $row22[0]+1;
			 
			 $query222 = "INSERT INTO fee_waiver VALUES('$fee_waiver_id', '$student_id', '','$inserted_percentage', '$academic_term_id_for_increment')";queryMysql($query222);
			 $academic_term_id_for_increment++;
		 }
	 }
	 else if($action == "insertwaiverforterm"){
		 $student_id = $_POST["student_id"];
		 $inserted_percentage = $_POST["inserted_percentage"];
		 $term_id = $_POST["term_id"];
		
		 $query22 = "SELECT MAX(fee_waiver_id) FROM fee_waiver";
		 $result22 = mysql_query($query22);
		 if(!$result22) die("DB access failed(derro internal error): " . mysql_error());
		 $row22 = mysql_fetch_row($result22);
		 $fee_waiver_id = $row22[0]+1;
			 
		 $query222 = "INSERT INTO fee_waiver VALUES('$fee_waiver_id', '$student_id', '','$inserted_percentage', '$term_id')";queryMysql($query222);
	 }
	 else if($action == "approvefeespayment"){
		 $schoolfees_id = $_POST["schoolfees_id"];
		 $sysuser_id = $_POST["sysuser_id"];
		 
		 $query = "UPDATE schoolfees SET status = 'Approved' WHERE schoolfees_id = '$schoolfees_id'";queryMysql($query);
		 $query = "UPDATE schoolfees SET approved_by = '$sysuser_id' WHERE schoolfees_id = '$schoolfees_id'";queryMysql($query);
	 }
	 else if($action == "unapprovefeespayment"){
		 $schoolfees_id = $_POST["schoolfees_id"];
		 $sysuser_id = $_POST["sysuser_id"];
		 
		 $query = "UPDATE schoolfees SET status = 'Pending' WHERE schoolfees_id = '$schoolfees_id'";queryMysql($query);
		 $query = "UPDATE schoolfees SET approved_by = '' WHERE schoolfees_id = '$schoolfees_id'";queryMysql($query);
	 }
	 else if($action == "showfeeslist"){
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
		 
		 echo "<div id=\"fees-module-overide\">";
						 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
							 <span style=\"width:170px;\"><b>ACADEMIC TERM</b></span>
							 <span style=\"width:190px;\"><b>COLLECTED AMOUNT</b></span>
							 <span style=\"width:170px;\"><b>TOTAL AMOUNT</b></span>
						 </p>";
						 
						 $query = "SELECT * FROM schoolterm ORDER BY academic_term_id DESC LIMIT $start_from, $results_per_page";
						 $result = mysql_query($query);
						 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 
						 echo "<ul>";
						 while($row=mysql_fetch_array($result)){
							 $academic_term_id = $row['academic_term_id'];
							 $academic_year = $row['academic_year'];
							 $academic_term = $row['academic_term'];
							 
							 echo "<li><a href=\"feesoverviewclasswise.php?academic_term_id=$academic_term_id\">
								 <span style=\"width:170px;\">$academic_year - $academic_term</span>";
								 
								 $querychk = "SELECT * FROM schoolfees WHERE academic_term_id = '$academic_term_id'";
								 $resultchk = mysql_query($querychk);
								 if(!$resultchk) die("DB access failed(derro internal error): " . mysql_error());
								 $rowschk = mysql_num_rows($resultchk);
								 
								 $sum = 0;
								 while($rowchk=mysql_fetch_array($resultchk))
								 {
									 $fees_paid = $rowchk['fees_paid'];
									 
									 
									 $sum = $sum + $fees_paid;
								 }
								 if ($rowschk == 0){
									 echo "<span style=\"width:200px;\"><b>$sum</b></span>";
								 }
								 else {
									 echo "<span style=\"width:200px;\"><b>$sum</b></span>";
								 }
								 
								 $sum2 = 0;
								 /*Checking for class fees*/
								 $queryex = "SELECT class_id, class_fees FROM schoolclassfees WHERE academic_term_id = '$academic_term_id'";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
							     $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $class_id = $rowex[0];
									 $class_fees = $rowex[1];
								     
									 /*Checking for number of students*/
									 $queryex2 = "SELECT COUNT(*) FROM classenrolled WHERE academic_term_id = '$academic_term_id' AND class_id = '$class_id'";
									 $resultex2 = mysql_query($queryex2);
									 if(!$resultex2) die("DB access failed(derro internal error): " . mysql_error());
									 $rowsex2 = mysql_num_rows($resultex2);
									 for ($jex2 = 0 ; $jex2 < $rowsex2 ; ++$jex2)
									 {
										 $rowex2 = mysql_fetch_row($resultex2);
										 $total_number_of_students_in_academic_year = $rowex2[0];
									 }
									 /*END of Checking for number of students*/
									 $totalfees_expected_for_class = $total_number_of_students_in_academic_year * $class_fees;
									 $sum2 = $sum2 + $totalfees_expected_for_class;
								 }
								 if ($rowsex == 0){
									 echo "<span style=\"width:170px;\"><b>$sum2</b></span>";
								 }
								 else {
									 echo "<span style=\"width:170px;\"><b>$sum2</b></span>";
								 }
						     echo "</a></li>";
						 }
					 echo "</ul>";
				echo "</div>";
	     $query = "SELECT COUNT(academic_term_id) FROM schoolterm";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
						 
		 $row = mysql_fetch_row($result);
		 echo "<div id=\"list-footer\">";
		 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
		 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
			 echo "<a href=\"javascript:moreFeesList($i)\"";
			 if ($i==$page)  
				 echo " class='curPage'";
			 echo ">$i</a> ";
		 };
		 echo "</div>";
		 
	 }
	 else if($action == "showapprovepaymentList"){
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
		 
		 echo "<div id=\"fees-module\">";
						 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
							 <span style=\"width:170px;\"><b>ACADEMIC TERM</b></span>
							 <span style=\"width:190px;\"><b>PAYMENTS PENDING APROVAL</b></span>
							 <span style=\"width:170px;\"><b>PAYMENTS APROVED</b></span>
						 </p>";
						 
						 $query = "SELECT * FROM schoolterm ORDER BY academic_term_id DESC LIMIT $start_from, $results_per_page";
						 $result = mysql_query($query);
						 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 
						 echo "<ul>";
						 while($row=mysql_fetch_array($result)){
							 $academic_term_id = $row['academic_term_id'];
							 $academic_year = $row['academic_year'];
							 $academic_term = $row['academic_term'];
							 
							 echo "<li><a href=\"approvepaymentsclasswise.php?academic_term_id=$academic_term_id\">
								 <span style=\"width:170px;\">$academic_year - $academic_term</span>";
								 
								 $queryex = "SELECT COUNT(*) FROM schoolfees WHERE academic_term_id = '$academic_term_id' 
								 AND status = 'Pending'";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
								 $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $paymentnotaprovedcount = $rowex[0];
									 echo "<span style=\"width:200px;\"><b>$paymentnotaprovedcount</b></span>";
								 }
								 
								 $queryex = "SELECT COUNT(*) FROM schoolfees WHERE academic_term_id = '$academic_term_id' 
								 AND status = 'Approved'";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
								 $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $paymentaprovedcount = $rowex[0];
									 echo "<span style=\"width:200px;\"><b>$paymentaprovedcount</b></span>";
								 }
								 
						     echo "</a></li>";
						 }
					 echo "</ul>";
				echo "</div>";
	     $query = "SELECT COUNT(academic_term_id) FROM schoolterm";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
						 
		 $row = mysql_fetch_row($result);
		 echo "<div id=\"list-footer\">";
		 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
		 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
			 echo "<a href=\"javascript:moreApprovePaymentList($i)\"";
			 if ($i==$page)  
				 echo " class='curPage'";
			 echo ">$i</a> ";
		 };
		 echo "</div>";
		 
	 }
	 else if($action == "showoverviewstudentwise"){
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
		 
		 $academic_term_id = $_POST['academic_term_id'];
		 $class_id = $_POST['class_id'];
		 
		 echo "<div id=\"fees-module-overide\">";
						 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
							 <span style=\"width:200px;\"><b>STUDENT NAME</b></span>
							 <span style=\"width:130px;\"><b>PAID</b></span>
							 <span style=\"width:130px;\"><b>COMPULSARY</b></span>
							 <span style=\"width:130px;\"><b>OPTIONAL</b></span>
							 <span style=\"width:130px;\"><b>COMPULSARY + OPTIONAL</b></span>
							 <span style=\"width:130px;\"><b>PERCENTAGE</b></span>
						 </p>";
						 
						 $query = "SELECT * FROM classenrolled WHERE academic_term_id = '$academic_term_id' AND class_id = '$class_id'
						 LIMIT $start_from, $results_per_page";
						 $result = mysql_query($query);
						 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 
						 echo "<ul>";
						 while($row=mysql_fetch_array($result)){
							 $student_id = $row['student_id'];
							 
							 echo "<li><a href=\"../student/feesdetails.php?student_id=$student_id&class_id=$class_id&admission_academic_term_id=$academic_term_id\">";
							 
								 $querychk = "SELECT student_firstname, student_lastname FROM schoolstudents WHERE student_id = '$student_id'";
								 $resultchk = mysql_query($querychk);
								 if(!$resultchk) die("DB access failed(derro internal error): " . mysql_error());
								 $rowschk = mysql_num_rows($resultchk);
								 
								 while($rowchk=mysql_fetch_array($resultchk))
								 {
									 $student_firstname = $rowchk['student_firstname'];
									 $student_lastname = $rowchk['student_lastname'];
								 }
								 if ($rowschk == 0){
									 /*Do nothing*/
								 }
								 else {
									 echo "<span style=\"width:200px;\"><b>$student_firstname $student_lastname</b></span>";
								 }
								 
								 $sum = 0;
								 /*Checking for class fees*/
								 $queryex = "SELECT fees_paid FROM schoolfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id'
								 AND student_id = $student_id";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
							     $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $fees_paid = $rowex[0];
								     $sum = $sum + $fees_paid;
								 }
								 if ($rowsex == 0){
									 echo "<span style=\"width:135px;\"><b>$sum</b></span>";
								 }
								 else {
									 echo "<span style=\"width:135px;\"><b>$sum</b></span>";
								 }
								 
								 $sum2 = 0;
								 /*Checking for class fees*/
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
									 echo "<span style=\"width:135px;\"><b>$sum2</b></span>";
								 }
								 else {
									 echo "<span style=\"width:135px;\"><b>$sum2</b></span>";
								 }
								 
								 $sum3 = 0;
								 /*Checking for class fees*/
								 $queryex = "SELECT class_fees FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id'
								 AND priority = 'Optional'";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
							     $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $class_fees = $rowex[0];
								     $sum3 = $sum3 + $class_fees;
								 }
								 if ($rowsex == 0){
									 echo "<span style=\"width:135px;\"><b>$sum3</b></span>";
								 }
								 else {
									 echo "<span style=\"width:135px;\"><b>$sum3</b></span>";
								 }
								 
								 $sum4 = 0;
								 /*Checking for class fees*/
								 $queryex = "SELECT class_fees FROM schoolclassfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id'";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
							     $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $class_fees = $rowex[0];
								     $sum4 = $sum4 + $class_fees;
								 }
								 if ($rowsex == 0){
									 echo "<span style=\"width:170px;\"><b>$sum4</b></span>";
								 }
								 else {
									 echo "<span style=\"width:170px;\"><b>$sum4</b></span>";
								 }
								 
						     echo "</a></li>";
						 }
					 echo "</ul>";
				echo "</div>";
		 
	     $query = "SELECT COUNT(classesenrolled_id) FROM classenrolled WHERE academic_term_id = '$academic_term_id' AND class_id = '$class_id'";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
						 
		 $row = mysql_fetch_row($result);
		 echo "<div id=\"list-footer\">";
		 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
		 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
			 echo "<a href=\"javascript:moreOverviewStudentwise($i)\"";
			 if ($i==$page)  
				 echo " class='curPage'";
			 echo ">$i</a> ";
		 };
		 echo "</div>";
		 
	 }
	 else if($action == "showapprovepaymentstudentwise"){
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
		 
		 $academic_term_id = $_POST['academic_term_id'];
		 $class_id = $_POST['class_id'];
		 
		 echo "<div id=\"fees-module-overide\">";
						 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
							 <span style=\"width:200px;\"><b>STUDENT NAME</b></span>
							 <span style=\"width:190px;\"><b>PAYMENTS PENDING APROVAL</b></span>
							 <span style=\"width:170px;\"><b>PAYMENTS APROVED</b></span>
						 </p>";
						 
						 $query = "SELECT * FROM classenrolled WHERE academic_term_id = '$academic_term_id' AND class_id = '$class_id'
						 LIMIT $start_from, $results_per_page";
						 $result = mysql_query($query);
						 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 
						 echo "<ul>";
						 while($row=mysql_fetch_array($result)){
							 $student_id = $row['student_id'];
							 
							 echo "<li><a href=\"approvestudentpayments.php?student_id=$student_id&class_id=$class_id&academic_term_id=$academic_term_id\">";
							 
								 $querychk = "SELECT student_firstname, student_lastname FROM schoolstudents WHERE student_id = '$student_id'";
								 $resultchk = mysql_query($querychk);
								 if(!$resultchk) die("DB access failed(derro internal error): " . mysql_error());
								 $rowschk = mysql_num_rows($resultchk);
								 
								 while($rowchk=mysql_fetch_array($resultchk))
								 {
									 $student_firstname = $rowchk['student_firstname'];
									 $student_lastname = $rowchk['student_lastname'];
								 }
								 if ($rowschk == 0){
									 /*Do nothing*/
								 }
								 else {
									 echo "<span style=\"width:200px;\"><b>$student_firstname $student_lastname</b></span>";
								 }
								 
								 $sum = 0;
								 /*Checking for class fees*/
								 $queryex = "SELECT COUNT(*) FROM schoolfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id'
								 AND student_id = '$student_id' AND status = 'Pending'";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
								 $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $paymentnotaprovedcount = $rowex[0];
									 echo "<span style=\"width:200px;\"><b>$paymentnotaprovedcount</b></span>";
								 }
								 
								 $queryex = "SELECT COUNT(*) FROM schoolfees WHERE class_id = '$class_id' AND academic_term_id = '$academic_term_id'
								 AND student_id = '$student_id' AND status = 'Approved'";
								 $resultex = mysql_query($queryex);
								 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
								 $rowsex = mysql_num_rows($resultex);
								 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
								 {
									 $rowex = mysql_fetch_row($resultex);
									 $paymentaprovedcount = $rowex[0];
									 echo "<span style=\"width:200px;\"><b>$paymentaprovedcount</b></span>";
								 }
								 
						     echo "</a></li>";
						 }
					 echo "</ul>";
				echo "</div>";
	     $query = "SELECT COUNT(classesenrolled_id) FROM classenrolled WHERE academic_term_id = '$academic_term_id' AND class_id = '$class_id'";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
						 
		 $row = mysql_fetch_row($result);
		 echo "<div id=\"list-footer\">";
		 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
		 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
			 echo "<a href=\"javascript:moreApprovePaymentStudentwise($i)\"";
			 if ($i==$page)  
				 echo " class='curPage'";
			 echo ">$i</a> ";
		 };
		 echo "</div>";
		 
	 }
	  else if($action == "deletefeewaiver"){
		 $fee_waiver_id = $_POST["fee_waiver_id"];
		 
		 $query = "DELETE FROM fee_waiver WHERE fee_waiver_id = '$fee_waiver_id'";queryMysql($query);
	 }