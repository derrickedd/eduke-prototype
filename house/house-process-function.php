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
     
	 if($action == "deletehouse"){
		 $house_id = $_POST["house_id"];
		 
		 $query = "DELETE FROM schoolhouses WHERE house_id = '$house_id'";queryMysql($query);
	 }
	 else if($action == "showhouselist"){
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
	     
		 echo "<div id=\"list-house-overide\">";
			 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
				 <span style=\"width:50px;\"><b>ID</b></span>
				 <span style=\"width:160px;\"><b>HOUSE NAME</b></span>
				 <span style=\"width:250px;\"><b>DESCRIPTION</b></span>
			 </p>";
							 
			 $query = "SELECT * FROM schoolhouses ORDER BY house_id DESC LIMIT $start_from, $results_per_page";
			 $result = mysql_query($query);
			 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
							 
			 echo "<ul>";
			 while($row=mysql_fetch_array($result)){
				 $house_id = $row['house_id'];
				 $house_name = $row['house_name'];
				 $description = $row['description'];
				
				 echo "<li>
					 <span style=\"width:50px;\">$house_id</span>
					 <span style=\"width:160px;\">$house_name</span>
					 <span style=\"width:250px;\">$description</span>
											 
					 <span style=\"width:120px;\">
						 <a href=\"housestudents.php?house_id=$house_id\"><input style=\"width:100px;background-color:skyblue;color:white;
						 cursor:pointer;padding:5px;margin:0px;border-radius:3px;border:solid 1px skyblue;\" 
							 type=\"button\" value=\"Students\"></a>
					 </span>
					 <span style=\"width:120px;\">
						 <input style=\"width:100px;background-color:#33333f;color:red;cursor:pointer;padding:5px;margin:0px;border-radius:3px;\" 
							 type=\"button\" value=\"Delete\" onclick=deleteHouse($house_id)>
					 </span>
				 </li>";
			 }
			 echo "</ul>";
		echo "</div>";
		 
		 $query = "SELECT COUNT(house_id) FROM schoolhouses";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
						 
		 $row = mysql_fetch_row($result);
		 echo "<div id=\"list-footer\">";
		 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
		 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
			 echo "<a href=\"javascript:moreHouses($i)\"";
			 if ($i==$page)  
				 echo " class='curPage'";
			 echo ">$i</a> ";
		 };
		 echo "</div>";
	 } 
	 else if($action == "showhousehtudentlist"){
		 $house_id = $_POST["house_id"];
		 
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
			 <span style=\"width:150px;\"><b>HOUSE</b></span>
		 </p>";
										 
		 $query = "SELECT * FROM schoolstudents WHERE status = 'Active' AND house_id = '$house_id'
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
			 $house_id = $row['house_id'];
			 
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
			 if($rowsex == null){
				 $class_alias = "<span style=\"color:red\">No class</span>";
			 }
			 /*END of Checking for class alias*/
										 
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
			 if($rowsex == null){
				 $admission_year = "";
				 $admission_term = "";
			 }
			 /*END of Checking for admission_date*/
			
			 /*Checking for class alias*/
			 $queryex = "SELECT house_name FROM schoolhouses WHERE house_id = '$house_id'";
			 $resultex = mysql_query($queryex);
			 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
			 $rowsex = mysql_num_rows($resultex);
			 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
			 {
				 $rowex = mysql_fetch_row($resultex);
				 $house = $rowex[0];
			 }
			 /*This is put here incase the class is deleted*/
			 if ($rowsex == ""){
				 echo "<p>The house could have been deleted</p>";
				 exit;
			 }
			 /*END of Checking for class alias*/
			
			 echo "<li>
				 <a  href=\"../student/viewstudent.php?student_id=$student_id\">
				 <span style=\"width:50px;\">$student_id</span>
				 <span style=\"width:130px;\">$admission_number</span>
				 <span style=\"width:240px;\">$student_firstname $student_lastname</span>
				 <span style=\"width:80px;\">$gender</span>
				 <span style=\"width:150px;\">$class_alias</span>
				 <span style=\"width:150px;\">$admission_year - $admission_term</span>
				 <span style=\"width:150px;color:green;\">$house</span>
				 </a>
			 </li>";
		 }
		 echo "</ul>";
										 
		 $query = "SELECT COUNT(student_id) FROM schoolstudents WHERE status = 'Active' AND house_id = '$house_id'";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
		
		 $row = mysql_fetch_row($result);
		 echo "<div id=\"list-footer\">";
		 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
		 
		 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
			 echo "<a href=\"javascript:moreHouseStudentList($i)\"";
			 if ($i==$page)  
				 echo " class='curPage'";
			 echo ">$i</a> ";
		 };
	 echo "</div>";
	 }
	 