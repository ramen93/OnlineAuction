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

$now=mktime();			//	present timestamp
$db[1]='house'; $db[2]='vehicle'; $db[3]='furniture'; $db[4]='study'; $db[5]='jewellery'; $db[6]='antique'; $db[7]='electronics'; $db[8]='item';
for($i=1;$i<9;$i++) {
	$q=mysql_query("select * from $db[$i]");
	$r=mysql_num_rows($q);		//	The Sequence Number of Rows
	for($j=0;$j<$r;$j++)	{		//	in case of all same category advertisement 
		$f=mysql_fetch_array($q);
		if($f['ts']<$now)	{		//	if bidding time is expired
			$deltime=$f['ts']+12*60*60;		//	sold out advertisement will be deleted automatically after 12 hours of last bidding time
			if($deltime<$now)	{		//	if deltime is expired
				$q=mysql_query("delete from $db[$i] where id='".$f['id']."'");		//	then delete from advertisement from database
				unlink($f['picture']);		//	delete advertisement picture from hard disk
				$q=mysql_query("delete from bidders where category='$db[$i]' and advertisement_id='".$f['id']."'");
			}
		}		
	}
}
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		Gallery
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>Gallery</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="120">
</head>
<body>
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
			<ul id="slide">
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
	
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px;">
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999">
	<script type="text/javascript">
tday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");

function GetClock(){
var d=new Date();
var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear(),nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

     if(nhour==0){ap=" AM";nhour=12;}
else if(nhour<12){ap=" AM";}
else if(nhour==12){ap=" PM";}
else if(nhour>12){ap=" PM";nhour-=12;}

if(nyear<1000) nyear+=1900;
if(nmin<=9) nmin="0"+nmin;
if(nsec<=9) nsec="0"+nsec;

document.getElementById('clockbox').innerHTML=""+tday[nday]+", "+tmonth[nmonth]+" "+ndate+", "+nyear+" "+nhour+":"+nmin+":"+nsec+ap+"";
}

window.onload=function(){
GetClock();
setInterval(GetClock,1000);
}
</script>
<div id="clockbox" style="font:14pt Arial; color:#FF0000;"></div>
	</span></div>
	<div id="body">
	  <div class="about">
  <table width="941" height="75" border="0" align="center">
   <tr style="font-family:Constantia; text-transform:capitalize;">
    <td height="34" style="color:#2a4f5e; font-size:30px;">Gallery</td>
    <td width="259" align="right" style="font-size:22px;"><?php if(isset($_SESSION['email'])) { if($page=='user') { ?><a href="profile.php" style="text-decoration:none; color:black"><?php } echo $n; ?></a><?php } ?></td>
    <td width="65" align="right"><a href="profile.php"><?php if(isset($_SESSION['email']) && $page=='user') { ?><img width="50px" height="50px" src="<?php echo $pic; ?>" style="border-radius:50%;" title="Go to profile" /><?php } ?></a></td>
   </tr>
  </table>
<br><br>


<div align="center" style="font-family:Constantia; font-size:28px; color:#2a4f5e"><marquee behavior="alternate">Choose an Auction Category to see the list of objects</marquee></div><br>			
  <table width="940" height="468" border="0" align="center" style="padding:20px 0px 25px 0px; outline:#000000 solid thin;" bgcolor="#FFFFCC">
   <tr align="center" style="font-family:Constantia; font-size:24px;">
    <td width="235" height="26"><a href="list.php? cat=house" style="text-decoration:none; color:black">House</a></td>
    <td width="235"><a href="list.php? cat=vehicle" style="text-decoration:none; color:black">Vehicle</a></td>
    <td width="235"><a href="list.php? cat=furniture" style="text-decoration:none; color:black">Furniture</a></td>
    <td width="235"><a href="list.php? cat=study" style="text-decoration:none; color:black">Study Material</a></td>
   </tr>
   <tr align="center" valign="bottom">
    <td height="180"><a href="list.php? cat=house" title="House Gallery"><img src="images/h2.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="list.php? cat=vehicle" title="Vehicle Gallery"><img src="images/v2.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="list.php? cat=furniture" title="Furniture Gallery"><img src="images/f2.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="list.php? cat=study" title="Study Material Gallery"><img src="images/sm2.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
   </tr>
   <tr align="center" valign="bottom" style="font-family:Constantia; font-size:24px;">
    <td width="235" height="71"><a href="list.php? cat=jewellery" style="text-decoration:none; color:black">Jewellery</a></td>
    <td width="235"><a href="list.php? cat=antique" style="text-decoration:none; color:black">Antique Item</a></td>
    <td width="235"><a href="list.php? cat=electronics" style="text-decoration:none; color:black">Electronics Item</a></td>
    <td width="235"><a href="list.php? cat=item" style="text-decoration:none; color:black">Other Item</a></td>
   </tr>
   <tr align="center" valign="bottom">
    <td height="180"><a href="list.php? cat=jewellery" title="Jewellery Gallery"><img src="images/j2.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="list.php? cat=antique" title="Antique Item Gallery"><img src="images/a2.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="list.php? cat=electronics" title="Electronics Item Gallery"><img src="images/e2.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="list.php? cat=item" title="Other Item Gallery"><img src="images/o2.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
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