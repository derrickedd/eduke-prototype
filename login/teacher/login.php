<?php 
	 require_once '../../system/database/db_required/dblogin.php';
     require_once '../../system/database/db_required/functions.php';
	 
	 session_start();
	 if(isset($_SESSION['teacher_id']) && isset($_SESSION['teacher_firstname']) && isset($_SESSION['teacher_lastname']) && isset($_SESSION['dateofbirth']) 
		 && isset($_SESSION['gender']) && isset($_SESSION['address']) && isset($_SESSION['phone']) && isset($_SESSION['phone_alt'])
	     && isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['photo']))
	 {
		 header( 'Location: ../../user/teacher/dashboard.php' );
	 }
	 
	 $db_server = mysql_connect($db_hostname, $db_username, $db_password);
	 if(!$db_server) die("Unable to connect to MySQL: ". mysql_error());
	 
	 mysql_select_db($db_database) 
	     or die("Unable to select database; ".mysql_error());
	 /*initialising*/
	 
	 
	 if (isset($_POST['username']))
	 {
	     $username = sanitizeString($_POST['username']);
		 $password = sanitizeString($_POST['password']);
		 
		 if ($username == "" || $password == "")
		 {
			 $error = "<p>Not all fields were entered<p>";
	 $page = <<<_END
<!doctype html>
<html lang="en">
<head>
     <title>Eduke - Teacher Login</title>
	 <link rel="stylesheet" type="text/css" href="css/index.css">
	 <script rel="text/javascript" src="../../system/scripts/jquery-1.11.1.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery-ui-1.10.4.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jQueryRotate.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/library.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery.spritely.js"></script>
</head>
<body>
     <div id="frame">
		 <div id="login-box">
		 <img src="../../system/images/eduke.png" width="100"><br><br>
			 <h1>STAFF LOGIN</h1>
			 <h2>Teacher</h2><br>
			 <div class="loginwhitecontent">
				 <div id="displayerror">$error</div>
				 <form action="login.php" method="POST">
					 <p><input type="text" value="" name="username" id="usrlogin" class="username" placeholder="Phone or Email"></p>
					 <p><input type="password" value="" name="password" id="passlogin" class="password" placeholder="Password"></p>
					 <p><input type="submit" value="LOGIN" class="login-button"></p>
					 <p class="reset"><a href="../recover">Recover Account</a> / <a href="../../">Switch User</a></p>
				 </form>
				 <br><br><br><br><br>
				 <div>
			         <p><a href="http://www.derrickedd.com" target="_blank" style="text-decoration:none;color:#fff;font-size:13px;">derrick<b>edd</b> Eduke v2.0</a></p>
			     </div>
			 </div>
		 </div>
	 </div>
	 <script rel="text/javascript" src="../../scripts/library.js"></script>
     <noscript class="nojava">
         <p>LOADING FAILED</p>
	     <p>Please enable javascript on your browser.</p>
     </noscript>
</body>
</html>
_END;
         echo $page;
		 }
		 else
		 {
		     $query = "SELECT * FROM schoolteachers WHERE phone='$username'";
		     $query2 = "SELECT * FROM schoolteachers WHERE email='$username'";
			 
			 $result = mysql_query($query);
			 $result2 = mysql_query($query2);
			 
			 if(!$result) die("DB access failed(derro internal error): " . mysql_error());
			 if(!$result2) die("DB access failed(derro internal error): " . mysql_error());
			 elseif (mysql_num_rows($result))
			 {
			     $row = mysql_fetch_row($result);
				 $salt1 = "qm&h*";
				 $salt2 = "pg!@";
				 $token = md5("$salt1$password$salt2");
				 
				 if($password == $row[9])
				 {
				     session_start();
			         $_SESSION['teacher_id'] = $row[0];
				     $_SESSION['teacher_firstname'] = $row[1];
					 $_SESSION['teacher_lastname'] = $row[2];
					 $_SESSION['dateofbirth'] = $row[3];
					 $_SESSION['gender'] = $row[4];
					 $_SESSION['address'] = $row[5];
					 $_SESSION['phone'] = $row[6];
					 $_SESSION['phone_alt'] = $row[7];
					 $_SESSION['email'] = $row[8];
					 $_SESSION['password'] = $row[9];
					 $_SESSION['photo'] = $row[10];
					 
					 header( 'Location: ../../user/teacher/dashboard.php' );
					 exit();
				     //die("You are now logged in.");
				 }
				 else 
				 {
					 $error = "<p>Invalid username / password<p>";
	                 $page = <<<_END
<!doctype html>
<html lang="en">
<head>
     <title>Eduke - Teacher Login</title>
	 <link rel="stylesheet" type="text/css" href="css/index.css">
	 <script rel="text/javascript" src="../../system/scripts/jquery-1.11.1.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery-ui-1.10.4.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jQueryRotate.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/library.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery.spritely.js"></script>
</head>
<body>
     <div id="frame">
		 <div id="login-box">
		 <img src="../../system/images/eduke.png" width="100"><br><br>
			 <h1>STAFF LOGIN</h1>
			 <h2>Teacher</h2><br>
			 <div class="loginwhitecontent">
				 <div id="displayerror">$error</div>
				 <form action="login.php" method="POST">
					 <p><input type="text" value="" name="username" id="usrlogin" class="username" placeholder="Phone or Email"></p>
					 <p><input type="password" value="" name="password" id="passlogin" class="password" placeholder="Password"></p>
					 <p><input type="submit" value="LOGIN" class="login-button"></p>
					 <p class="reset"><a href="../recover">Recover Account</a> / <a href="../../">Switch User</a></p>
				 </form>
				 <br><br><br><br><br>
				 <div>
			         <p><a href="http://www.derrickedd.com" target="_blank" style="text-decoration:none;color:#fff;font-size:13px;">derrick<b>edd</b> Eduke v2.0</a></p>
			     </div>
			 </div>
		 </div>
	 </div>
	 <script rel="text/javascript" src="../../scripts/library.js"></script>
     <noscript class="nojava">
         <p>LOADING FAILED</p>
	     <p>Please enable javascript on your browser.</p>
     </noscript>
</body>
</html>
_END;
					 die($page); //invalid password 
				 }
			 }
			 elseif (mysql_num_rows($result2))
			 {
			     $row = mysql_fetch_row($result2);
				 $salt1 = "qm&h*";
				 $salt2 = "pg!@";
				 $token = md5("$salt1$password$salt2");
				 
				 if($password == $row[9])
				 {
				     session_start();
			         $_SESSION['teacher_id'] = $row[0];
				     $_SESSION['teacher_firstname'] = $row[1];
					 $_SESSION['teacher_lastname'] = $row[2];
					 $_SESSION['dateofbirth'] = $row[3];
					 $_SESSION['gender'] = $row[4];
					 $_SESSION['address'] = $row[5];
					 $_SESSION['phone'] = $row[6];
					 $_SESSION['phone_alt'] = $row[7];
					 $_SESSION['email'] = $row[8];
					 $_SESSION['password'] = $row[9];
					 $_SESSION['photo'] = $row[10];
					 
					 header( 'Location: ../../user/teacher/dashboard.php' );
					 exit();
				     //die("You are now logged in.");
				 }
				 else //invalid password
				 {
				     
					 $error = "<p>Invalid username / password<p>";
	                 $page = <<<_END
<!doctype html>
<html lang="en">
<head>
     <title>Eduke - Teacher Login</title>
	 <link rel="stylesheet" type="text/css" href="css/index.css">
	 <script rel="text/javascript" src="../../system/scripts/jquery-1.11.1.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery-ui-1.10.4.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jQueryRotate.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/library.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery.spritely.js"></script>
</head>
<body>
     <div id="frame">
		 <div id="login-box">
		     <img src="../../system/images/eduke.png" width="100"><br><br>
			 <h1>STAFF LOGIN</h1>
			 <h2>Teacher</h2><br>
			 <div class="loginwhitecontent">
				 <div id="displayerror">$error</div>
				 <form action="login.php" method="POST">
					 <p><input type="text" value="" name="username" id="usrlogin" class="username" placeholder="Phone or Email"></p>
					 <p><input type="password" value="" name="password" id="passlogin" class="password" placeholder="Password"></p>
					 <p><input type="submit" value="LOGIN" class="login-button"></p>
					 <p class="reset"><a href="../recover">Recover Account</a> / <a href="../../">Switch User</a></p>
				 </form>
				 <br><br><br><br><br>
				 <div>
			         <p><a href="http://www.derrickedd.com" target="_blank" style="text-decoration:none;color:#fff;font-size:13px;">derrick<b>edd</b> Eduke v2.0</a></p>
			     </div>
			 </div>
		 </div>
	 </div>
	 <script rel="text/javascript" src="../../scripts/library.js"></script>
     <noscript class="nojava">
         <p>LOADING FAILED</p>
	     <p>Please enable javascript on your browser.</p>
     </noscript>
</body>
</html>
_END;
					 echo $page;
				 }
			 }
			 else //invalid username
			 {
			     /*$error = "second Invalid username/password combnation";*/
				 $error = "Invalid username / password";
	 $page = <<<_END
<!doctype html>
<html lang="en">
<head>
     <title>Eduke - Teacher Login</title>
	 <link rel="stylesheet" type="text/css" href="css/index.css">
	 <script rel="text/javascript" src="../../system/scripts/jquery-1.11.1.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery-ui-1.10.4.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jQueryRotate.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/library.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery.spritely.js"></script>
</head>
<body>
     <div id="frame">
		 <div id="login-box">
		     <img src="../../system/images/eduke.png" width="100"><br><br>
			 <h1>STAFF LOGIN</h1>
			 <h2>Teacher</h2><br>
			 <div class="loginwhitecontent">
				 <div id="displayerror">$error</div>
				 <form action="login.php" method="POST">
					 <p><input type="text" value="" name="username" id="usrlogin" class="username" placeholder="Phone or Email"></p>
					 <p><input type="password" value="" name="password" id="passlogin" class="password" placeholder="Password"></p>
					 <p><input type="submit" value="LOGIN" class="login-button"></p>
					 <p class="reset"><a href="../recover">Recover Account</a> / <a href="../../">Switch User</a></p>
				 </form>
				 <br><br><br><br><br>
				 <div>
			         <p><a href="http://www.derrickedd.com" target="_blank" style="text-decoration:none;color:#fff;font-size:13px;">derrick<b>edd</b> Eduke v2.0</a></p>
			     </div>
			 </div>
		 </div>
	 </div>
	 <script rel="text/javascript" src="../../scripts/library.js"></script>
     <noscript class="nojava">
         <p>LOADING FAILED</p>
	     <p>Please enable javascript on your browser.</p>
     </noscript>
</body>
</html>
_END;
				 echo $page;
			 }
		 }
	 }
	 else
	 {
		 /*$error = "<p>Invalid username / password.<p>";*/
		 $error = "";
	 $page = <<<_END
<!doctype html>
<html lang="en">
<head>
     <title>Eduke - Teacher Login</title>
	 <link rel="stylesheet" type="text/css" href="css/index.css">
	 <script rel="text/javascript" src="../../system/scripts/jquery-1.11.1.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery-ui-1.10.4.min.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jQueryRotate.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/library.js"></script>
	 <script rel="text/javascript" src="../../system/scripts/jquery.spritely.js"></script>
</head>
<body>
     <div id="frame">
		 <div id="login-box">
		     <img src="../../system/images/eduke.png" width="100"><br><br>
			 <h1>STAFF LOGIN</h1>
			 <h2>Teacher</h2><br>
			 <div class="loginwhitecontent">
				 <div id="displayerror">$error</div>
				 <form action="login.php" method="POST">
					 <p><input type="text" value="" name="username" id="usrlogin" class="username" placeholder="Phone or Email"></p>
					 <p><input type="password" value="" name="password" id="passlogin" class="password" placeholder="Password"></p>
					 <p><input type="submit" value="LOGIN" class="login-button"></p>
					 <p class="reset"><a href="../recover">Recover Account</a> / <a href="../../">Switch User</a></p>
				 </form>
				 <br><br><br><br><br>
				 <div>
			         <p><a href="http://www.derrickedd.com" target="_blank" style="text-decoration:none;color:#fff;font-size:13px;">derrick<b>edd</b> Eduke v2.0</a></p>
			     </div>
			 </div>
		 </div>
	 </div>
	 <script rel="text/javascript" src="../../scripts/library.js"></script>
     <noscript class="nojava">
         <p>LOADING FAILED</p>
	     <p>Please enable javascript on your browser.</p>
     </noscript>
</body>
</html>
_END;
	     echo $page;
	 }
	
?>