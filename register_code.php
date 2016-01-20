<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_SESSION['email']))
	$e=$_SESSION['email'];
if(isset($_GET['aemail']))			//	selected email-id means it may be not account logger-id
	$e=$_GET['aemail'];

if(isset($_GET['page']))			// $page represents from where this page is accessed, from admin or user or index
	$page=$_GET['page'];	
if(isset($_GET['cat']))				// category of which work it does, create new account or security update
	$cat=$_GET['cat'];	
if(isset($_GET['data']))  			// $data represents category of form & of register.php page
	$data=$_GET['data'];

$db[0]='user'; $db[1]='house'; $db[2]='vehicle'; $db[3]='furniture'; $db[4]='study'; $db[5]='jewellery'; $db[6]='antique'; $db[7]='electronics'; $db[8]='item'; $db[9]='bidders'; $db[10]='contact'; $db[11]='admin';

if($page=='admin' && $cat=='change security data')		//	database selcetion for admin security update
	$database='admin';
else		//	database selcetion for user security update
	$database='user';

if($data=='vcheck')	{
	$re=strtolower($_POST['remail']);		//	new email and strtolower() converts to all letter in lower case
	if(substr_count($_POST['remail'],'@')!= 1)		// to check whether there is any '@' in entering email-id
		header("location:register.php? cat=$cat& remail=$re& aemail=$e& b=Incorrect formate of email-id !");
	else  {	
		$q=mysql_query("select email from user where email='$re'");			// to check if the Email ID exists in database 'user'
		$f=mysql_fetch_array($q);
		if($f)			// if exist then shows another email id needs
			header("location:register.php? cat=$cat& remail=$re& aemail=$e& b=Email-id is already registered !");
		else  {
			$q=mysql_query("select email from admin where email='$re'");			// to check if the Email ID exists in database 'admin'
			$f=mysql_fetch_array($q);
			if($f)			// if exist then shows another email id needs
				header("location:register.php? cat=$cat& remail=$re& aemail=$e& b=Email-id is already registered !");
			else  {
				header("location:register.php? cat=$cat& remail=$re& aemail=$e& a=Valid email-id !");
				$_SESSION['a']='blabla';
			}	
		}
	}			
}

	
if($data=='other')	 {		// $data=='other' is only for $cat='create' account & 'change user-id'. But not for $cat='change security data'
	if(isset($_SESSION['a']))	{  		//	if email-id validation check is performed
		$re=$_GET['remail'];			//	new email 
		$ce=$_POST['conemail'];		//	confirm email 
		if($re!=$ce) { 			// if both Email IDs are not same
			header("location:register.php? cat=$cat& remail=$re& cemail=$ce& aemail=$e& b=Both email-ids don't matched !");
		}	
		else  {			// if both Email IDs are same
			if($cat=='change user-id')	{ 		//	for $cat=change userid
				$ue=$_SESSION['uemail'];		// which user-id will be changed
				for($i=0;$i<11;$i++) {
					$query=mysql_query("update $db[$i] set email='$re' where email='$ue'");
				}
				$query=mysql_query("update bidders set bidder_email='$re' where bidder_email='$ue'");	//	to change 'bidder_email' column in database 'bidders'
				unset($_SESSION['uemail']);
				header("location:userdata.php? uemail=$re& a=User-id has been changed !");

				$title="User-id Changed in Online Auction";
				$body="Dear user, your user-id changed in our website. Your new user-id is $re. Thank you.";
				mail($re, $title, $body, 'From: admin@onlineauction.com');
			}
			elseif($cat=='change security data')	{ 		//	for $cat=change security data and its only for $page=admin
				$query=mysql_query("update admin set email='$re' where email='$e'"); 
				header("location:register.php? cat=$cat& aemail=$re& a=Admin-id has been changed !");		

				$title="Admin-id Changed in Online Auction";
				$body="Dear admin, your admin-id changed in our website. Your new admin-id is $re. Thank you.";
				mail($re, $title, $body, 'From: admin@onlineauction.com');
			}						
			else  {		//	for $cat=register
				if($page=='admin')	{		// when page is admin register
					$name=$_POST['name'];
				}		
				$np=str_rot13($_POST['npwd']);	 // ROT13 Cipher
				$cp=str_rot13($_POST['cpwd']);	 // ROT13 Cipher
				$ques=$_POST['ques'];
				$ans=str_rot13($_POST['ans']);	 // ROT13 Cipher
				if(strlen($np)<6)	{		//	when number of charecter in password is less than 6
					header("location:register.php? cat=$cat& aemail=$e& remail=$re& cemail=$ce& name=$name& b=Password must be at least 6 charecters long !");
				}
				else	{		//	when number of charecter in password is 6 or more than
					if($np!=$cp)  {		// if both passwords are not same
						header("location:register.php? cat=$cat& aemail=$e& remail=$re& cemail=$ce& name=$name& b=Both passwords don't matched !");
					}	
					else  {		// if both passwords are same
						if($page=='admin')	{		// when page is admin register
							$q=mysql_query("insert into admin values('$name','$re','$np','$ques','$ans')");
							header("location:admin.php? a=New admin is registered successfully !");
							unset($_SESSION['a']);
							
							$title="Successful Registration in Online Auction";		//	Reply email for successful registration
							$body="Dear $name, Congratulation for being part of Online Auction Administrator. I think you are able to take this responsible for all kind of user problems. Your account password is $np, Security Question is $ques and Security Answer is $ans. Thank you.";
							mail($re, $title, $body, 'From: admin@onlineauction.com');
						}
						elseif($page=='index')	{		// when page is user register
							$q=mysql_query("insert into user values('$re','no','no','no','no','no','no','no','no','no','no','images/empty.jpg','$np','$ques','$ans')");
							header("location:createprofile.php? email=$re");
						}	
					}
				}
			}	
		}
	}
	else  {	
		header("location:register.php? cat=$cat& aemail=$e& b=Give an email-id and check its validation first !");
	}	
}		


