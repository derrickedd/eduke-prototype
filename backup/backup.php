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
					 
					  

				 
				 echo "<!doctype html>
							 <html lang=\"en\">
							 <head>
								 <title>Eduke - System Back Up</title>
								 <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/index.css\">
								 <script rel=\"text/javascript\" src=\"../../system/scripts/jquery-1.11.1.min.js\"></script>
								 <script rel=\"text/javascript\" src=\"../../system/scripts/jquery-ui-1.10.4.min.js\"></script>
								 <script rel=\"text/javascript\" src=\"../../system/scripts/jQueryRotate.js\"></script>
								 <script rel=\"text/javascript\" src=\"../../system/scripts/library.js\"></script>
								 <script rel=\"text/javascript\" src=\"../../system/scripts/jquery.spritely.js\"></script>
							 </head>
							 <body>
						 
								 <div style=\"margin-top:100px;background-color:#fff;padding:10px;width:350px;margin-left:auto;margin-right:auto;
								 border:solid 1px silver;\">
									 <h3 style=\"padding:15px!important;text-align:left!important;background-color:#fff;color:#111;
									 font-size:17px;margin-bottom:10px;border-bottom:solid 1px #999;\">BACK UP</h3>
									 <p style=\"padding:10px;\">Your data is backing up. Please wait...</p>
								 </div>
							 </body>
							 </html>
						 ";

					 $eduke = "eduke";

					 $server_name   = "localhost";
					 $username      = "root";
					 $password      = "";
					 $database_name = "schooldb";
					 $date_string   = date("Ymd");

					 $cmd= "C:\wamp\bin\mysql\mysql5.5.8\bin\mysqldump.exe --user $username $database_name > files/". $date_string. "-" .
					 time() ."$eduke"."_backup.sql";
					 exec($cmd);
					 header("Refresh:1; url=../settings/settings.php");
			     ?>
