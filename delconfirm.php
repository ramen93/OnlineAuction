<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_GET['b']))
$message=$_GET['b'];

if(isset($_SESSION['email']))				//	if there is any logged in email-id in session 'email'
	$e=$_SESSION['email'];
elseif(isset($_COOKIE['email']))	{		//	if there is any logged in email-id in cookie 'email'
	$e=$_COOKIE['email'];
	$_SESSION['email']=$e;
}

if(isset($_GET['cat']))	{		// categoty of items that will be deleted 
	$cat=$_GET['cat'];
}	
else 
	header("location:#");

if(isset($_GET['id']))		// id of item which will be deleted
	$id=$_GET['id'];

if(isset($_GET['k']))		// how mnay numbers of items to be deleted
	$k=$_GET['k'];

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

if($cat=='house' || $cat=='vehicle' || $cat=='furniture' || $cat=='study' || $cat=='jewellery' || $cat=='antique' || $cat=='electronics' || $cat=='item')	{
	$q=mysql_query("select * from $cat where id='$id'");
	$f=mysql_fetch_array($q);
	$pic=$f['picture'];
}	

if(isset($_SESSION['uemail']))
	$ue=$_SESSION['uemail'];
	
if($cat=='Bidder')	{
	$id=$_POST['bidding_id'];
	$advertisement_id=$_GET['advertisement_id'];
	$category=$_GET['category'];
}
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		Delete Confirmation
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>Delete <?php if($cat=='house' || $cat=='vehicle' || $cat=='furniture' || $cat=='study' || $cat=='jewellery' || $cat=='antique' || $cat=='electronics' || $cat=='item') echo " Advertisement"; else echo $cat; ?></title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="60">
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>
<body onLoad="MM_preloadImages('images/delete.png')">
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
		<ul>
<?php	if($page=='admin')	{	?>
		  <li><a href="admin.php">List of Emails</a></li>
		  <li><a href="contactadmin.php">Messages</a></li>
		  <li><a href="gallery.php">Gallery</a></li>
		  <li><a href="register.php? cat=new account">New Admin</a></li>
<?php	}	else	{	?>
		  <li><a href="profile.php">My Profile</a></li>
<?php	if($page=='user' && ($cat=='house' || $cat=='vehicle' || $cat=='furniture' || $cat=='study' || $cat=='jewellery' || $cat=='antique' || $cat=='electronics' || $cat=='item'))	{	?>
      	  <li><a href="mystore.php">My Store</a></li>
		  <li><a href="gallery.php">Gallery</a></li>
		  <li><a href="createprofile.php">Settings</a></li>
<?php	}	elseif($page=='user' && $cat=='account')	{	?>
		  <li><a href="createprofile.php">Edit Profile</a></li>
		  <li><a href="verifysecurity.php? cat=editsec">Change Security</a></li>
		  <li class="selected"><a href="verifysecurity.php? cat=delacc">Delete Account</a></li>
<?php	}	}	?>
		  <li><a href="logout_code.php">Log Out</a></li>
		</ul>
</div>
	
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px; color:red"><?php if(!empty($message)) echo $message; ?>
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
	
   <div id="body">
	<div class="about">
	 <table width="941" height="75" border="0" align="center">
      <tr style="font-family:Constantia; text-transform:capitalize;">
      <td height="34" style="color:#2a4f5e; font-size:30px;">Delete <?php if($cat=='house' || $cat=='vehicle' || $cat=='furniture' || $cat=='study' || $cat=='jewellery' || $cat=='antique' || $cat=='electronics' || $cat=='item') echo " Advertisement"; else echo $cat; ?></td>
      <td width="259" align="right" style="font-size:22px;"><?php if($page=='user') { ?><a href="profile.php" style="text-decoration:none; color:black"><?php } echo $n; ?></a></td>
      <td width="65" align="right"><a href="profile.php"><?php if($page=='user') { ?><img width="50px" height="50px" src="<?php echo $pic; ?>" style="border-radius:50%;" title="Go to profile" /><?php } ?></a></td>
     </tr>
    </table>
<br><br><br>

<table width="852" height="244" border="0" align="center">
    <tr>
      <td width="557" height="113" style="font-size:100px; font-family:Georgia; color:#2a4f5e">Are you sure </td>
      <td width="48">&nbsp;</td>
	  <td width="233" rowspan="3" valign="bottom">
<?php if($cat=='house' || $cat=='vehicle' || $cat=='furniture' || $cat=='study' || $cat=='jewellery' || $cat=='antique' || $cat=='electronics' || $cat=='item' || ($cat=='account' && $page=='user')) { ?>
	 <marquee behavior="slide" direction="down" scrollamount="30" scrolldelay="1">
	 <img src="<?php echo $pic; ?>" height="190" width="230" style="border-radius:20%; border:solid #000000 thin" title="<?php if($cat=='account' && $page=='user') echo $n; else echo $cat."-".$id; ?>"/></marquee>
<?php  }  ?></td>
    </tr>
    <tr>
      <td height="40" align="right" style="font-size:30px; font-family:'Times New Roman'; color:#666666">to delete 
<?php if(($page=='user')||($page=='admin' && $cat=='account' && $id==$e))	echo "your ".$cat;
	  elseif(($page=='admin' && $cat=='account' && $id!=$e)||($k==1 && ($cat=='user account' || $cat=='message')) || $cat=='Bidder')	echo "this ".$cat;
	  elseif($cat=='house' || $cat=='vehicle' || $cat=='furniture' || $cat=='study' || $cat=='jewellery' || $cat=='antique' || $cat=='electronics' || $cat=='item') echo "this advertisement";
	  elseif(isset($_GET['k']) && $k>1) echo "these ".$k." ".$cat."s";	?> ?&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="83" align="right" valign="bottom">
	  <label style="padding-right:80px"><a href="delete_code.php? page=<?php echo $page; ?>& cat=<?php echo $cat; ?>& k=<?php echo $k; ?>& id=<?php echo $id; ?>& category=<?php echo $category; ?> &advertisement_id=<?php echo $advertisement_id; ?>" title="Click to delete permanently" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('delete','','images/delete.png',1)"><img src="images/y.png" name="delete"></a></label>
	  <a href="<?php if($page=='user') echo "profile.php";
	  				 elseif($page=='admin' && ($cat=='account' || $cat=='user account')) echo "admin.php";
					 elseif($cat=='message') echo "contactadmin.php";
					 elseif($cat=='house' || $cat=='vehicle' || $cat=='furniture' || $cat=='study' || $cat=='jewellery' || $cat=='antique' || $cat=='electronics' || $cat=='item')  echo "itembid.php? cat=".$cat."&id=".$id;
					 elseif($cat=='Bidder')  echo "bidderlist.php? cat=".$category."&id=".$advertisement_id; ?>" title="Click to cancel deletion" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('nodel','','images/never.png',1)">
	  <img src="images/n.png" name="nodel"></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td>&nbsp;</td>
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