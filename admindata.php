<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if (isset($_GET['a']))
$message=$_GET['a'];

if(isset($_SESSION['email']))  {
	$e=$_SESSION['email'];
	$q=mysql_query("select * from admin where email='$e'");
	$f=mysql_fetch_array($q);				
	$n = $f['name'];
}
else  {
	header("location:index.php? b=You're not logged in! Log in first");
	exit();
}

if(isset($_GET['aemail']))  {
	$ae=$_GET['aemail'];
	$_SESSION['aemail']=$ae;
}	
else  {
	header("location:#");
}

$q=mysql_query("select * from admin where email='$ae'");		// to fetch all account data of selected user email
$f=mysql_fetch_array($q);	
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		Admin Data
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>Administrator Data</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="60">
</head>
<body>
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
			<ul>
				<li class="selected"><a href="admin.php">List of Emails</a></li>
				<li><a href="contactadmin.php">Messages</a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="register.php? cat=new account">New Admin</a></li>
				<li><a href="logout_code.php">Log Out</a></li>		
			</ul>
	</div>
	
	<div align="right" style="font-size:20px; font-family:'Times New Roman'; padding-right:30px;"><?php if(!empty($message)) echo $message ?></label>
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
	<div id="body">
	  <div class="about">
		<table width="941" height="69" border="0" align="center">
          <tr style="font-family:Constantia; text-transform:capitalize;">
            <td height="34" style="color:#2a4f5e; font-size:30px;">Admin's Data</td>
            <td align="right" style="font-size:22px"><?php echo $n; ?></td>
          </tr>
        </table>
		<br><br>
		
	
<form action="register.php? cat=change security data& aemail=<?php echo $ae; ?>" method="post" enctype="multipart/form-data">
<table width="1037" height="39" border="0" align="center">
  <tr>
    <td width="262" height="35" style="font-family:Constantia; font-size:24px; color:#2a4f5e">Administrator's Name  :</td>
    <td width="212" style="text-transform:capitalize; font-family:Constantia; font-size:24px; color:black"><?php echo $f[0];?></td>
    <td width="549" align="right" style="font-family:Constantia; font-size:24px; color:#2a4f5e">Email ID :<span style="padding-left:30px; text-transform:lowercase; color:black; font-family:'Times New Roman'"><?php echo $ae;?></span></td>
    </tr>
</table><br>

<table width="1049" height="93" border="0" style="outline:#000000 solid thin; padding: 20px 20px 20px 20px" align="center">
  <tr valign="bottom">
    <td height="31" colspan="2" align="center" style="font-family:Constantia; font-size:24px; color:#2a4f5e">Account Password :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:black; font-family:'Times New Roman'"><?php echo str_rot13($f[2]); ?></span></td>
  </tr>
  <tr>
    <td height="23" colspan="2">&nbsp;</td>
  </tr>
  <tr valign="top">
    <td width="659" height="31" style="font-family:Constantia; font-size:24px; color:#2a4f5e">Security Question :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:black;"><?php echo $f[3]; ?></span></td>
    <td width="380" align="right" style="font-family:Constantia; font-size:24px; color:#2a4f5e">Security Answer :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:black; font-family:'Times New Roman'"><?php echo str_rot13($f[4]); ?></span></td>
  </tr>
</table><br><br>

<div align="center"><input type="submit" value="Change Admin Data" style="font-family:Constantia; font-size:18px;" /></div>
</form>

	  </div>
	</div>
		<div id="footer">
		  <div>
				<p>&copy Copyright 2015. All rights reserved</p>
		  </div>
		</div>
</body>
</html>