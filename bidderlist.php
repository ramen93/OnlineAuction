<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_GET['a']))
$message=$_GET['a'];

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
else  {
	header("location:index.php? b=You're not logged in! Log in first");
}

if(isset($_GET['cat']) && isset($_GET['id'])) {			//	category and id of the auction item
	$cat=$_GET['cat'];
	$id=$_GET['id'];
}
else  {
	header("location:#");
}
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		List of Bidders
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>List of Bidders</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="120">
</head>
<body>
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
			<ul>
<?php	if($page=='user') {  ?>
				<li><a href="profile.php">my profile</a></li>
				<li><a href="mystore.php">New Advertise</a></li>
				<li class="selected"><a href="gallery.php">Gallery</a></li>
				<li><a href="createprofile.php">Settings</a></li>
<?php	}
		elseif($page=='admin') {  ?>
		  		<li><a href="admin.php">List of Emails</a></li>
		  		<li><a href="contactadmin.php">Messages</a></li>
		  		<li class="selected"><a href="gallery.php">Gallery</a></li>
		  		<li><a href="register.php? cat=new account">New Admin</a></li>								
<?php  	}  ?>
		  		<li><a href="logout_code.php">Log Out</a></li>
			</ul>
	</div>
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px;"><?php if(!empty($message)) echo $message; ?>
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
  <div id="body">
   <div class="about">
	<table width="941" height="75" border="0" align="center">
     <tr style="font-family:Constantia; text-transform:capitalize;">
      <td height="34" style="color:#2a4f5e; font-size:30px;">List of Bidders</td>
      <td width="259" align="right" style="font-size:22px;"><?php if($page=='user') { ?><a href="profile.php" style="text-decoration:none; color:black"><?php } echo $n; ?></a></td>
      <td width="65" align="right"><a href="profile.php"><?php if($page=='user') { ?><img width="50px" height="50px" src="<?php echo $pic; ?>" style="border-radius:50%;" title="Go to profile" /><?php } ?></a></td>
     </tr>
    </table>
<br><br>
		
		
<form action="delconfirm.php? cat=Bidder& category=<?php echo $cat; ?>& advertisement_id=<?php echo $id; ?>&k=1" method="post" enctype="multipart/form-data">
<div align="right" style="font-family:'Liberation Serif'; font-size:22px; font-style:italic; color:#2a4f5e; height:37px; width:920px">Advertisement ID :&nbsp;&nbsp; <span style="color:black;"><?php echo $cat.' - '.$id; ?></span></div>
 <table width="907" border="0" align="center" style="outline:#000000 solid thin" cellspacing="0" bgcolor="#F5F5DC">
  <tr align="center" style="font-family:'Times New Roman'; font-size:22px; color:white" bgcolor="#2a4f5e">
   <td colspan="3">&nbsp;</td>
   <td>Bidding Price</td>
   <td>Bidder's Name </td>
   <td height="54">Date </td>
   <td height="54">Time</td>
  </tr>
  <tr>
   <td height="20" colspan="7">&nbsp;</td>
  </tr>
<?php	$q=mysql_query("select * from bidders where category='$cat' and advertisement_id='$id'");
		$r=mysql_num_rows($q);	// The Sequence Number of Rows
		for($i=0;$i<$r;$i++)  {
			$f=mysql_fetch_array($q);	?>
  <tr align="center" style="font-size:20px; font-family:'Liberation Serif';">
   <td width="9" align="left">&nbsp;</td>
   <td width="25" height="37" align="left"><?php if($page=='admin') { ?><input name="bidding_id" type="radio" value="<?php echo $f[0]; ?>" required /><?php } ?></td>
   <td width="20" align="right"><?php $j=$i+1; echo $j."."; ?></td>
   <td width="169" style="font-size:22px"><?php echo $f[5]; ?></td>
   <td width="280"><a style="text-decoration:none; font-family:Georgia; color:black" href="<?php if($page=='admin') echo "userdata.php?uemail=".$f[6]; else echo "profile.php? pemail=".$f[6]; ?>"><?php if($e==$f[6]) echo "You"; else echo $f[7]; ?></a></td>
   <td width="155"><?php print date('d F , Y',$f['ts']); ?></td>
   <td width="235"><?php print date('h:i:s A',$f['ts']); ?></td>
  </tr>
<?php 		}  ?>
  <tr>
   <td height="20" colspan="7">&nbsp;</td>
  </tr>
 </table>
<?php if($page=='admin') { ?>
<br><br>
<div align="center"> <input type="submit" style="font-family:Constantia; font-size:20px;" value="Remove Bidders"> </div>
<?php } ?>
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