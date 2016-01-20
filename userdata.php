<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if (isset($_GET['a']))
$message=$_GET['a'];

if(isset($_SESSION['email']))	{			//	if there is any logged in email-id in session 'email'
	$e=$_SESSION['email'];
	$q=mysql_query("select * from admin where email='$e'");
	$f=mysql_fetch_array($q);
	$n=$f['name'];
}
else  {
	header("location:index.php? b=You're not logged in! Log in first");
}

if(isset($_GET['uemail']))  {
	$ue=$_GET['uemail'];
	$_SESSION['uemail']=$ue;
}	
else  {
	location("header:#");
}

$q=mysql_query("select * from user where email='$ue'");		// to fetch all account data of selected user email
$f=mysql_fetch_array($q);		
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		User Data
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>User's Data</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="120">
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
	
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px;"><?php if(!empty($message)) echo $message ?><label style="color:red;"><?php if(!empty($mess)) echo $mess ?></label>
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
	<div id="body">
	  <div class="about">
		<table width="941" height="69" border="0" align="center">
          <tr style="font-family:Constantia; text-transform:capitalize;">
            <td height="34" style="color:#2a4f5e; font-size:30px;">User's Data</td>
            <td align="right" style="font-size:22px"><?php echo $n; ?></td>
          </tr>
        </table>
		<br><br>
		
		
		
<marquee behavior="slide" direction="down" scrolldelay="1" scrollamount="5"><div align="center" style="font-size:26px;font-family:Constantia; color:#2a4f5e;">Profile Data</div></marquee><br><br>
<form action="register.php? cat=change user-id" method="post" enctype="multipart/form-data">			
<table align="center" width="962" height="280" border="0" style="outline:#000000 solid thin; padding: 20px 20px 20px 20px;" bgcolor="#FFFFDD">
  <tr>
    <td rowspan="9" align="center" valign="top"><img width = "210" height="216" src="<?php echo $f[11]; ?>" style=" border-radius:30%; border:#000000 solid thin" /></td>
    <td width="48" rowspan="11" align="center" valign="top">&nbsp;</td>
    <td width="201" height="23" style="font-family:Constantia; font-size:18px; color:#2a4f5e;">Occupation :</td>
    <td width="400" style="font-family:Constantia; font-size:18px; text-transform:capitalize;"><?php echo $f[6]; ?></td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23" style="font-family:Constantia; font-size:18px; color:#2a4f5e;">Organization Name :</td>
	<td style="font-family:Constantia; font-size:18px; text-transform:capitalize;"><?php echo $f[7]; ?></td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
	 <td>&nbsp;</td>
  </tr>
   <tr>
     <td height="23" style="font-family:Constantia; font-size:18px; color:#2a4f5e;">Address :</td>
     <td style="font-family:'Times New Roman'; font-size:18px;"><?php echo $f[9]; ?></td>
   </tr>
   <tr>
     <td height="23">&nbsp;</td>
      <td>&nbsp;</td>
   </tr>
   <tr>
     <td height="23" style="font-family:Constantia; font-size:18px; color:#2a4f5e;">Country :</td>
     <td style="font-family:Constantia; font-size:18px;"><?php echo $f[8]; ?></td>
   </tr>
   <tr>
     <td height="23">&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td height="23" style="font-family:Constantia; font-size:18px; color:#2a4f5e;">Phone :</td>
     <td style="font-family:'Times New Roman'; font-size:20px;"><?php echo $f[10]; ?></td>
   </tr>
   <tr>
     <td height="23" align="center" style="font-family:Constantia; font-size:18px; color:#E41B17; text-transform:capitalize"><?php echo $f[1]; ?>&nbsp;&nbsp;<?php echo $f[2]; ?></td>
	 <td>&nbsp;</td>
     <td><span class="style150"></span></td>
   </tr>
   <tr>
   	  <td width="295" height="26" align="center" valign="bottom" style="font-family:'Times New Roman'; font-size:19px; color:#2a4f5e;">Date of Birth :&nbsp;&nbsp;<span style="color:black"><?php echo $f[3]; ?> &nbsp; <?php echo $f[4]; ?> , <?php echo $f[5]; ?></span></td>
      <td style="font-family:Constantia; font-size:18px; color:#2a4f5e;">Email ID :</td>
      <td style="font-family:'Times New Roman'; font-size:20px;"><?php echo $ue; ?>&nbsp;&nbsp;&nbsp;<input type="submit" value="Change" style="font-family:Constantia; font-size:16px" /></td>
   </tr>
</table>
</form>
		
<br><br><br>
	    
<marquee behavior="slide" direction="down" scrolldelay="1" scrollamount="5"><div align="center" style="font-size:26px;font-family:Constantia; color:#2a4f5e;">Security Data</div></marquee><br><br>
<table width="839" height="77" border="0" style="outline:#000000 solid thin; padding: 20px 20px 20px 20px" bgcolor="#FDEEF4" align="center">
  <tr>
     <td height="23" colspan="2" align="center" style="font-family:'Times New Roman'; font-size:21px; color:#2a4f5e;">Account Password :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="color:black"><?php echo str_rot13($f[12]); ?></span></td>
  </tr>
  <tr>
    <td height="20" colspan="2">&nbsp;</td>
  </tr>
  <tr style="font-family:'Times New Roman'; font-size:21px; color:#2a4f5e;">
    <td width="533" height="23">Security Question :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black"><?php echo $f[13]; ?></span></td>
    <td width="296" align="right">Security Answer :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black"><?php echo str_rot13($f[14]); ?></span></td>
  </tr>
</table>

<br><br><br>

<?php	$db[0]='house'; $db[1]='vehicle'; $db[2]='furniture'; $db[3]='study'; $db[4]='jewellery'; $db[5]='antique'; $db[6]='electronics'; $db[7]='item';
		$count=0;
		for($k=0;$k<8;$k++)	{
        	$q=mysql_query("select * from $db[$k] where email='$ue'");
		  	$r=mysql_num_rows($q);	// The Sequence Number of Rows
			if($r!=0) {
				if($count==0)	{
					$count++;	?>
<marquee behavior="slide" direction="down" scrolldelay="1" scrollamount="5">
<div align="center" style="font-size:26px;font-family:Constantia; color:#2a4f5e;">Uploaded advertisement</div>
</marquee><br><br>
<table align="center" style="width:960px; padding:20px 20px 20px 20px; outline:#000000 solid thin;" bgcolor="#F5F5DC">
<tr><td align="center">
<?php			}
				for($i=0;$i<$r;$i++)  {
					$f=mysql_fetch_array($q);
					$pic=$f['picture'];
					$id=$f['id'];	?>							  
&nbsp;&nbsp;<a href="itembid.php? cat=<?php echo $db[$k]; ?>&id=<?php echo $id;?>" target="_blank"><img src="<?php echo $pic; ?>" height="160" width="205" style="border-radius:20%; border:solid #000000 thin" title="<?php echo $db[$k]."-".$id;?>" /></a>&nbsp;&nbsp;
<?php  			}	
			}
		}	 ?>
</td></tr>
</table>					
			
	    </div>
      </div>
	</div>
		<div id="footer">
		  <div>
				<p>&copy Copyright 2015. All rights reserved</p>
			</div>
		</div>

	</body>
</html>