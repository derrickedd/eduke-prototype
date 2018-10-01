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

					 
				 $grading2_id = $classlevel_id = $score_type = $max_score = $min_score = "";
				 
	 
					 if (isset($_POST['classlevel_id']))
						 $classlevel_id = sanitizeString($_POST['classlevel_id']);
					 if (isset($_POST['score_type']))
						 $score_type = sanitizeString($_POST['score_type']);
					 if (isset($_POST['max_score']))
						 $max_score = sanitizeString($_POST['max_score']);
					 if (isset($_POST['min_score']))
						 $min_score = sanitizeString($_POST['min_score']);
					 
					 $fail = validate_classlevel_id($classlevel_id);
					 $fail .= validate_score_type($score_type);
					 $fail .= validate_max_score($max_score);
					 $fail .= validate_min_score($min_score);
					 
					 if ($fail == "")
					 {
						 
						 // This is where you would enter the posted fields into a database
						 
						 $query1 = "SELECT MAX(grading2_id) FROM grading2";
						 $result = mysql_query($query1);
						 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
						 $row = mysql_fetch_row($result);
						 $grading2_id = $row[0]+1;
						 
						 if ($score_type == 'A') {$score_value = 1;}
						 elseif ($score_type == 'B') {$score_value = 2;}
						 elseif ($score_type == 'C') {$score_value = 3;}
						 elseif ($score_type == 'D') {$score_value = 4;}
						 elseif ($score_type == 'E') {$score_value = 5;}
						 elseif ($score_type == 'O') {$score_value = 6;}
						 elseif ($score_type == 'F') {$score_value = 7;}
							 
						 $query2 = "INSERT INTO grading2 VALUES('$grading2_id', '$classlevel_id', '$score_type', '$score_value', '$max_score', '$min_score')";
						 queryMysql($query2);
						 
						 echo "<br><br><br><br><br><br><br>";
						 echo "<!doctype html>
							 <html lang=\"en\">
							 <head>
								 <title>Eduke - Subject Grade Added</title>
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
						 <h3 style=\"padding:10px;border-bottom:solid 1px #eee;font-size:20px;\">GRADE ADDED</h3>
						 <p style=\"padding:10px;\">Please wait . . .</p>
						 </div>
						 </body>
						 </html>
						 ";
						 
						 header("Refresh:1; url=gradingtype2.php?classlevel_id=$classlevel_id");
					 }
					 else{
						 echo $fail;
					 }
					 
					 
	 // Finally, here are the PHP functions
	 
	 function validate_classlevel_id($field)
	 {
         if ($field == "") return "No subject was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid class level is needed<br />";
         return "";
     }
	 
	 function validate_score_type($field)
	 {
         if ($field == "") return "No score type was entered<br />";
		 if ($field == "NONE") return "No score type was selected<br />";
         return "";
     }
	 
	 function validate_max_score($field)
	 {
         if ($field == "") return "No score was entered<br />";
         if (!preg_match("/[0-9]/", $field)) return "A valid score is needed<br />";
         return "";
     }
	 
	 function validate_min_score($field)
	 {
         if ($field == "") return "No score was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid score is needed<br />";
         return "";
     }
	 
?>