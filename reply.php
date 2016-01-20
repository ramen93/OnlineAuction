<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_GET['a']))
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

if(isset($_GET['msgid']))
	$msgid=$_GET['msgid'];
else
	header("location:#");

$q=mysql_query("select * from contact where msgid='$msgid'");
$f=mysql_fetch_array($q);
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		Reply of User Message
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>Reply of Message</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="300">
</head>
<body>
  <div id="header" align="right" style="font-family:Constantia; font-size:36px; color:#2a4f5e">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>
	<?php if($f['reply']=='no')	echo "Not Replied";  else	echo "Replied";	?>
	</div>
	
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px;"><?php if(!empty($message)) echo $message ?></label>
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
	<div id="body">
	  <div class="about">
		<table width="941" height="69" border="0" align="center">
          <tr style="font-family:Constantia; text-transform:capitalize;">
            <td height="34" style="color:#2a4f5e; font-size:30px;">Reply of Message</td>
            <td align="right" style="font-size:22px"><?php echo $n; ?></td>
          </tr>
        </table>
		<br><br><br>
				

  <table width="1054" border="0" align="center">
    <tr>
      <td width="93" style="font-family:Constantia; font-size:22px; color:#2a4f5e;">Name :</td>
      <td width="456" style="font-size:20px; font-family:Constantia; text-transform:capitalize; color:#999999"><span style="color:black;">
<?php if($f[2]=='Registered') { ?><a style="text-decoration:none; color:black;" href="userdata.php? uemail=<?php echo $f[3]; ?>"><?php echo $f[4]; ?></a><?php } else echo $f[4];	?> </span>&nbsp; <?php echo "(".$f[2]." User)"; ?>	  </td>
      <td width="120" style="font-family:Constantia; font-size:22px; color:#2a4f5e;">Email ID :</td>
      <td width="367" style="font-size:20px; font-family:'Open Sans';"><?php echo $f[3]; ?></td>
    </tr>
  </table>

<br /><br />

<table width="1054" border="0" align="center">
  <tr>
    <td width="173" height="43" style="font-family:Constantia; font-size:22px; color:#2a4f5e;">Message Title :</td>
    <td width="509" style="font-size:22px; font-family:'Times New Roman'; color:#FF6600; font-variant:small-caps; text-transform:capitalize"><?php echo $f[5]; ?></td>
    <td width="29">&nbsp;</td>
    <td width="325" align="center" style="font-family:Constantia; font-size:24px; color:#2a4f5e;"><?php if($f[7]!="no")	{ ?>Uploaded Picture<?php  }  ?></td>
  </tr>
  <tr>
    <td height="172" colspan="2" valign="top" bgcolor="#F9F7F7" style="padding:15px 15px 15px 15px; outline:#000000 solid thin; font-family:'Times New Roman'; font-size:24px; color:#000000; line-height:30px"><?php echo $f[6]; ?></td>
    <td>&nbsp;</td>
    <td align="center"><?php if($f[7]!="no") { ?><img src="<?php echo $f[7]; ?>" height="200px" width="250px" style="border:#000000 solid thin" /><?php  }  ?></td>
  </tr>
</table>

<br /><br />

<form action="reply_code.php? msgid=<?php echo $msgid; ?>" method="post" enctype="multipart/form-data">
<table width="1054" border="0" align="center">
  <tr>
    <td width="188" height="62" style="font-family:Constantia; font-size:22px; color:#2a4f5e;">Title of Relpy :</td>
    <td width="856"><input type="text" name="rtitle" size="52" style="font-family:Constantia; font-size:18px; color:#0080C0; font-variant:small-caps; text-transform:capitalize" placeholder="Give the title of reply" <?php if($f[8]!='no') { ?>readonly="true" value="<?php echo $f[8]; ?>"<?php } ?> maxlength="100" required /></td>
  </tr>
  <tr valign="top">
    <td height="53" style="font-family:Constantia; font-size:22px; color:#2a4f5e;">Relpy Message :</td>
    <td><textarea name="reply" style="height:200px; width:485px; font-family:'Times New Roman'; font-size:22px; color:#0080C0;" placeholder="write the reply message within 500 charecters" <?php if($f[9]!='no') { ?>readonly="true"<?php } ?> maxlength="500" required><?php if($f[9]!='no') { echo $f[9]; } ?></textarea></td>
  </tr>
  <tr valign="bottom">
    <td height="34">&nbsp;</td>
    <td align="center" style="padding-left:60px"><?php if($f[9]=='no') { ?><input type="submit" name="Submit" value="Send !" style="font-size:18px; font-family:Constantia" /><?php } ?></td>
  </tr>
</table>
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