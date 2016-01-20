<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_GET['a']))
	$message=$_GET['a'];

if(isset($_GET['cat'])) {
	$cat=$_GET['cat'];
}
else  {
	header("location:#");
}

if(isset($_SESSION['email']))			//	if there is any logged in email-id in session 'email'
	$e=$_SESSION['email'];
elseif(isset($_COOKIE['email']))	{		//	if there is any logged in email-id in cookie 'email'
	$e=$_COOKIE['email'];
	$_SESSION['email']=$e;
}

if(isset($e))  {
	$q=mysql_query("select * from user where email='$e'");
	$f=mysql_fetch_array($q);
	if($f) {		//	if the page is accessed from user side
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

$now=mktime();			//	present timestamp
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		List of Auction Items
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title><?php echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item"; ?> Gallery</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="10">

<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<body onLoad="MM_preloadImages('../viewshare/images/aniket.jpg')">
<div id="header">
  <div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>
			<ul>
<?php	if(isset($_SESSION['email']))  { 
			if($page=='user') {  ?>
				<li><a href="profile.php">My Profile</a></li>
				<li><a href="mystore.php">New Advertise</a></li>
				<li class="selected"><a href="gallery.php">Gallery</a></li>
				<li><a href="createprofile.php">Settings</a></li>
<?php		}
			elseif($page=='admin') {  ?>
		  		<li><a href="admin.php">List of Emails</a></li>
		  		<li><a href="contactadmin.php">Messages</a></li>
		  		<li class="selected"><a href="gallery.php">Gallery</a></li>
		  		<li><a href="register.php? cat=new account">New Admin</a></li>								
<?php    	}	?>
		  		<li><a href="logout_code.php">Log Out</a></li>
<?php	}
		else  {  ?>
				<li><a href="index.php">Home</a></li>
				<li class="selected"><a href="gallery.php">Gallery</a></li>
				<li><a href="about.php">About Us</a></li>
				<li><a href="contact.php">Contact Us</a></li>	
				<li><a href="register.php? cat=new account">Create Account</a></li>						
<?php  	}  ?>
			</ul>
</div>
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px;"><?php if(!empty($message)) echo $message ?>
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
	<div id="body">
	  <div class="about">
		<table width="941" height="75" border="0" align="center">
          <tr style="font-family:Constantia; text-transform:capitalize;">
            <td height="34" style="color:#2a4f5e; font-size:30px;"><?php echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item"; ?> Gallery</td>
            <td width="259" align="right" style="font-size:22px;"><?php if(isset($_SESSION['email'])) { if($page=='user') { ?><a href="profile.php" style="text-decoration:none; color:black"><?php } echo $n; ?></a><?php } ?></td>
            <td width="65" align="right"><a href="profile.php"><?php if(isset($_SESSION['email']) && $page=='user') { ?><img width="50px" height="50px" src="<?php echo $pic; ?>" style="border-radius:50%;" title="Go to profile" /><?php } ?></a></td>
          </tr>
        </table>
	  </div>
	</div>


<div align="right" style="font-family:Andalus; font-size:20px; color:#2a4f5e">Change Category &nbsp;
   <select style="font-family:Constantia; font-size:16px;" onChange="MM_jumpMenu('parent',this,0)">
    <option <?php if($cat=='house') { ?> selected <?php } ?> value="? cat=house">House Gallery</option>
    <option <?php if($cat=='vehicle') { ?> selected <?php } ?> value="? cat=vehicle">Vehicle Gallery</option>
    <option <?php if($cat=='furniture') { ?> selected <?php } ?> value="? cat=furniture">Furniture Gallery</option>
    <option <?php if($cat=='study') { ?> selected <?php } ?> value="? cat=study">Study Material Gallery</option>
    <option <?php if($cat=='jewellery') { ?> selected <?php } ?> value="? cat=jewellery">Jewellery Gallery</option>
    <option <?php if($cat=='antique') { ?> selected <?php } ?> value="? cat=antique">Antique Item Gallery</option>
    <option <?php if($cat=='electronics') { ?> selected <?php } ?> value="? cat=electronics">Electronics Item Gallery</option>
    <option <?php if($cat=='item') { ?> selected <?php } ?> value="? cat=item">Other Item Gallery</option>
   </select> &nbsp;&nbsp;&nbsp;
</div>
		  
<?php   $q=mysql_query("select * from $cat");
		$r=mysql_num_rows($q);
		if($r>0)	{	?>
<marquee behavior="alternate" direction="down" scrolldelay="200" height="50px" style="font-family:Constantia; font-size:28px; color:#2a4f5e; text-align:center"> Choose <?php echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item"; ?> and start to bid </marquee>
<div align="right"><a href="#down"><img src="images/down.png"></a> &nbsp;&nbsp; </div>
<?php	}	
		for($i=0;$i<$r;$i++)	{
		$f=mysql_fetch_array($q);	?>

<table width="930" border="0" align="center" style="font-family:'Liberation Serif'; font-size:20px; padding:10px 10px 20px 20px;" bgcolor="#EAEAFA">
  <tr><td align="center">ID : <?php echo $cat."-".$f[0]; ?></td>
    <td width="18" rowspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="258" align="center"><a href="itembid.php? cat=<?php echo $cat; ?>& id=<?php echo $f[0]; ?>" target="_blank" title="Click to start bidding"><img src="<?php echo $f['picture']; ?>" height="200" width="250" style="border-radius:6%; border:solid #000000"/></a></td>
    <td width="629" height="27">
<span style="color:#FF6600;">Type :</span> &nbsp; <span style="text-transform:capitalize"><?php if($cat=='house') echo $f['category']; else echo $f['type']; ?></span> <br><br>

 This <?php if($cat=='house') echo $f['floor']." floored ".$f['category']; 
 			elseif($cat=='vehicle') echo $f['company']." ".$f['model']." ".$f['type']; 
			else echo $f['type'];
 if($now<$f['ts']) echo " will be sold on ".date('d F , Y',$f['ts']); else echo " was sold out"; ?>.<br>
 
 
<?php	 if($cat=='house') { echo "There are ".$f['room']." rooms"; if($f['aircondition']=='Yes') echo " with Air Condition system "; if($f['bathroom']=='Yes') echo " attached Bathroom & Toilet"; echo " and also good water supply system in the ".$f['category'];	?>.	<br><br>
<span style="color:#FF6600;">Location :</span> &nbsp; <span style="text-transform:capitalize"> <?php echo $f['city']." , ".$f['state']." , ".$f['country']; } ?> </span>

<?php	 if($cat=='vehicle') { if($f['engine']!='No Engine Based') echo "The ".$f['type']." is ".$f['engine']." based and engine capacity is ".$f['capacity']." CC. "; echo "The ".$f['type']." has ".$f['sit']." sits including driving sit."; }

	 	 elseif($cat=='furniture') { if($f['antique']=='Yes') echo "The ".$f['type']." is Antique. "; if($f['branded']=='Yes') echo "The ".$f['type']." is branded and brand name is ".$f['brand'].".";	}

	 	 elseif($cat=='study') { if($f['antique']=='Yes') echo "The ".$f['type']." is Antique. "; if($f['type']=='Book') echo "The publisher of the book is ".$f['brand']." and author is ".$f['author']."."; else echo "The brand name is ".$f['brand'].".";	} 

	 	 elseif($cat=='jewellery') { echo "The ".$f['type']." is madeby ".$f['material'].". "; if($f['antique']=='Yes') echo "The ".$f['type']." is Antique. "; echo "The brand name is ".$f['brand'].".";	}

	 	 elseif($cat=='antique') { echo "The ".$f['type']." was used by ".$f['user'].". "; if($f['branded']=='Yes') echo "The ".$f['type']." is branded and brand is ".$f['brand']."."; }

	 	 elseif($cat=='electronics') { echo "The ".$f['type']." is used for ".$f['purpose'].". The ".$f['type']." is working on ".$f['volt']." . It is mainly ".$f['current']." category.";	}

	 	 elseif($cat=='item') { echo "The ".$f['type']." is used for ".$f['purpose'].". "; if($f['branded']=='Yes') echo "This ".$f['type']." is branded and brand is ".$f['brand']." .";	}

 if($cat!='house') { echo " Age of the ".$f['type']." is "; if($f['year']!=0) echo $f['year']." year "; if($f['month']!=0) echo $f['month']." month"; echo "."; }	?><br><br>


<span style="color:#FF6600;"><?php if($f['bid_price']==0) echo "Expected Minimum Price (Rs.) : "; else echo "Last Bidding Price (Rs.) : "; ?></span> &nbsp; <?php echo $f['price']; ?> <span style="color:red; font-size:24px; font-weight:bold; padding-left:130px"> <?php if($now>$f['ts']) { echo "Sold Out !"; } ?> </span> </td>
  </tr>
</table>
<br><br>

<?php	}	
		if($r==0)	{	?>
<div align="center" style="font-family:Constantia; font-size:36px; color:#FF6600">Sorry, there is no advertisement in this moment !</div>
<?php	}	?>

 <div id="down" align="right"><a href="#top"><img src="images/top.png"></a> &nbsp;&nbsp; </div><br>
		<div id="footer">
		  <div>
				<p>&copy Copyright 2015. All rights reserved</p>
		  </div>
		</div>
</body>
</html>