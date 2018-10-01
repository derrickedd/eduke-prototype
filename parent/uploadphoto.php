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
					 

					     if(isset($_GET['parent_id']))
						 {
							 $parent_id = $_GET['parent_id'];
							 /*Photo uploading*/
							 
							 /*Checking for parent names*/
							 $queryex = "SELECT parent_firstname, parent_lastname FROM parents WHERE parent_id = '$parent_id'";
							 $resultex = mysql_query($queryex);
							 if(!$resultex) die("DB access failed(derro internal error): " . mysql_error());
							 $rowsex = mysql_num_rows($resultex);
							 for ($jex = 0 ; $jex < $rowsex ; ++$jex)
							 {
								 $rowex = mysql_fetch_row($resultex);
								 $parent_firstname = $rowex[0];
								 $parent_lastname = $rowex[1];
							 }
							 /*END of for parent names*/
							 
							 if(basename($_FILES['fileToUpload']['name'])) {
								 $target_dir = "parent photos/";
								 $filename  = basename($_FILES['fileToUpload']['name']);
								 $imageFileType = pathinfo($filename,PATHINFO_EXTENSION);
								 $target_file = $target_dir . $parent_id . '-' . $parent_firstname . '-' . $parent_lastname . '.' .$imageFileType;
								 $uploadOk = 1;
								 $errorlog = "";
								 
								 // Check if image file is a actual image or fake image
								 if(isset($_POST["fileToUpload"])) {
									 $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
									 if($check !== false) {
										$errorlog .= "<br>File is an image - " . $check["mime"] . ".";
										$uploadOk = 1;
									 } else {
										$errorlog = "<br>File is not an image.";
										$uploadOk = 0;
									 }
								 }
								 
								 /* Check if file already exists
								 if (file_exists($target_file)) {
									 $errorlog = "Sorry, file already exists.";
									 $uploadOk = 0;echo $errorlog;
								 }*/
								 
								 // Check file size
								 if ($_FILES["fileToUpload"]["size"] > 1200000) {
									 $errorlog .= "<br>Your photo should be less than 1MB";
									 $uploadOk = 0;
								 }
								 
								 // Allow certain file formats
								 if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG"
								 && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif"
								 && $imageFileType != "GIF" ) {
									 $errorlog .= "<br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
									 $uploadOk = 0;
								 }

								 // Check if $uploadOk is set to 0 by an error
								 if ($uploadOk == 0) {
									 echo "<br><br><br><br><br><br><br>";
									 
									 echo "<!doctype html>
										 <html lang=\"en\">
										 <head>
											 <title>Eduke - Photo Failed to Upload</title>
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
											 <h3 style=\"padding:10px;border-bottom:solid 1px #eee;font-size:20px;\">PHOTO WAS NOT UPLOADED</h3>
											 <p style=\"padding:10px;color:red;\">$errorlog</p>
											 </div>
										 </body>
										 </html>
										 ";
										 header("Refresh:5; url=viewparent.php?parent_id=$parent_id");

								 // if everything is ok, try to upload file
								 } else {
									 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
										 $errorlog .= "The photo has been uploaded.";
										 
										 $query = "UPDATE parents SET photo = '$target_file' WHERE parent_id = $parent_id;";
								         queryMysql($query);
										 echo "<br><br><br><br><br><br><br>";
										 
										 echo "<!doctype html>
										 <html lang=\"en\">
										 <head>
											 <title>Eduke - Photo Uploaded</title>
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
											 <h3 style=\"padding:10px;border-bottom:solid 1px #eee;font-size:20px;\">PHOTO UPLOADED</h3>
											 <p style=\"padding:10px;\">Please wait . . .</p>
											 </div>
										 </body>
										 </html>
										 ";
										 header("Refresh:1; url=viewparent.php?parent_id=$parent_id");

									 } else {
										 $errorlog .= "Sorry, there was an error uploading your photo. Try compressing it";
										 
										 echo "<br><br><br><br><br><br><br>";
									 
									     echo "<!doctype html>
										 <html lang=\"en\">
										 <head>
											 <title>Eduke - Photo Failed to Upload</title>
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
											 <h3 style=\"padding:10px;border-bottom:solid 1px #eee;font-size:20px;\">PHOTO WAS NOT UPLOADED</h3>
											 <p style=\"padding:10px;color:red;\">$errorlog</p>
											 </div>
										 </body>
										 </html>
										 ";
										 header("Refresh:5; url=viewparent.php?parent_id=$parent_id");
									 }
								 }
							 }
							 
							 /*END OF PHOTO UPLOADING*/
						 } else {
					     echo "<div style=\"width:600px;margin-left:auto;margin-right:auto;\"><h1>SYSTEM ERROR</h1><br>
						 <p style=\"line-height:2;\"><b>Some thing went wrong while using this system. This maybe as a result of wrong data entry to the system.
						 For assistance check the <a href=\"../../system/guide/guide.php\">Guide</a> or contact the support
						 team if problem persists</b></p></div>";
					 }
?>