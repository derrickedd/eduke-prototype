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
	 if($action == "addnotice") {
		 
		 $notice_title = $_POST["notice_title"];$notice_title = sanitizeString($notice_title);$notice_title = string_to_uppecase($notice_title);
         $notice_message = $_POST["notice_message"];$notice_message = sanitizeString($notice_message);
         $notice_term = $_POST["notice_term"];
		 
		 $query1 = "SELECT MAX(notice_id) FROM noticeboard";
		 $result = mysql_query($query1);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $row = mysql_fetch_row($result);
		 $notice_id = $row[0]+1;
		 
		 $query=mysql_query("INSERT INTO noticeboard(notice_id, notice_title, notice_message, date_of_notice, academic_term_id) 
		                      VALUES('$notice_id', '$notice_title', '$notice_message', now(), '$notice_term')");
 
		 if($query){
			echo "Notice is added";
		 }
		 else{
			echo "Notice is not added";
		 }
		 
	 }
	 /*Showing a notice*/
	 else if($action == "shownotice"){
		 $term_id=$_POST["term_id"];
		 
		 $query = "SELECT * FROM noticeboard WHERE academic_term_id = '$term_id' ORDER BY notice_id DESC";
		 $result = mysql_query($query);
		 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
		 $rows = mysql_num_rows($result);
									 
		 echo "<h2>NOTICES</h2>";
		 echo "<div id=\"noticeboard-box\">";
		 for ($j = 0 ; $j < $rows ; ++$j)
		 {
			 $row = mysql_fetch_row($result);
												 
			 echo "<div class=\"notice-title\">
			 <img src=\"../../system/images/sys-nav/close.png\" height=\"40\"style=\"float:right;padding:5px;
			 cursor:pointer;\" id=\"$row[0]\" onclick=\"deleteNoticeFunction(this, $term_id)\">
			 
			 <p style=\"font-size:14px;font-weight:bold;border-bottom:solid 2px #33333f;\">$row[3]</p>
			 <p>$row[0]: <b>$row[1]</b></p>
			 <p><span style=\"font-weight:lighter;padding:3px;\">$row[2]</span></p>
		     </div>";
         }
	 }
	 /*Deleting notice*/
	 else if($action == "deletenotice"){
		 $notice_id=$_POST["notice_id"];
	 
		 $query=mysql_query("DELETE FROM noticeboard WHERE notice_id = '$notice_id'");
	 
		 if($query){
			 echo "Your comment has been sent";
		 }
		 else{
			 echo "Error in sending your comment";
		 }
     }
     
?>