if($data=='editname') {		//	modify admin name
	$name=$_POST['name'];
	$query=mysql_query("update admin set name='$name' where email='$e'");
	header("location:register.php? cat=$cat& aemail=$e& a=Administrator's name has been changed !");		
}


if($data=='pass') {			//	update account password
	$np=str_rot13($_POST['npwd']);	 // ROT13 Cipher
	$cp=str_rot13($_POST['cpwd']);	 // ROT13 Cipher
	$query=mysql_query("select * from $database where email='$e'");
	$f=mysql_fetch_array($query);
	if(strlen($np)<6)	{		//	when number of charecter in password is less than 6
		header("location:register.php? cat=$cat& aemail=$e& b=Password must be at least 6 charecters long !");
	}
	else	{		//	when number of charecter in password is 6 or more than
		if(substr_count($np,[a-z])==1)	{
			if($np==$cp)  {
				if($np!=$f['password'])  {		//	if old password and new password are not same
					$query_pass=mysql_query("update $database set password='$np' where email='$e'");
					header("location:register.php? cat=$cat& aemail=$e& a=Password has been changed !");
					
					$title="Account Password Changed in Online Auction";		//	Reply email for password changing
					$body="Dear $database, your account password has been changed. Your new password is $np. Thank you.";
					mail($e, $title, $body, 'From: admin@onlineauction.com');
				}
				else  {
					header("location:register.php? cat=$cat& aemail=$e& b=New password is same as previous one !");
				}		
			}
			else  {	
				header("location:register.php? cat=$cat& aemail=$e& b=Both passwords don't matched !");
			}
		}
		else  {
			header("location:register.php? cat=$cat& aemail=$e& b=Password should be upper-lower alpha-numeric combination !");
		}
	}
}


if($data=='qsan' && $page!='index')  {			//	update account security question-answer
	$ques=$_POST['ques'];
	$ans=str_rot13($_POST['ans']);	 // ROT13 Cipher
	$query=mysql_query("select * from $database where email='$e'");
	$f=mysql_fetch_array($query);
	if($ques==$f['question'] && $ans==$f['answer'])		//	if old Security Question-Answer and new Security Question-Answer are same
		header("location:register.php? cat=$cat& aemail=$e& b=New question and answer are same as previous one !");
	else  {		//	if old Security Question-Answer and new Security Question-Answer are not same
		$query=mysql_query("update $database set question='$ques', answer='$ans' where email='$e'");
		header("location:register.php? cat=$cat& aemail=$e& a=Security Question/Answer has been changed !");
		
		$title="Account Security Question-Answer Changed in Online Auction";		//	Reply email for Security Question-Answer changing
		$body="Dear $database, your account Security Question-Answer has been changed. Your new Question is $ques and Answer is $ans. Thank you.";
		mail($e, $title, $body, 'From: admin@onlineauction.com');
	}
} 
?>