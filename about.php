<?php
session_start();
if(isset($_SESSION['email']))			//	if there is any logged in email-id in session 'email'
	$e=$_SESSION['email'];
elseif(isset($_COOKIE['email']))	{		//	if there is any logged in email-id in cookie 'email'
	$e=$_COOKIE['email'];
	$_SESSION['email']=$e;
}

if(!empty($e))  {		//	if account is logged in, then page is redirect to index.php
	header("location:index.php");
}
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		About Us
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>About Us</title>
<link rel="shortcut icon" href="images/icon.png">
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<meta http-equiv="refresh" content="120">
</head>
<body>
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li class="selected"><a href="about.php">About us</a></li>
				<li><a href="contact.php">Contact Us</a></li>	
				<li><a href="register.php? cat=new account">Create Account</a></li>
			</ul>		
	</div>
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px;"><?php if(!empty($message)) echo $message; ?>
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
		<table width="941" height="69" border="0" align="center">
          <tr style="font-family:Constantia; text-transform:capitalize;">
            <td height="34" style="color:#2a4f5e; font-size:30px;">About Us</td>
            <td align="right"><a href="profile.php" style="text-decoration:none; color:black; font-size:22px">&nbsp;</a></td>
          </tr>
        </table>
		<br><br>
		
				
				
  <table width="975" border="0" align="center">
   <tr valign="top" height="60"><td colspan="6" style="font-family:Andalus; font-size:36px; color:#2a4f5e;"><marquee behavior="alternate" onMouseOver="stop()" onMouseOut="start()">What does Online Auction mean?</marquee></td></tr>
   <tr valign="top" height="180"><td colspan="6" style="font-family:Gabriola; font-size:30px; line-height:36px; text-align:justify">An online auction is a service in which auction users or participants sell or bid for products or services via the Internet. Virtual auctions facilitate online activities between buyers and sellers in different locations or geographical areas. Various auction sites provide users with platforms powered by different types of auction software. An online auction is also known as a virtual auction.</td></tr>
   <tr valign="top" height="60" align="center"><td colspan="6" style="font-family:Andalus; font-size:36px; color:#2a4f5e;"><marquee behavior="alternate" onMouseOut="start()"onMouseOver="stop()" width="300px">About the Project</marquee></td></tr>
   <tr valign="top" height="100"><td colspan="6" style="font-family:Gabriola; font-size:30px; line-height:36px; text-align:justify">This website is created for Academic Purpose. It is a Final Year Project of B.Tech Students. Project Topic is Online Auction.</td></tr>
   <tr valign="top" height="60"><td colspan="6" style="font-family:Andalus; font-size:36px; color:#2a4f5e;"><marquee behavior="alternate" direction="down" height="60" onMouseOver="stop()" onMouseOut="start()" style="text-align:center">About the Web Designers</marquee></td></tr>
   <tr valign="top" height="100"><td colspan="6" style="font-family:Gabriola; font-size:30px; line-height:36px; text-align:justify">This website is created by Final year students of Information Technology of Birbhum Institute of Engineering &amp; Technology (Suri , Birbhum). The designers are :</td></tr>
   <tr align="center" valign="bottom" height="200">
    <td width="154"><marquee behavior="alternate" direction="down" height="190" scrolldelay="200" onMouseOver="stop()" onMouseOut="start()"><img src="images/1.jpg" height="170px" width="130px" style="border-radius:50%; border:black solid thin" title="Email : aniketmazumdar1994@outlook.com"></marquee></td>
    <td width="154"><marquee behavior="alternate" direction="down" height="190" scrolldelay="200" onMouseOver="stop()" onMouseOut="start()"><img src="images/2.jpg" height="170px" width="130px" style="border-radius:50%; border:black solid thin" title="Email: debjyoti.sarkar1993@gmail.com"></marquee></td>
    <td width="154"><marquee behavior="alternate" direction="down" height="190" scrolldelay="200" onMouseOver="stop()" onMouseOut="start()"><img src="images/3.jpg" height="170px" width="130px" style="border-radius:50%; border:black solid thin" title="Email: ramenmaji93@gmail.com"></marquee></td>
    <td width="154"><marquee behavior="alternate" direction="down" height="190" scrolldelay="200" onMouseOver="stop()" onMouseOut="start()"><img src="images/4.jpg" height="170px" width="130px" style="border-radius:50%; border:black solid thin" title="Email: spaul0000@gmail.com"></marquee></td>
    <td width="154"><marquee behavior="alternate" direction="down" height="190" scrolldelay="200" onMouseOver="stop()" onMouseOut="start()"><img src="images/5.jpg" height="170px" width="130px" style="border-radius:50%; border:black solid thin" title="Email: saikat.snt@gmail.com"></marquee></td>
    <td width="161"><marquee behavior="alternate" direction="down" height="190" scrolldelay="200" onMouseOver="stop()" onMouseOut="start()"><img src="images/6.jpg" height="170px" width="130px" style="border-radius:50%; border:black solid thin" title="Email: "></marquee></td>
   </tr>
   <tr align="center" valign="bottom" style="font-family:Gabriola; font-size:26px; color:#000080">
    <td>Aniket Mazumdar</td>
    <td>Debjyoti Sarkar</td>
    <td>Ramen Maji</td>
    <td>Sagar Paul</td>
    <td>Saikat Bannerjee</td>
    <td>Suniti Kumari</td>
   </tr>
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