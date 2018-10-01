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
					 $events_id = $events_name = $description = $event_date = $academic_term_id = 
					 $event_month = $event_day = $event_year = "";
	 
					 if (isset($_POST['events_name'])){
					     $events_name = sanitizeString($_POST['events_name']);
					     $events_name = string_to_uppecase($events_name);}
					 if (isset($_POST['description']))
						 $description = sanitizeString($_POST['description']);
					 if (isset($_POST['academic_term_id']))
						 $academic_term_id = sanitizeString($_POST['academic_term_id']);
					 if (isset($_POST['event_month']))
						 $event_month = sanitizeString($_POST['event_month']);
					 if (isset($_POST['event_day']))
						 $event_day = sanitizeString($_POST['event_day']);
					 if (isset($_POST['event_year']))
						 $event_year = sanitizeString($_POST['event_year']);
					 
					 
					 $fail = validate_events_name($events_name);
					 $fail .= validate_description($description);
					 $fail .= validate_academic_term_id($academic_term_id);
					 $fail .= validate_event_month($event_month);
					 $fail .= validate_event_day($event_day);
					 $fail .= validate_event_year($event_year);
					 
					 if ($fail == "") 
					 {
						 $query1 = "SELECT MAX(events_id) FROM events";
						 $result = mysql_query($query1);
						 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 $row = mysql_fetch_row($result);
						 $events_id = $row[0]+1;
						 
						 $event_date = $event_year . '-' . $event_month . '-' . $event_day;
						 
						 
					     $query2 = "INSERT INTO events VALUES('$events_id', '$events_name', '$description', '$event_date', '$academic_term_id')";
						 queryMysql($query2);
						 
						 echo "<br><br><br><br><br><br><br>";
						
						 echo "<!doctype html>
							 <html lang=\"en\">
							 <head>
								 <title>Eduke - Events Added</title>
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
						 <h3 style=\"padding:10px;border-bottom:solid 1px #eee;font-size:20px;\">EVENT ADDED</h3>
						 <p style=\"padding:10px;\">Please wait . . .</p>
						 </div>
						 </body>
						 </html>
						 ";
						 
						 header("Refresh:1; url=events.php");
					 }
					 else{
						 echo $fail;
					 }
					 
					 
	 // Finally, here are the PHP functions
	 
	 function validate_events_name($field)
	 {
         if ($field == "") return "No events name was entered<br />";
         return "";
     }
	 
	 function validate_description($field)
	 {
         if ($field == "") return "No description was entered<br />";
         return "";
     }
	 
	 function validate_academic_term_id($field)
	 {
         if ($field == "") return "No academic term id was entered<br />";
         if ($field == "NONE") return "No academic term id was entered<br />";
         return "";
     }
	 
	 function validate_event_month($field)
	 {
         if ($field == "") return "No start month was entered<br />";
         return "";
     }
	 
	 function validate_event_day($field)
	 {
         if ($field == "") return "No event day was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid date is needed<br />";
		 if (strlen($field) < 3) 
			 return "";
		 else return "Invalid day is needed<br />";
         return "";
     }
	 
	 function validate_event_year($field)
	 {
         if ($field == "") return "No year was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid year is needed<br />";
		 if (strlen($field) == 4) 
			 return "";
		 else return "Invalid Year<br />";
         return "";
     }
	 
             ?>