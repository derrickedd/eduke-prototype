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
	 if($action == "deleteparentphoto"){
		 $parent_id = $_POST["parent_id"];
		 $photo = $_POST["photo"];
		 
		 $photo = $_POST['photo'];
		 if(file_exists($photo)) {
			 unlink($photo);
			 echo 'File '.$photo.' has been deleted';
			 $query = "UPDATE parents SET photo = 'default' WHERE parent_id = '$parent_id';";
			 queryMysql($query);
		 } else {
			 echo 'Could not delete '.$photo.', file does not exist';
		 }
	 }
	 else if($action == "deleteparent"){
		 $parent_id = $_POST["parent_id"];
		 $photo = $_POST['photo'];
		 
		 $query = "DELETE FROM studentparent WHERE parent_id = '$parent_id'";queryMysql($query);
		 $query = "DELETE FROM parents WHERE parent_id = '$parent_id'";queryMysql($query);
		 
		 if(file_exists($photo)) {
			 unlink($photo);
			 echo 'File '.$photo.' has been deleted';
		 } else {
			 echo 'Could not delete '.$photo.', file does not exist';
		 }
	 } 
	 else if($action == "deleteparentassociation"){
		 $student_id = $_POST["student_id"];
		 $parent_id = $_POST["parent_id"];
		 
		 $query = "DELETE FROM studentparent WHERE parent_id = '$parent_id' AND student_id = '$student_id'";queryMysql($query);
	 }
	 else if($action == "assignstudenttoparent"){
		 $parent_id = $_POST["parent_id"];
		 $student_id = $_POST['student_id'];
		 $relationship = $_POST["relationship"];
		 
		 $query1 = "SELECT MAX(studentparent_id) FROM studentparent";
		 $result1 = mysql_query($query1);
		 if(!$result1) die("DB access failed(derro internal error): " . mysql_error());
		 $row1 = mysql_fetch_row($result1);
		 $studentparent_id = $row1[0]+1;
						 
		 $query2 = "INSERT INTO studentparent VALUES('$studentparent_id', '$parent_id', '$student_id', '$relationship')";
		 queryMysql($query2);
	 }
	 /*Searchng student and making payment*/
	 else if($action == "searchstudentandmakepayment"){
		 $parent_id = $_POST["parent_id"];
		 $relationship = $_POST["relationship"];
		 
		 if (isset($_POST['student_name'])) {
			 $search = $_POST['student_name'];
		     
			  echo "<div class=\"displaysearchstudentandmakepayment\" style=\"width:690px;\">";
					 echo "<p style=\"padding:10px;background-color:#456784;color:white;width:670px;\">
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
								 
				 echo "<li><a href=\"javascript:void(0);assignStudentToParent($student_id, $parent_id, '$relationship')\">
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
	 else if($action == "saveparentsdata"){
		 
		 $parent_firstname = $_POST["parent_firstname"];$parent_firstname = sanitizeString($parent_firstname);$parent_firstname = string_to_uppecase($parent_firstname);
		 $parent_lastname = $_POST["parent_lastname"];$parent_lastname = sanitizeString($parent_lastname);$parent_lastname = string_to_uppecase($parent_lastname);
		 $gender = $_POST["gender"];$gender = sanitizeString($gender);$gender = string_to_uppecase($gender);
		 $address = $_POST["address"];$address = sanitizeString($address);$address = string_to_uppecase($address);
		 $phone = $_POST["phone"];$phone = sanitizeString($phone);
		 $phone_alt = $_POST["phone_alt"];$phone_alt = sanitizeString($phone_alt);
		 $email = $_POST["email"];$email = sanitizeString($email);
		 $parent_id = $_POST["parent_id"];$parent_id = sanitizeString($parent_id);
		 
		 $query = "UPDATE parents SET parent_firstname = '$parent_firstname' WHERE parent_id = '$parent_id'";queryMysql($query);
		 $query = "UPDATE parents SET parent_lastname = '$parent_lastname' WHERE parent_id = '$parent_id'";queryMysql($query);
		 $query = "UPDATE parents SET gender = '$gender' WHERE parent_id = '$parent_id'";queryMysql($query);
		 $query = "UPDATE parents SET address = '$address' WHERE parent_id = '$parent_id'";queryMysql($query);
		 $query = "UPDATE parents SET phone = '$phone' WHERE parent_id = '$parent_id'";queryMysql($query);
		 $query = "UPDATE parents SET phone_alt = '$phone_alt' WHERE parent_id = '$parent_id'";queryMysql($query);
		 $query = "UPDATE parents SET email = '$email' WHERE parent_id = '$parent_id'";queryMysql($query);
	 }
	 else if($action == "showparentlist"){
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
		 
		 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
			 <span style=\"width:50px;\"><b>ID</b></span>
			 <span style=\"width:150px;\"><b>NAME</b></span>
			 <span style=\"width:80px;\"><b>GENDER</b></span>
			 <span style=\"width:120px;\"><b>ADDRES</b></span>
			 <span style=\"width:90px;\"><b>PHONE</b></span>
			 <span style=\"width:150px;\"><b>EMAIL</b></span> 
		 </p>";
						 
		 $query = "SELECT * FROM parents ORDER BY parent_id ASC LIMIT $start_from, $results_per_page";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 
		 echo "<ul>";
		 while($row=mysql_fetch_array($result)){
			 $parent_id = $row['parent_id'];
			 $parent_firstname = $row['parent_firstname'];
			 $parent_lastname = $row['parent_lastname'];
			 $gender = $row['gender'];
			 $address = $row['address'];
			 $phone = $row['phone'];
			 $email = $row['email'];
								 
			 echo "<li><a href=\"viewparent.php?parent_id=$parent_id\">
				 <span style=\"width:50px;\">$parent_id</span>
				 <span style=\"width:150px;\">$parent_firstname $parent_lastname</span>
				 <span style=\"width:80px;\">$gender</span>
				 <span style=\"width:120px;\">$address</span>
				 <span style=\"width:90px;\">$phone</span>
				 <span style=\"width:90px;\">$email</span>
				 </a>
			 </li>";
		 }
		 echo "</ul>";
		 
		 $query = "SELECT COUNT(parent_id) FROM parents";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
						 
		 $row = mysql_fetch_row($result);
		 echo "<div id=\"list-footer\">";
		 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
		 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
			 echo "<a href=\"javascript:moreParents($i)\"";
			 if ($i==$page)  
				 echo " class='curPage'";
			 echo ">$i</a> ";
		 };
		 echo "</div>";
	 }
	 else if($action == "showparentlistaftersearch") {
		 $search_parent = $_POST["search_parent"];
		 $search_parent = sanitizeString($search_parent);
		 
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
		 
		 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
			 <span style=\"width:50px;\"><b>ID</b></span>
			 <span style=\"width:150px;\"><b>NAME</b></span>
			 <span style=\"width:80px;\"><b>GENDER</b></span>
			 <span style=\"width:120px;\"><b>ADDRES</b></span>
			 <span style=\"width:90px;\"><b>PHONE</b></span>
			 <span style=\"width:150px;\"><b>EMAIL</b></span> 
		 </p>";
						 
		 $query = "SELECT * FROM parents WHERE parent_firstname LIKE '%$search_parent%' OR parent_lastname LIKE '%$search_parent%'
		 ORDER BY parent_id ASC LIMIT $start_from, $results_per_page";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 
		 echo "<ul>";
		 while($row=mysql_fetch_array($result)){
			 $parent_id = $row['parent_id'];
			 $parent_firstname = $row['parent_firstname'];
			 $parent_lastname = $row['parent_lastname'];
			 $gender = $row['gender'];
			 $address = $row['address'];
			 $phone = $row['phone'];
			 $email = $row['email'];
								 
			 echo "<li><a href=\"viewparent.php?parent_id=$parent_id\">
				 <span style=\"width:50px;\">$parent_id</span>
				 <span style=\"width:150px;\">$parent_firstname $parent_lastname</span>
				 <span style=\"width:80px;\">$gender</span>
				 <span style=\"width:120px;\">$address</span>
				 <span style=\"width:90px;\">$phone</span>
				 <span style=\"width:90px;\">$email</span>
				 </a>
			 </li>";
		 }
		 echo "</ul>";
		 
		 $query = "SELECT COUNT(parent_id) FROM parents WHERE parent_firstname LIKE '%$search_parent%' OR parent_lastname LIKE '%$search_parent%'";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
						 
		 $row = mysql_fetch_row($result);
		 echo "<div id=\"list-footer\">";
		 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
		 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
			 echo "<a href=\"javascript:moreSearchParents($i)\"";
			 if ($i==$page)  
				 echo " class='curPage'";
			 echo ">$i</a> ";
		 };
		 echo "</div>";
	 }