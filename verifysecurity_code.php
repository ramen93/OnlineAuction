<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_SESSION['email']))
	$e=$_SESSION['email'];

if(isset($_GET['page']))			// $page represents from where this page is accessed . admin or user or index
	$page=$_GET['page'];	
if(isset($_GET['cat']))				// $cat represents for which purpose verification is needed, account deletion or update security data or log in admin account 
	$cat=$_GET['cat'];
if(isset($_GET['aemail']))  		//	for 2-step verification of admin account from index or for security update of selected admin-id from admin
	$e=$_GET['aemail'];		

if($page=='admin' || $cat=='2stepverify')  {	//	when page is accessed from admin or index for 2-step verification
	$db='admin';
}	
else  {			//	when page is accessed from user or index for forgot password
	$db='user';
}	

if($page=='index' && $cat=='editsec')	{
	$e=$_POST['email'];
}	
elseif($cat!='2stepverify')	{
	$p=str_rot13($_POST['pass']);	 // ROT13 En-Cipher
}	
$qs=$_POST['ques'];
$an=str_rot13($_POST['ans']);	 // ROT13 En-Cipher

if(substr_count($e,'@')!= 1)	{		//	if there is no '@' in entering email-id
	header("location:verifysecurity.php? cat=$cat& b=Incorrect formate of email-id !& aemail=$e");
}
else  {	
	$q=mysql_query("select * from $db where email='$e'");
	$f=mysql_fetch_array($q);
	if(!$f && $page=='index' && $cat=='editsec')	{
		header("location:verifysecurity.php? cat=$cat& b=Email-id isn't registered !& aemail=$e");
	}	
	else  {
		$pwd=$f['password'];
		$ques=$f['question'];
		$ans=$f['answer'];		
		if($page!='index')	{
			if($p!=$pwd)  {
				header("location:verifysecurity.php? cat=$cat& b=Incorrect password !& aemail=$e");			
			}
			else  {
				$pass='blabla';		//	to confirm entering passord is matched with database
			}
		}
		if($ques==$qs && $ans==$an)	{
			if($page=='index')  {
				if($page=='index' && $cat=='editsec')	{		//	forgot password verification page
					header("location:register.php? cat=change security data& aemail=$e");
				}
				elseif($cat=='2stepverify')	 {		//	2 step verification of admin at the time of login
					$_SESSION['email']=$e;
					header("location:admin.php");
				}
			}
			elseif(isset($pass))  {			//	user or admin page
				if($page=='user' && $cat=='editsec')  {			//	 for user's security update
					header("location:register.php? cat=change security data");
				}	
				elseif($page=='user' && $cat=='delacc')  {		//	 for user's account deletion
					header("location:delconfirm.php? cat=account& id=$e");
				}	
				elseif($page=='admin' && $cat=='editsec')  {	//	 for admin's security update
					header("location:admindata.php? aemail=$e");
				}	
				elseif($page=='admin' && $cat=='delacc')  {		//	 admin's account deletion
					header("location:delconfirm.php? cat=account& id=$e");
				}	
			}
			else  {
				header("location:verifysecurity.php? cat=$cat& b=Incorrect password !& aemail=$e");
			}
		}
		elseif(isset($pass) || $page=='index')  {
			header("location:verifysecurity.php? cat=$cat& b=Security question/answer don't matched !& aemail=$e");
		}		
	}
}				
?>