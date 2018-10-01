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
						 
					 $query1 = "SELECT MAX(academic_term_id) FROM schoolterm";
					 $result = mysql_query($query1);
					 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
					 $row = mysql_fetch_row($result);
					 $academic_term_id = $row[0];
					 
					 $query1 = "SELECT academic_year, academic_term FROM schoolterm WHERE academic_term_id = '$academic_term_id'";
					 $result = mysql_query($query1);
					 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
					 $row = mysql_fetch_row($result);
					 $academic_year = $row[0];
					 $academic_term = $row[1];
					 

					 
					 /*start with the PHP code*/
	 
					 $examtypes_id = $exam_name = $exam_abreviation = $description = "";
	 
					 if (isset($_POST['exam_name']))
						 $exam_name = sanitizeString($_POST['exam_name']);
					 if (isset($_POST['exam_abreviation'])){
						 $exam_abreviation = sanitizeString($_POST['exam_abreviation']);
					     $exam_abreviation = sanitizeString($exam_abreviation);}
					 if(isset($_POST['description']))
						 $description = sanitizeString($_POST['description']);
					 
					 

					 $fail = validate_exam_name($exam_name);
					 $fail .= validate_exam_abreviation($exam_abreviation);
					 $fail .= validate_description($description);
					 
					 if ($fail == "")
					 {
						 $query1 = "SELECT MAX(examtypes_id) FROM examtypes";
						 $result = mysql_query($query1);
						 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 $row = mysql_fetch_row($result);
						 $examtypes_id = $row[0]+1;
						 
					     $query2 = "INSERT INTO examtypes VALUES('$examtypes_id', '$exam_name', '$exam_abreviation', '$description')";
						 queryMysql($query2);
						 
						 echo "<br><br><br><br><br><br><br>";
						 
						 echo "<!doctype html>
							 <html lang=\"en\">
							 <head>
								 <title>Eduke - Exam Type Added</title>
								 <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/index.css\">
								 <script rel=\"text/javascript\" src=\"../../system/scripts/jquery-1.11.1.min.js\"></script>
								 <script rel=\"text/javascript\" src=\"../../system/scripts/jquery-ui-1.10.4.min.js\"></script>
								 <script rel=\"text/javascript\" src=\"../../system/scripts/jQueryRotate.js\"></script>
								 <script rel=\"text/javascript\" src=\"../../system/scripts/library.js\"></script>
								 <script rel=\"text/javascript\" src=\"../../system/scripts/jquery.spritely.js\"></script>
							 </head>
							 <body>
						 
						 <div style=\"width:300px;margin-left:auto;margin-right:auto;background-color:#fff;padding:10px;
						 border:solid 1px silver;\">
						 <h3 style=\"padding:10px;border-bottom:solid 1px #eee;font-size:20px;\">EXAM TYPE ADDED</h3>
						 <p style=\"padding:10px;\">Please wait . . .</p>
						 </div>
						 </body>
						 </html>
						 ";
						 
						 header("Refresh:1; url=examtype.php");
					 }
					 else{
						 echo $fail;
					 }
					 
					 
	 // Finally, here are the PHP functions
	 
     function validate_exam_name($field)
	 {
         if ($field == "") return "No Student Last name was entered<br />";
         return "";
     }
	 
	 function validate_exam_abreviation($field)
	 {
         if ($field == "") return "No Gender was entered<br />";
         return "";
     }
	 
	 
	 function validate_description($field)
	 {
         if ($field == "") return "No Class was entered<br />";
         return "";
     }
             ?>