<?php	 
     require_once '../system/database/db_required/functions.php';
	 session_start();
	 if(isset($_SESSION['username']))
	 {
		 destroySession();
		 header('Location: ../login');		 
		 exit();	 
	 }	 
	 
	 else {	 
	     header('Location: ../login');
	     exit();
	 }
?>