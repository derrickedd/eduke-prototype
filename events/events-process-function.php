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
     
	 if($action == "deleteevent"){
		 $events_id = $_POST["events_id"];
		 
		 $query = "DELETE FROM events WHERE events_id = '$events_id'";queryMysql($query);
	 }
	 else if($action == "showeventslist"){
		 $results_per_page = 20; /* number of results per page*/
		 if (isset($_POST["page"])) { 
		     $page  = $_POST["page"]; 
		 } else { 
			 $page=1; 
		 }
		 $start_from = ($page-1) * $results_per_page;
	     
		 echo "<div id=\"list-semester-overide\">";
			 echo "<p style=\"padding:10px;background-color:#456784;color:white;\">
							 <span style=\"width:50px;\"><b>ID</b></span>
							 <span style=\"width:150px;\"><b>EVENTS NAME</b></span>
							 <span style=\"width:250px;\"><b>DESCRIPTION</b></span>
							 <span style=\"width:100px;\"><b>DATE</b></span>
							 <span style=\"width:120px;\"><b>ACADEMIC TERM</b></span>
							 
						 </p>";
						 
						 $query = "SELECT * FROM events ORDER BY events_id DESC LIMIT $start_from, $results_per_page";
						 $result = mysql_query($query);
						 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 
						 echo "<ul>";
							 while($row=mysql_fetch_array($result)){
								 $events_id = $row['events_id'];
								 $events_name = $row['events_name'];
								 $description = $row['description'];
								 $event_date = $row['event_date'];
								 $academic_term_id = $row['academic_term_id'];
								 
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
								 if($rowsex == ""){
									 $academic_year = "";
									 $academic_term = "";
								 }
								 /*END of Checking for admission_date*/
								 
								 echo "<li>
									 <span style=\"width:50px;\">$events_id</span>
									 <span style=\"width:150px;\">$events_name</span>
									 <span style=\"width:250px;background-color:#555;color:#fff;padding:5px;line-height:21px;border-radius:3px;\">$description</span>
									 <span style=\"width:100px;\">$event_date</span>
									 <span style=\"width:120px;\">$academic_year - $academic_term</span>
									 
									 <span style=\"width:100px;\">
									 <input style=\"width:100px;background-color:#33333f;color:red;cursor:pointer;padding:5px;margin:0px;border-radius:3px;\" 
										 type=\"button\" value=\"Delete\" onclick=deleteEvent($events_id)>
									 </span>
								 </li>";
							 }
						 echo "</ul>";
		 
		 $query = "SELECT COUNT(events_id) FROM events";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
						 
		 $row = mysql_fetch_row($result);
		 echo "<div id=\"list-footer\">";
		 $total_pages = ceil($row[0] / $results_per_page); // calculate total pages with results
							  
		 for ($i=1; $i<=$total_pages; $i++) {  // print links for all pages
			 echo "<a href=\"javascript:moreEvents($i)\"";
			 if ($i==$page)  
				 echo " class='curPage'";
			 echo ">$i</a> ";
		 };
		 echo "</div>";
	 }