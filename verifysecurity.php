<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_GET['b']))
$message=$_GET['b'];

$page='index';

if(isset($_SESSION['email']))			//	if there is any logged in email-id in session 'email'
	$e=$_SESSION['email'];
elseif(isset($_COOKIE['email']))	{		//	if there is any logged in email-id in cookie 'email'
	$e=$_COOKIE['email'];
	$_SESSION['email']=$e;
}

if(isset($e))  {
	$q=mysql_query("select * from user where email='$e'");
	$f=mysql_fetch_array($q);
	if($f) {			//	if the page is accessed from user side
		$pic = $f['picture'];
		$page='user';
	}
	else  {			//	if the page is accessed from admin side
		$q=mysql_query("select * from admin where email='$e'");
		$f=mysql_fetch_array($q);
		$page='admin';
	}
	$n=$f['name'];		//	name of the account logger
}

if(isset($_GET['cat']))			// $cat represents for which purpose verification is needed, account deletion or update security data or log in admin account 
	$cat=$_GET['cat'];
else
	header("location:#");

if(isset($_GET['aemail']))  	//	for 2-step verification of admin account from index or for security update of selected admin-id from admin
	$e=$_GET['aemail'];
else
	$e="";
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		Security Verification
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title><?php if($cat=='2stepverify') echo "2-Step Verification";	else echo "Security Verification"; ?></title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="300">
</head>
<body>
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
			<ul>
<?php if($page=='index')  {  ?>
				<li><a href="index.php">Home</a></li>
				<li><a href="gallery.php">Gallery</a></li>         
			    <li><a href="about.php">About Us</a></li>		 
			    <li><a href="contact.php">Contact Us</a></li>
			    <li><a href="register.php? cat=new account">Create Account</a></li>				
<?php  }	
		elseif($page=='admin')  {  ?>
				<li><a href="admin.php">List of Emails</a></li>
				<li><a href="contactadmin.php">Messages</a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="register.php? cat=new account">New Admin</a></li>
				<li><a href="logout_code.php">Log Out</a></li>
<?php  	}
		elseif($page=='user')  {  ?>
				<li><a href="profile.php">My Profile</a></li>
				<li><a href="createprofile.php">Edit Profile</a></li>
				<li <?php if($cat=='editsec') { ?> class="selected" <?php } ?> ><a href="verifysecurity.php? cat=editsec">Change Security</a></li>
				<li <?php if($cat=='delacc') { ?> class="selected" <?php } ?> ><a href="verifysecurity.php? cat=delacc">Delete Account</a></li>					    				
				<li><a href="logout_code.php">Log Out</a></li>	
<?php 	}	?>				
			</ul>
  </div>
	
  <div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px; color:red"><?php if(!empty($message)) echo $message; ?>
   <span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
	
  <div id="body">
   <div class="about">
	<table width="941" height="75" border="0" align="center">
     <tr style="font-family:Constantia; text-transform:capitalize;">
      <td height="34" style="color:#2a4f5e; font-size:30px; font-family:'Times New Roman';"><?php if($cat=='2stepverify') echo "2 - Step Verification";	else echo "Security Verification"; ?></td>
      <td width="259" align="right" style="font-size:22px;"><?php if(isset($_SESSION['email'])) { if($page=='user') { ?><a href="profile.php" style="text-decoration:none; color:black"><?php } echo $n; ?></a><?php } ?></td>
      <td width="65" align="right"><a href="profile.php"><?php if(isset($_SESSION['email']) && $page=='user') { ?><img width="50px" height="50px" src="<?php echo $pic; ?>" style="border-radius:50%;" title="Go to profile" /><?php } ?></a></td>
     </tr>
    </table>
<br><br><br>	


<form action="verifysecurity_code.php? page=<?php echo $page; ?>& cat=<?php echo $cat;?>& <?php if(isset($_GET['aemail'])) echo "aemail=".$e; ?>" method="post" enctype="multipart/form-data">
<table width="994" height="210" border="0" align="center" cellspacing="0" >
 <tr>
