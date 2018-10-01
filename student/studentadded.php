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
	 
					 $student_id = $admission_number = $student_firstname = $student_lastname = $dateofbirth = $gender = $address = $religion = 
					 $fathers_firstname = $fathers_lastname = $fathers_phone = $fathers_email = $mothers_firstname = $mothers_lastname = 
					 $mothers_phone = $mothers_email = $others_firstname = $others_lastname = $others_phone = $others_email =
					 $house_id = $photo = $class_id =  $status = $academic_term_id = "";
	 
	                 if(isset($_POST['admission_number'])){
						 $admission_number = fix_string($_POST['admission_number']);
					     $admission_number = string_to_uppecase($admission_number);}
					 if(isset($_POST['student_firstname'])){
						 $student_firstname = fix_string($_POST['student_firstname']);
					     $student_firstname = string_to_uppecase($student_firstname);}
					 if (isset($_POST['student_lastname'])){
						 $student_lastname = fix_string($_POST['student_lastname']);
					     $student_lastname = string_to_uppecase($student_lastname);}
					 if (isset($_POST['dateofbirth'])){
					     $dateofbirth = fix_string($_POST['dateofbirth']);}
					 if (isset($_POST['gender'])){
						 $gender = fix_string($_POST['gender']);
					     $gender = string_to_uppecase($gender);}
					 if(isset($_POST['address'])){
						 $address = fix_string($_POST['address']);
					     $address = string_to_uppecase($address);}
					 if(isset($_POST['religion'])){
						 $religion = fix_string($_POST['religion']);
					     $religion = string_to_uppecase($religion);}
					 if(isset($_POST['fathers_firstname'])){
						 $fathers_firstname = fix_string($_POST['fathers_firstname']);
					     $fathers_firstname = string_to_uppecase($fathers_firstname);}
					 if(isset($_POST['fathers_lastname'])){
						 $fathers_lastname = fix_string($_POST['fathers_lastname']);
					     $fathers_lastname = string_to_uppecase($fathers_lastname);}
					 if(isset($_POST['fathers_phone'])){
					     $fathers_phone = fix_string($_POST['fathers_phone']);}
					 if(isset($_POST['fathers_email'])){
					     $fathers_email = fix_string($_POST['fathers_email']);}
					 if(isset($_POST['mothers_firstname'])){
						 $mothers_firstname = fix_string($_POST['mothers_firstname']);
					     $mothers_firstname = string_to_uppecase($mothers_firstname);}
					 if(isset($_POST['mothers_lastname'])){
						 $mothers_lastname = fix_string($_POST['mothers_lastname']);
					     $mothers_lastname = string_to_uppecase($mothers_lastname);}
					 if(isset($_POST['mothers_phone'])){
					     $mothers_phone = fix_string($_POST['mothers_phone']);}
					 if(isset($_POST['mothers_email'])){
					     $mothers_email = fix_string($_POST['mothers_email']);}
					 if(isset($_POST['others_firstname'])){
						 $others_firstname = fix_string($_POST['others_firstname']);
					     $others_firstname = string_to_uppecase($others_firstname);}
					 if(isset($_POST['others_lastname'])){
						 $others_lastname = fix_string($_POST['others_lastname']);
					     $others_lastname = string_to_uppecase($others_lastname);}
					 if(isset($_POST['others_phone'])){
					     $others_phone = fix_string($_POST['others_phone']);}
					 if(isset($_POST['others_email'])){
					     $others_email = fix_string($_POST['others_email']);}
					 if(isset($_POST['house_id'])){
						 $house_id = fix_string($_POST['house_id']);}
					 if(isset($_POST['class_id'])){
						 $class_id = fix_string($_POST['class_id']);}
					 if(isset($_POST['academic_term_id'])){
						 $academic_term_id = fix_string($_POST['academic_term_id']);}
					 
					 $fail = validate_admission_number($admission_number);
					 $fail .= validate_student_firstname($student_firstname);
					 $fail .= validate_student_lastname($student_lastname);
					 $fail .= validate_dateofbirth($dateofbirth);
					 $fail .= validate_gender($gender);
					 $fail .= validate_address($address);
					 $fail .= validate_religion($religion);
					 
					 if (($fathers_firstname == '') || ($fathers_lastname == '') || ($fathers_phone == '') || ($fathers_email == ''))
					 {/*Do nothing*/} else {
						 $fail .= validate_fathers_firstname($fathers_firstname);
						 $fail .= validate_fathers_lastname($fathers_lastname);
						 $fail .= validate_fathers_phone($fathers_phone);
						 $fail .= validate_fathers_email($fathers_email);
					 }
					 
					 if (($mothers_firstname == '') || ($mothers_lastname == '') || ($mothers_phone == '') || ($mothers_email == ''))
					 {/*Do nothing*/} else {
						 $fail .= validate_mothers_firstname($mothers_firstname);
						 $fail .= validate_mothers_lastname($mothers_lastname);
						 $fail .= validate_mothers_phone($mothers_phone);
						 $fail .= validate_mothers_email($mothers_email);
					 }
					 
					 if (($others_firstname == '') || ($others_lastname == '') || ($others_phone == '') || ($others_email == ''))
					 {/*Do nothing*/} else {
						 $fail .= validate_others_firstname($others_firstname);
						 $fail .= validate_others_lastname($others_lastname);
						 $fail .= validate_others_phone($others_phone);
						 $fail .= validate_others_email($others_email);
					 }
					 
					 $fail .= validate_house_id($house_id);
					 $fail .= validate_class_id($class_id);
					 $fail .= validate_academic_term_id($academic_term_id);
					 
					 if ($fail == "") 
					 {
					     $photo = 'default';
					     $status = 'Active';
					     $password = 'password';
						 // This is where you would enter the posted fields into a database
						 
						 $query1 = "SELECT MAX(student_id) FROM schoolstudents";
						 $result1 = mysql_query($query1);
						 if(!$result1) die("DB access failed(derro internal error): " . mysql_error());
						 $row1 = mysql_fetch_row($result1);
						 $student_id = $row1[0]+1;
						 
					     $query2 = "INSERT INTO schoolstudents VALUES('$student_id', '$admission_number', '$student_firstname', '$student_lastname', 
						 '$dateofbirth', '$gender', '$address', '$religion', '$house_id', '$photo', '$class_id','$status')";
						 queryMysql($query2);
						 
						 /*Looking for number of class terms*/
						 $queryq = "SELECT number_of_terms FROM settings WHERE school_id = '1'";
						 $resultq = mysql_query($queryq);
						 if(!$resultq) die("DB access failed(derro internal error): " . mysql_error());
						 $rowsq = mysql_num_rows($resultq);
						 for ($jq = 0 ; $jq < $rowsq ; ++$jq)
						 {
							 $rowq = mysql_fetch_row($resultq);
							 $number_of_terms = $rowq[0]; /*variable for button display*/
						 }
						 /*End of looking for number of class terms*/
						 
						 $academic_term_id_for_increment = $academic_term_id;
						 for ($start = 0; $start < $number_of_terms; ++$start){
							 $query22 = "SELECT MAX(classesenrolled_id) FROM classenrolled";
							 $result22 = mysql_query($query22);
							 if(!$result22) die("DB access failed(derro internal error): " . mysql_error());
							 $row22 = mysql_fetch_row($result22);
							 $classesenrolled_id = $row22[0]+1;
							 
							 $query222 = "INSERT INTO classenrolled VALUES('$classesenrolled_id', '$academic_term_id_for_increment', '$student_id','$class_id')";queryMysql($query222);
						     $academic_term_id_for_increment++;
						 }
						 
					     if (($fathers_firstname == '') || ($fathers_lastname == '') || ($fathers_phone == '') || ($fathers_email == '')) {/*Do nothing*/} else {
							 $query3 = "SELECT MAX(parent_id) FROM parents";
							 $result3 = mysql_query($query3);
							 if(!$result3) die("DB access failed(derro internal error): " . mysql_error());
							 $row3 = mysql_fetch_row($result3);
							 $parent_id = $row3[0]+1;
						 
							 $query4 = "INSERT INTO parents VALUES('$parent_id', '$fathers_firstname', '$fathers_lastname', 'M', 
							 '', '$fathers_phone', '', '$fathers_email', '$password', '$photo')";
							 queryMysql($query4);
							 
							 $query44 = "SELECT MAX(studentparent_id) FROM studentparent";
							 $result44 = mysql_query($query44);
							 if(!$result44) die("DB access failed(derro internal error): " . mysql_error());
							 $row44 = mysql_fetch_row($result44);
							 $studentparent_id = $row44[0]+1;
							 
							 $query4father = "INSERT INTO studentparent VALUES('$studentparent_id', '$parent_id', '$student_id', 'Father')";
							 queryMysql($query4father);
						 }
						 if (($mothers_firstname == '') || ($mothers_lastname == '') || ($mothers_phone == '') || ($mothers_email == '')) {/*Do nothing*/} else {
							 $query3 = "SELECT MAX(parent_id) FROM parents";
							 $result3 = mysql_query($query3);
							 if(!$result3) die("DB access failed(derro internal error): " . mysql_error());
							 $row3 = mysql_fetch_row($result3);
							 $parent_id = $row3[0]+1;
						 
							 $query4 = "INSERT INTO parents VALUES('$parent_id', '$mothers_firstname', '$mothers_lastname', 'F', 
							 '', '$mothers_phone', '', '$mothers_email', '$password', '$photo')";
							 queryMysql($query4);
							 
							 $query44 = "SELECT MAX(studentparent_id) FROM studentparent";
							 $result44 = mysql_query($query44);
							 if(!$result44) die("DB access failed(derro internal error): " . mysql_error());
							 $row44 = mysql_fetch_row($result44);
							 $studentparent_id = $row44[0]+1;
							 
							 $query4mother = "INSERT INTO studentparent VALUES('$studentparent_id', '$parent_id', '$student_id', 'Father')";
							 queryMysql($query4mother);
						 }
						 if (($others_firstname == '') || ($others_lastname == '') || ($others_phone == '') || ($others_email == '')) {/*Do nothing*/} else {
							 $query3 = "SELECT MAX(parent_id) FROM parents";
							 $result3 = mysql_query($query3);
							 if(!$result3) die("DB access failed(derro internal error): " . mysql_error());
							 $row3 = mysql_fetch_row($result3);
							 $parent_id = $row3[0]+1;
						 
							 $query4 = "INSERT INTO parents VALUES('$parent_id', '$others_firstname', '$others_lastname', '', 
							 '', '$others_phone', '', '$others_email', '$password', '$photo')";
							 queryMysql($query4);
							 
							 $query44 = "SELECT MAX(studentparent_id) FROM studentparent";
							 $result44 = mysql_query($query44);
							 if(!$result44) die("DB access failed(derro internal error): " . mysql_error());
							 $row44 = mysql_fetch_row($result44);
							 $studentparent_id = $row44[0]+1;
							 
							 $query4other = "INSERT INTO studentparent VALUES('$studentparent_id', '$parent_id', '$student_id', '')";
							 queryMysql($query4other);
						 }
						 echo "<br><br><br><br><br><br><br>";
						 echo "<!doctype html>
							 <html lang=\"en\">
							 <head>
								 <title>Eduke - Student Added</title>
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
						 <h3 style=\"padding:10px;border-bottom:solid 1px #eee;font-size:20px;\">STUDENT ADDED</h3>
						 <p style=\"padding:10px;\">Please wait . . .</p>
						 </div>
						 </body>
						 </html>
						 ";
						 
						 header("Refresh:3; url=viewstudent.php?student_id=$student_id");
					 }
					 else{
						 echo $fail;
					 }
					 
					 
	 // Finally, here are the PHP functions
     function validate_admission_number($field)
	 {
         if ($field == "") return "No Admission number was entered<br />";
         return "";
     }
	 
	 function validate_student_firstname($field)
	 {
         if ($field == "") return "No Student First Name was entered<br />";
         return "";
     }
	 
     function validate_student_lastname($field)
	 {
         if ($field == "") return "No Student Last name was entered<br />";
         return "";
     }
	 
	 function validate_dateofbirth($field)
	 {
         if ($field == "") return "No date of birth was entered<br />";
         return "";
     }
	 
	 function validate_gender($field)
	 {
         if ($field == "") return "No Gender was entered<br />";
		 if ($field == "SELECT GENDER") return "No gender was entered<br />";
         return "";
     }
	 
	 function validate_address($field)
	 {
         if ($field == "") return "No Address was entered<br />";
         return "";
     }
	 
	 function validate_religion($field)
	 {
         if ($field == "") return "No Religion was entered<br />";
         return "";
     }
	 
	 function validate_fathers_firstname($field)
	 {
         if ($field == "") return "No fathers first name was entered was entered<br />";
         return "";
     }
	 
	 function validate_fathers_lastname($field)
	 {
         if ($field == "") return "No fathers last name was entered was entered<br />";
         return "";
     }
	 
	 function validate_fathers_phone($field)
	 {
         if ($field == "") return "No fathers phone was entered was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid fathers mobile number is needed<br />";
		 if (strlen($field) == 10) 
			 return "";
		 else return "Invalid phone number<br />";
         return "";
     }
	 
	 function validate_fathers_email($field)
	 {
		 if ($field == "") 
		     return "No fathers Email was entered<br />";
         else if (!((strpos($field, ".") > 0) && (strpos($field, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $field))
             return "The Email address is invalid<br />";
         return "";
     }
	 
	 function validate_mothers_firstname($field)
	 {
         if ($field == "") return "No mothers first name was entered was entered<br />";
         return "";
     }
	 
	 function validate_mothers_lastname($field)
	 {
         if ($field == "") return "No Mothers last name was entered<br />";
         return "";
     }
	 
	 function validate_mothers_phone($field)
	 {
         if ($field == "") return "No mothers phone was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid mothers mobile number is needed<br />";
		 if (strlen($field) == 10) 
			 return "";
		 else return "Invalid phone number<br />";
         return "";
     }
	 
	 function validate_mothers_email($field)
	 {
         if ($field == "") 
		     return "No mothers Email was entered<br />";
         else if (!((strpos($field, ".") > 0) && (strpos($field, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $field))
             return "The Email address is invalid<br />";
         return "";
     }
	 
	 function validate_others_firstname($field)
	 {
         if ($field == "") return "No others first name was entered was entered<br />";
         return "";
     }
	 
	 function validate_others_lastname($field)
	 {
         if ($field == "") return "No others last name was entered<br />";
         return "";
     }
	 
	 function validate_others_phone($field)
	 {
         if ($field == "") return "No others phone was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid mothers mobile number is needed<br />";
		 if (strlen($field) == 10) 
			 return "";
		 else return "Invalid phone number<br />";
         return "";
     }
	 
	 function validate_others_email($field)
	 {
         if ($field == "") 
		     return "No others Email was entered<br />";
         else if (!((strpos($field, ".") > 0) && (strpos($field, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $field))
             return "The Email address is invalid<br />";
         return "";
     }
	 
	 function validate_house_id($field)
	 {
         if ($field == "") return "No House was entered<br />";
		 if ($field == "SELECT HOUSE") return "No house was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid house is needed<br />";
         return "";
     }
	 
	 function validate_class_id($field)
	 {
         if ($field == "") return "No Class was entered<br />";
		 if ($field == "SELECT CLASS") return "No class was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid class is needed<br />";
         return "";
     }
	 
	 function validate_academic_term_id($field)
	 {
         if ($field == "") return "No Class was entered<br />";
		 if ($field == "ADMISSION PERIOD") return "No academic period was entered<br />";
		 if (!preg_match("/[0-9]/", $field)) return "A valid academic term is needed<br />";
         return "";
     }
	 
	 function fix_string($string) 
	 {
         if (get_magic_quotes_gpc()) $string = stripslashes($string);
         return htmlentities ($string);
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