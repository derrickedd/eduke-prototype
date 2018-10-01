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
					 
					 
				  
					 
				 $parent_id = $parent_firstname = $parent_lastname = $gender = $address = $phone = $phone_alt = $email = 
				 $password = $photo = "";
	 
	                 if(isset($_POST['parent_firstname'])){
						 $parent_firstname = sanitizeString($_POST['parent_firstname']);
					     $parent_firstname = string_to_uppecase($parent_firstname);}
					 if(isset($_POST['parent_lastname'])){
						 $parent_lastname = sanitizeString($_POST['parent_lastname']);
					     $parent_lastname = string_to_uppecase($parent_lastname);}
					 if (isset($_POST['gender'])){
						 $gender = sanitizeString($_POST['gender']);
					     $gender = string_to_uppecase($gender);}
					 if(isset($_POST['address'])){
						 $address = sanitizeString($_POST['address']);
					     $address = string_to_uppecase($address);}
					 if(isset($_POST['phone'])){
					     $phone = sanitizeString($_POST['phone']);}
					 if(isset($_POST['phone_alt'])){
					     $phone_alt = sanitizeString($_POST['phone_alt']);}
					 if(isset($_POST['email'])){
					     $email = sanitizeString($_POST['email']);}
					 
					 $fail = validate_parent_firstname($parent_firstname);
					 $fail .= validate_parent_lastname($parent_lastname);
					 $fail .= validate_gender($gender);
					 $fail .= validate_address($address);
					 $fail .= validate_phone($phone);
					 
					 if ($phone_alt == '')
					 {/*Do nothing*/} else {
					     $fail .= validate_phone_alt($phone_alt);
					 }
					 $fail .= validate_email($email);
					 
					 if ($fail == "") 
					 {
					     $photo = 'default';
					     $password = 'password';
						 // This is where you would enter the posted fields into a database

						 $query1 = "SELECT MAX(parent_id) FROM parents";
						 $result1 = mysql_query($query1);
						 if(!$result1) die("DB access failed(derro internal error): " . mysql_error());
						 $row1 = mysql_fetch_row($result1);
						 $parent_id = $row1[0]+1;
						 
					     $query2 = "INSERT INTO parents VALUES('$parent_id', '$parent_firstname', '$parent_lastname', '$gender', 
						 '$address', '$phone', '$phone_alt', '$email', '$password','$photo')";
						 queryMysql($query2);
						 
						 echo "<br><br><br><br><br><br><br>";
						 
						 echo "<!doctype html>
							 <html lang=\"en\">
							 <head>
								 <title>Eduke - Parent Added</title>
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
						 <h3 style=\"padding:10px;border-bottom:solid 1px #eee;font-size:20px;\">PARENT ADDED</h3>
						 <p style=\"padding:10px;\">Please wait . . .</p>
						 </div>
						 </body>
						 </html>
						 ";
						 
						 header("Refresh:1; url=viewparent.php?parent_id=$parent_id");
					 }
					 else{
						 echo $fail;
					 }
					 
					 
	 // Finally, here are the PHP functions
     function validate_parent_firstname($field)
	 {
         if ($field == "") return "No Parent firstname was entered<br />";
         return "";
     }
	 
	 function validate_parent_lastname($field)
	 {
         if ($field == "") return "No Parent Lastname Name was entered<br />";
         return "";
     }
	 
     function validate_gender($field)
	 {
         if ($field == "") return "No Gender was entered<br />";
         if ($field == "NONE") return "No Gender was entered<br />";
         return "";
     }
	 
	 function validate_address($field)
	 {
         if ($field == "") return "No address was entered<br />";
         return "";
     }
	 
	 function validate_phone($field)
	 {
         if ($field == "") return "No phone was entered was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid mobile number is needed<br />";
		 if (strlen($field) == 10)
			 return "";
		 else return "Invalid phone number<br />";
         return "";
     }
	 
	 function validate_phone_alt($field)
	 {
         if ($field == "") return "No phone was entered was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid mobile number is needed<br />";
		 if (strlen($field) == 10)
			 return "";
		 else return "Invalid phone number<br />";
         return "";
     }
	 
	 function validate_email($field)
	 {
         if ($field == "") 
		     return "No Email was entered<br />";
         else if (!((strpos($field, ".") > 0) && (strpos($field, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $field))
             return "The Email address is invalid<br />";
         return "";
     }
	 
	 
	 /*
     function validate_username($field)
	 {
         if ($field == "") 
		     return "No Username was entered<br />";
         else if (strlen($field) < 5)
             return "Usernames must be at least 5 characters<br />";
         else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
             return "Only letters, numbers, - and _ in usernames<br />";
         return "";
     }

     function validate_password($field) 
	 {
         if ($field == "") 
		     return "No Password was entered<br />";
         else if (strlen($field) < 6)
             return "Passwords must be at least 6 characters<br />";
         else if ( !preg_match("/[a-z]/", $field) || !preg_match("/[A-Z]/", $field) || !preg_match("/[0-9]/", $field))
             return "Passwords require 1 each of a-z, A-Z and 0-9<br />";
         return "";
     }
	 
     function validate_retypepassword($field) 
	 {
	     if (isset($_POST['password']))
	         $password = fix_string($_POST['password']);    //derro new variable
         if ($field == "") 
		     return "Please retype your password<br />";
         else if ($field != $password)
             return "Your password did not match. please retype<br />";
         return "";
     }
	 
     function validate_email($field) 
	 {
         if ($field == "") 
		     return "No Email was entered<br />";
         else if (!((strpos($field, ".") > 0) && (strpos($field, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $field))
             return "The Email address is invalid<br />";
         return "";
     }*/
?>
	