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
		 header('Location: ../../login');
	 }
	 
	 $db_server = mysql_connect($db_hostname, $db_username, $db_password);
	 if(!$db_server) die("Unable to connect to MySQL: ". mysql_error());
	 
	 mysql_select_db($db_database) 
	     or die("Unable to select database; ".mysql_error());
 
     $action=$_POST["action"];
     
	 /*Adding a notice*/
	 if($action == "applyrestore"){
		 $file = $_POST["file"];
		 
		 $restore_file  = "$file";
		 $server_name   = "localhost";
		 $username      = "root";
		 $password      = "";
		 $database_name = "schooldb";

		 $cmd= "C:\wamp\bin\mysql\mysql5.5.8\bin\mysql.exe --user $username $database_name < files/" . $restore_file;
		 exec($cmd);
	 }
	 else if($action == "deleterestore"){
		 $file = $_POST["file"];
		 
		 $filelocation = "files" . '/' .$file;
		 
		 if(file_exists($filelocation)) {
			 unlink($filelocation);
			 echo 'Restore File '.$photo.' has been deleted';
		 } else {
			 echo 'Could not delete '.$filelocation.', file does not exist';
		 }
	 }
	 
		