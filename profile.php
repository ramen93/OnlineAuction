<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_SESSION['email']))			//	if there is any logged in email-id in session 'email'
	$e=$_SESSION['email'];
elseif(isset($_COOKIE['email']))	{		//	if there is any logged in email-id in cookie 'email'
	$e=$_COOKIE['email'];
	$_SESSION['email']=$e;
}

if(!empty($e))  {
	$q=mysql_query("select * from user where email='$e'");
	$f=mysql_fetch_array($q);
	$n=$f['name'];
	$pic=$f['picture'];
}
else  {
	header("location:index.php? b=You're not logged in! Log in first");
}

if(isset($_GET['pemail'])) {		//	if there is any GET value contained public email-id
	$e=$_GET['pemail'];
}

$q=mysql_query("select * from user where email='$e'");
$f=mysql_fetch_array($q);
?>


<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		Profile
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<script type="text/javascript">
var t;
window.onload=resetTimer;
document.onkeypress=resetTimer;

function logout()
{
	alert("You are now logged out.")
	location.href='logout_code.php' 
}
function resetTimer()
{
	clearTimeout(t);
	t=setTimeout(logout,15000) //logs out in 30 minutes
}
</script>
<meta charset="utf-8" />
<title><?php if(isset($_GET['pemail'])) echo "Public"; else echo "My"; ?> Profile</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="60">
</head>
<body>
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
			<ul>
				<li <?php if(empty($_GET['pemail'])) { ?> class="selected" <?php } ?> ><a href="profile.php">My Profile</a></li>
				<li><a href="mystore.php">New Advertise</a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="createprofile.php">Settings</a></li>
				<li><a href="logout_code.php">Log Out</a></li>			
			</ul>
	</div>
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px;">&nbsp;
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
	<div id="body">
	  <div class="about">
		<table width="941" height="75" border="0" align="center">
          <tr style="font-family:Constantia; text-transform:capitalize;">
            <td width="603" height="34" style="color:#2a4f5e; font-size:30px;"><?php if(isset($_GET['pemail'])) echo "Public"; else echo "My"; ?> Profile</td>
            <td width="259" align="right"><a href="profile.php" style="text-decoration:none; color:black; font-size:22px"><?php echo $n; ?></a></td>
            <td width="65" align="right"><a href="profile.php"><img width="50px" height="50px" src="<?php echo $pic; ?>" style="border-radius:50%;" title="Go to profile" /></a></td>
          </tr>
        </table>
		<br><br><br>
		
	
<table width="909" align="center" style="border:solid; border-radius:30%; padding:30px 20px 30px 20px" bgcolor="#95B9C7">
  <tr>
    <td height="214" colspan="6" align="center" valign="top"><img width="200px" height="200px" title="Profile picture" src="<?php echo $f[11]; ?>" alt="img" style="border-radius:20%; border:solid" /></td>
  </tr>
  <tr>
    <td width="126" height="44">&nbsp;</td>
    <td width="126">&nbsp;</td>
    <td width="336" colspan="2" align="center" bgcolor="black" style="font-family:Constantia; color:white; font-size:20px; border-radius:100%; text-transform:capitalize; padding:10px 10px 10px 10px"><?php echo $f[1]; ?>&nbsp;&nbsp;&nbsp;<?php echo $f[2]; ?></td>
    <td width="126">&nbsp;</td>
    <td width="126">&nbsp;</td>
  </tr>
  <tr valign="bottom">
    <td height="36" align="center" colspan="6" style="font-family:'Times New Roman'; font-size:20px;">Date of Birth :&nbsp;&nbsp;&nbsp;<?php echo $f[3]." ".$f[4]." "."-"." ".$f[5]; ?></td>
  </tr>
  <tr>
    <td height="59" colspan="6" align="center" valign="bottom" style="font-family:Georgia; font-size:20px;"><?php if($f[1]=='Mr.') { echo "He"; } else { echo "She"; } ?> is <span style="text-transform:capitalize; font-weight:bold"><?php echo $f[6]; ?></span></td>
  </tr>
  <tr>
    <td align="center" colspan="6" style="font-family:Georgia;">of</td>
  </tr>
  <tr>
    <td align="center" colspan="6" style="font-family:Georgia; font-size:20px; text-transform:capitalize; font-weight:bold"><?php echo $f[7]; ?></td>
  </tr>
  <tr>
    <td height="34" colspan="6">&nbsp;</td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
    <td colspan="4" style="font-family:'Times New Roman'; color:white; font-size:20px; border-radius: 100%; padding:30px 30px 30px 30px; background:black">Address :&nbsp;&nbsp;<?php echo $f[9]; ?><br><br>Country :&nbsp;&nbsp;<?php echo $f[8]; ?></td>
    <td>&nbsp;</td> 
  </tr>
  <tr valign="bottom">
    <td height="60" align="center" style="font-family:'Times New Roman'; font-size:20px;" colspan="6">Email ID : &nbsp;<?php echo $f[0]; ?></td>
    </tr>
  <tr valign="bottom">
    <td height="37" align="center" colspan="6" style="font-family:'Times New Roman'; font-size:20px;">Phone : &nbsp;<?php echo $f[10]; ?></td>
  </tr>
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