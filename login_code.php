<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

$e=$_POST['email'];
$p=str_rot13($_POST['password']);	 // ROT13 En-Cipher
$rem=$_POST['rem'];

if(substr_count($_POST['email'],'@')!= 1)	// to check whether there is any '@' in entering email-id
	header("location:index.php? b=incorrect formate of email-id !");
else  {		//	correct formate of email id	
	$q=mysql_query("select * from user where email='$e' and password='$p'");	//	checking if combination of input values of email & password is exist in database 'user'
	$f=mysql_fetch_array($q);
	if($f) {		// if the combination exist in database 'user'
		if($f['name']=='no')	{		//	if profile part doesn't exist in the account
			$q=mysql_query("delete from user where email='$e'");	//	then delete the account from database 'user'
			header("location:index.php? b=Incomplete account registration, register again !");
		}		//	if profile part exists in the account
		else  {
			if($rem=='on') {			 // Checking if Checkbox is clicked
				setcookie("email", $e, time()+60*60*24);		//	saving cookie value 24 hours after destroy session value
			}
			$_SESSION['email']=$e;
			$_SESSION['loggedin'] = time();		//	This value is determined by calling the time() function, which returns the number of seconds that have elapsed since the epoch (midnight on January 1, 1970).
			header("location: profile.php");	
			exit();			// to cancel the execution of the script (because the browser has been redirected to another page)
		}
	}	
	else  {
		$q=mysql_query("select * from admin where email='$e' and password='$p'");
		$f=mysql_fetch_array($q);
		if($f) {		// Checking if the combination exists
			header("location:verifysecurity.php? cat=2stepverify& aemail=$e");
			exit();		
		}
		else {
			header("location:index.php? b=Sorry, your email-id/password doesn't matched !");
			exit();
		}									
	}
}			
?>