<?php
session_start();
$_SESSION=array();		// clear the session variables by resetting the $_SESSION array
session_destroy();		// remove the session data from the server (where it’s stored in temporary files)
setcookie("email", FALSE);		//	delete cookie 'email' value
header("location:index.php? a=Successfully logged out !");
exit();
?>