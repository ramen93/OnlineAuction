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
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		List of Messages
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>User's Messages</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="120">
</head>
<body onLoad="frmDelete.btnDelete.disabled=true">
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
			<ul>
				<li><a href="admin.php">List of Emails</a></li>
				<li class="selected"><a href="contactadmin.php">Messages</a></li>
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
            <td height="34" style="color:#2a4f5e; font-size:30px;">User's Messages</td>
            <td align="right" style="font-size:22px"><?php echo $n; ?></td>
          </tr>
        </table>
		<br><br><br>
		
		
<form name="frmDelete" action="delmess_code.php" method="post" enctype="multipart/form-data">		
<table width="931" height="84" border="0" align="center" style="padding:15px 10px 10px 10px; outline:#000000 solid thin" bgcolor="#F2F2F2" cellspacing="0">
  <tr valign="top" style="font-family:Constantia; font-size:24px; color:#2a4f5e; font-weight:bold">
    <td height="50" colspan="3" align="center"><u>Message Title</u></td>
	<td width="125" align="center"><u>Replied ?</u></td>
    <td align="center"><u>Sender's Email ID</u></td>
  </tr>
<?php     $q=mysql_query("select * from contact");
		  $r=mysql_num_rows($q);	// The Sequence Number of Rows
		  for($i=0;$i<$r;$i++)  {
		  	$f=mysql_fetch_array($q);	?>
  <tr height="35">
	<td width="26" align="left"><input type="checkbox" name="mchk-<?php echo $i; ?>" onClick="btnDelete.disabled=false"></td>			  
    <td width="22" style="font-size:18px; font-family:'Times New Roman'; color:#000000"><?php  $j=$i+1; echo $j."."; ?></td>   			
	<td width="396" style="font-size:18px; font-family:'Times New Roman'; text-transform:capitalize; font-variant:small-caps"><a style=" <?php if($f[9]=='no'){ ?>color:#000093 <?php } else { ?> color:#AAAAAA <?php } ?>; text-decoration:none" href="reply.php?msgid=<?php echo $f[0]; ?>" target="_blank" title="Click to see the message"> <?php echo $f[5]; ?> </a></td>
	<td align="center" style="font-size:19px; font-family:Constantia;">
<?php  if($f[9]=='no')	{  ?><label style="color:#000093;"><?php echo "No";?></label>
<?php  }	else	{  ?> <label style="color:#AAAAAA;"> <?php echo "Yes";?> </label> <?php	}	?>	</td>		   
    <td width="352" style="font-family:'Times New Roman'; font-size:20px;">
<?php if($f[2]=='Registered') { ?> <a href="userdata.php? uemail=<?php echo $f[3]; ?>" title="Click to see user's data" style=" <?php if($f[9]=='no') { ?> color:#000093; <?php } else { ?> color:#AAAAAA; <?php } ?>; text-decoration:none"> <?php echo $f[3];?> </a>
<?php } else { ?>
<label style=" <?php if($f[9]=='no') { ?> color:#000093; <?php } else { ?> color:#AAAAAA; <?php } ?> "> <?php echo $f[3];?> </label> <?php } ?>	</td>
  </tr>
<?php	}	?>
 </table><br>
 
<div align="center"><input type="submit" name="btnDelete" value="Delete Message" style="font-family:Constantia; font-size:18px;"></div>
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