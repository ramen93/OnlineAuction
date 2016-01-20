<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_GET['a']))
	$message=$_GET['a'];
if(isset($_GET['b']))
	$mess=$_GET['b'];

if(isset($_SESSION['email']))	{			//	if there is any logged in email-id in session 'email'
	$e=$_SESSION['email'];
	$q=mysql_query("select * from admin where email='$e'");
	$f=mysql_fetch_array($q);
	$n=$f['name'];
}
else  {
	header("location:index.php? b=You're not logged in! Log in first");
}	
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		Admin Home
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>Admin - List of Emails</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="300">
</head>
<body onLoad="frmUser.btnUser.disabled=true">
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
			<ul id="slide">
				<li class="selected"><a href="admin.php">List of Emails</a></li>
				<li><a href="contactadmin.php">Messages</a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="register.php? cat=new account">New Admin</a></li>
				<li><a href="logout_code.php">Log Out</a></li>  
			</ul>
	</div>
	
	<div align="right" style="font-size:20px; font-family:'Times New Roman'; padding-right:30px;"><?php if(!empty($message)) echo $message ?><label style="color:red;"><?php if(!empty($mess)) echo $mess ?></label>
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
	<div id="body">
	  <div class="about">
		<table width="941" height="69" border="0" align="center">
          <tr style="font-family:Constantia; text-transform:capitalize;">
            <td height="34" style="color:#2a4f5e; font-size:30px;">List of all Registered Email-IDs</td>
            <td align="right" style="font-size:22px"><?php echo $n; ?></td>
          </tr>
        </table>
		<br><br><br>
		

<table width="1000" height="117" border="0" align="center" cellspacing="0" >
 <tr>
  <td width="460" height="86" align="center" valign="top">
<form name="frmUser" action="delaccount_code.php? cat=useracnt" method="post" enctype="multipart/form-data">
   <table width="460" border="0" style="padding:10px 10px 10px 5px; outline:#000000 solid thin" bgcolor="#F2F2F2">
    <tr><td colspan="3" align="center" style="font-family:Constantia; font-size:24px; font-weight:bold; color:#2a4f5e"><u>Registered User</u></td></tr>
    <tr><td colspan="3">&nbsp;</td></tr>		
<?php	$q=mysql_query("select * from user");
		$r=mysql_num_rows($q);	// The Sequence Number of Rows
		for($i=0;$i<$r;$i++)  {
			$f=mysql_fetch_array($q);	?>
    <tr>
     <td width="27" height="29"><input name="useracnt-<?php echo $i; ?>" type="checkbox" value="true" onClick="btnUser.disabled=false" o></td>
     <td width="24" align="left" style="font-size:20px; font-family:'Times New Roman'; color:#000000"><?php $j=$i+1; echo $j."."; ?></td>
     <td width="395"><a style="text-decoration:none;font-size:20px; font-family:'Times New Roman'; color:#000093;" href="userdata.php?uemail=<?php echo $f[0]; ?>" title="Click to see user's data"><?php echo $f[0]; ?></a></td>
    </tr>
<?php	}  ?>
   </table><br>
	<input type="submit" name="btnUser" value="Delete User Account" style="font-family:Constantia; font-size:18px;" />
</form>
  </td>
  <td width="80">&nbsp;</td>
  <td width="460" height="86" align="center" valign="top">
<form name="frmAdmin" action="delaccount_code.php? cat=adminacnt" method="post" enctype="multipart/form-data">		  
   <table width="460" border="0" style="padding:10px 10px 10px 5px; outline:#000000 solid thin" bgcolor="#F2F2F2">
    <tr><td colspan="3" align="center" style="font-family:Constantia; font-size:24px; font-weight:bold; color:#2a4f5e"><u>Administrator</u></td></tr>
    <tr><td colspan="3">&nbsp;</td></tr>
<?php	$q=mysql_query("select * from admin");
		$r=mysql_num_rows($q);	// The Sequence Number of Rows
		for($i=0;$i<$r;$i++)  {
			$f=mysql_fetch_array($q);	?>		
    <tr>
     <td width="26" height="29"><input name="adminacnt" type="radio" value="<?php echo $f[1]; ?>" required /></td>
     <td width="26" align="left" style="font-size:20px; font-family:'Times New Roman'; color:#000000"><?php $j=$i+1; echo $j."."; ?></td>
     <td width="419"><a style="text-decoration:none;font-size:20px; font-family:'Times New Roman'; color:#000093" href="verifysecurity.php? cat=editsec& aemail=<?php echo $f[1]; ?>" title="Click to change admin's data"><?php echo $f[1]; ?></a></td>
    </tr>
<?php	}  ?>
   </table><br>
	<input type="submit" name="btnAdmin" value="Delete Admin Account" style="font-family:Constantia; font-size:18px;" />
</form>
  </td>
 </tr>
 <tr><td height="30" colspan="3" align="center" valign="bottom">&nbsp;</td></tr>
</table>
			
		</div>
	</div>
		<div id="footer">
		  <div>
				<p>&copy Copyright 2015. All rights reserved</p>
			</div>
		</div>
	</body>
</html>