<?php  if($cat!='2stepverify') {	?>
  <td width="448" height="31" align="center">		  
   <table width="448" height="176" border="0" bgcolor="#F5F5DC" style="padding:15px 15px 15px 15px; outline:#000000 solid thin">
    <tr>
     <td colspan="2" align="center" style="font-family:Constantia; font-size:24px; font-weight:bold; text-decoration:underline"><?php  if($page=='index' && $cat=='editsec') { echo "User ID"; }	else { echo "Password"; }	?></td>
    </tr>
    <tr>
     <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
     <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
     <td width="211" style="font-family:Constantia; font-size:20px;">Account <?php  if($page=='index' && $cat=='editsec') { echo "User ID :"; }	else { echo "Password :"; }	?></td>
     <td width="227" align="right"><?php  if($page=='index' && $cat=='editsec')	{	?>
	  <input type="text" name="email" title="Email-id" size="21" style="font-family:'Times New Roman'; font-size:18px;" placeholder="Enter account user-id" value="<?php echo $e; ?>" maxlength="100" required /> <?php	}	else	{	?>
	  <input type="password" name="pass" title="Password" size="18" style="font-family:'Courier New'; font-size:16px; font-weight:bolder;" placeholder="Enter password" maxlength="15" oncopy="return false" required= />
	  <?php	}	?></td>
     </tr>
     <tr>
      <td height="25" colspan="2">&nbsp;</td>
     </tr>
     <tr>
      <td height="26" colspan="2">&nbsp;</td>
     </tr>
    </table>	  
   </td>   
   <td width="36">&nbsp;</td>
<?php	}	?>
   <td width="504" height="31" align="center">
	<table width="505" border="0" style="padding:15px 15px 15px 15px; outline:#000000 solid thin" bgcolor="#F5F5DC">
     <tr>
      <td colspan="2" align="center" style="font-family:Constantia; font-size:24px; font-weight:bold; text-decoration:underline">Security Question / Answer</td>
     </tr>
     <tr>
      <td colspan="2">&nbsp;</td>
     </tr>
     <tr>
      <td width="219" height="27" style="font-family:Constantia; font-size:20px;">Security Question : </td>
      <td width="276">
	   <select name="ques" title="Security Question" style="font-family:Constantia; font-size:16px" required="required">
	   <option selected="selected" value="">Select the security question</option>
	   <option>What is your nickname ?</option>
	   <option>What is your fabourite dish ?</option>
	   <option>Where is your mother's birthplace ?</option>
	   <option>What is the name of your pet ?</option>
	   <option>Who is your best friend ?</option>
	   <option>What is your fabourite color ?</option>
       </select></td>
      </tr>
      <tr>
       <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
       <td height="27" style="font-family:Constantia; font-size:20px;">Security Answer :</td>
       <td><input type="text" name="ans" title="Seceurity Answer" size="32"  style="font-family:Constantia; font-size:16px;" placeholder="Enter security answer" maxlength="20" required="required" /></td>
      </tr>
      <tr>
       <td height="20" colspan="2">&nbsp;</td>
      </tr>
     </table>
	</td>
   </tr>
   <tr>
    <td height="48" colspan="3" align="center" valign="bottom"><input id="round" input type="submit" value="Verify" style="font-family:Constantia; font-size:15px;" />
	<style type="text/css"> 

input#round{
width:100px; /*same as the height*/
height:30px; /*same as the width*/
background-color:perple;
border:1px solid perple; /*same colour as the background*/
color:#fff;
font-size:	1.6em;
font-style: bold;

/*set the border-radius at half the size of the width and height*/
-webkit-border-radius: 20px;
-moz-border-radius: 20px;
border-radius: 20px;
/*give the button a small drop shadow*/
-webkit-box-shadow: 0 0 10px rgba(0,0,0, .75);
-moz-box-shadow: 0 0 10px rgba(0,0,0, .75);
box-shadow: 2px 2px 15px rgba(0,0,0, .75);
}
/***NOW STYLE THE BUTTON'S HOVER STATE***/
input#round:hover{
background:#c20b0b;
border:1px solid #c20b0b;
font-style: bold;
/*reduce the size of the shadow to give a pushed effect*/
-webkit-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
-moz-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
box-shadow: 0px 0px 5px rgba(0,0,0, .75);
}
            
</style>
</td>
   </tr>
  </table>
</form>

      </div>
	</div>
		<div id="footer">
		  <div>
				<p class="style10">&copy Copyright 2014. All rights reserved</p>
		  </div>
</div>

</body>
</html>