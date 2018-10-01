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
?>

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
		     <img src="../../system/images/eduke.png" width="100"><br><br><br>
		     <form action="login.php" method="POST">
			     <h1>STAFF LOGIN</h1>
			     <h2>TEACHER</h2><br>
			     <p><input id="usrlogin" type="text" name="username" value="" placeholder="Phone or Email"></p>
			     <p><input id="passlogin" type="password" name="password" value="" placeholder="Password"></p>
			     <p><input type="submit" value="LOGIN" class="login-button"></p>
				 <p class="reset"><a href="../recover">Recover Account</a> / <a href="../../">Switch User</a></p>
			 </form>
			 <br><br><br><br><br><br>
			 <div>
			     <p><a href="http://www.derrickedd.com" target="_blank" style="text-decoration:none;color:#fff;font-size:13px;">derrick<b>edd</b> Eduke v2.0</a></p>
			 </div>
		 </div>
	 </div>
	 <script rel="text/javascript"></script>
     <noscript class="nojava">
         <p>LOADING FAILED</p>
	     <p>Please enable javascript on your browser.</p>
     </noscript>
</body>
</html>