<?php 
     require_once 'system/database/db_required/dblogin.php';
     require_once 'system/database/db_required/functions.php';
	 
	 session_start();
	 if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['user_id']) && isset($_SESSION['phone']) 
		 && isset($_SESSION['usertype']) && isset($_SESSION['email']) && isset($_SESSION['first_name']) && isset($_SESSION['last_name'])
	     && isset($_SESSION['gender']) && isset($_SESSION['address']) && isset($_SESSION['photo']))
	 {
		 if ($_SESSION['usertype'] == '1')
		 {
			 header( 'Location: core/dashboard/dashboard.php' );
		 }
		 else if($_SESSION['usertype'] == '2'){
			 header( 'Location: user/bursar/dashboard.php' );
		 }
	 }
	 if(isset($_SESSION['teacher_id']) && isset($_SESSION['teacher_firstname']) && isset($_SESSION['teacher_lastname']) && isset($_SESSION['dateofbirth']) 
		 && isset($_SESSION['gender']) && isset($_SESSION['address']) && isset($_SESSION['phone']) && isset($_SESSION['phone_alt'])
	     && isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['photo']))
	 {
		 header( 'Location: user/teacher/dashboard.php' );
	 }
	 if(isset($_SESSION['parent_id']) && isset($_SESSION['parent_firstname']) && isset($_SESSION['parent_lastname']) && isset($_SESSION['gender']) 
		 && isset($_SESSION['address']) && isset($_SESSION['phone']) && isset($_SESSION['phone_alt']) && isset($_SESSION['email'])
	     && isset($_SESSION['password']) && isset($_SESSION['photo']))
	 {
		 header( 'Location: user/parent/dashboard.php' );
	 }
?>

<!doctype html>
<html lang="en">
<head>
     <title>Eduke - Select Login</title>
	 <link rel="stylesheet" type="text/css" href="login/css/index.css">
	 <link rel="stylesheet" type="text/css" href="login/css/jquery-ui.css">
	 <script rel="text/javascript" src="system/scripts/jquery-1.11.1.min.js"></script>
	 <script rel="text/javascript" src="system/scripts/jquery-ui-1.10.4.min.js"></script>
	 <script rel="text/javascript" src="system/scripts/jQueryRotate.js"></script>
	 <script rel="text/javascript" src="system/scripts/library.js"></script>
	 <script rel="text/javascript" src="system/scripts/jquery.spritely.js"></script>
</head>
<body>
     <div id="frame">
         <div id="login-box">
		     <img src="system/images/eduke.png" width="100"><br><br><br>
			 <h1>LOGIN</h1>
			 <br>
			 <div id="accordion">
				 <h3>STAFF LOGIN</h3>
				 <div>
					 <p><a href="login"><input type="button" value="ADMIN / BURSAR"></a></p>
					 <p><a href="login/teacher/"><input type="button" value="TEACHER"></a></p>
				 </div>
				 <h3>PARENTS LOGIN</h3>
				 <div>
					 <p><a href="login/parent/"><input type="button" value="PARENT"></a></p>
				 </div>
			 </div>
			 <br><br><br><br>
			 <div>
			     <p><a href="http://www.derrickedd.com" target="_blank" style="text-decoration:none;color:#fff;font-size:13px;">derrick<b>edd</b> Eduke v2.0</a></p>
			 </div>
		 </div>
	 </div>
	 <script rel="text/javascript">
		 $("#accordion").accordion({ header: "h3", collapsible: true, active: false });
	 </script>
     <noscript class="nojava">
         <p>LOADING FAILED</p>
	     <p>Please enable javascript on your browser.</p>
     </noscript>
</body>
</html>
