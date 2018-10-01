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
	 if($action == "deleteschoolphoto"){
		 $school_id = $_POST["school_id"];
		 $photo = $_POST["photo"];
		 
		 $photo = $_POST['photo'];
		 if(file_exists($photo)) {
			 unlink($photo);
			 echo 'File '.$photo.' has been deleted';
			 $query = "UPDATE settings SET school_logo = 'default' WHERE school_id = '$school_id';";
			 queryMysql($query);
		 } else {
			 echo 'Could not delete '.$photo.', file does not exist';
		 }
	 }
	 else if($action == "savesettingsdata"){
		 
		 $school_name = $_POST["school_name"];$school_name = sanitizeString($school_name);$school_name = string_to_uppecase($school_name);
		 $school_address = $_POST["school_address"];$school_address = sanitizeString($school_address);
		 $school_po_box = $_POST["school_po_box"];$school_po_box = sanitizeString($school_po_box);
		 $school_phone = $_POST["school_phone"];$school_phone = sanitizeString($school_phone);
		 $school_phone_alt = $_POST["school_phone_alt"];$school_phone_alt = sanitizeString($school_phone_alt);
		 $school_code = $_POST["school_code"];$school_code = sanitizeString($school_code);$school_code = string_to_uppecase($school_code);
		 $school_email = $_POST["school_email"];$school_email = sanitizeString($school_email);
		 $school_email_alt = $_POST["school_email_alt"];$school_email_alt = sanitizeString($school_email_alt);
		 $school_website = $_POST["school_website"];$school_website = sanitizeString($school_website);
		 $school_moto = $_POST["school_moto"];$school_moto = sanitizeString($school_moto);
		 $number_of_terms = $_POST["number_of_terms"];$number_of_terms = sanitizeString($number_of_terms);
		 $school_id = $_POST["school_id"];$school_id = sanitizeString($school_id);
		 
		 $query = "UPDATE settings SET school_name = '$school_name' WHERE school_id = '$school_id';";queryMysql($query);
		 $query = "UPDATE settings SET school_address = '$school_address' WHERE school_id = '$school_id';";queryMysql($query);
		 $query = "UPDATE settings SET school_po_box = '$school_po_box' WHERE school_id = '$school_id';";queryMysql($query);
		 $query = "UPDATE settings SET school_phone = '$school_phone' WHERE school_id = '$school_id';";queryMysql($query);
		 $query = "UPDATE settings SET school_phone_alt = '$school_phone_alt' WHERE school_id = '$school_id';";queryMysql($query);
		 $query = "UPDATE settings SET school_code = '$school_code' WHERE school_id = '$school_id';";queryMysql($query);
		 $query = "UPDATE settings SET school_email = '$school_email' WHERE school_id = '$school_id';";queryMysql($query);
		 $query = "UPDATE settings SET school_email_alt = '$school_email_alt' WHERE school_id = '$school_id';";queryMysql($query);
		 $query = "UPDATE settings SET school_website = '$school_website' WHERE school_id = '$school_id';";queryMysql($query);
		 $query = "UPDATE settings SET school_moto = '$school_moto' WHERE school_id = '$school_id';";queryMysql($query);
		 $query = "UPDATE settings SET number_of_terms = '$number_of_terms' WHERE school_id = '$school_id';";queryMysql($query);
	 }