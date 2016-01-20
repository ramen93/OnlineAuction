<?php
session_start();
if(isset($_GET['a']))
	$message=$_GET['a'];

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
		Document :-		Contact Us
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>Contact Us</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="300">
</head>
<body>
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
			<ul>
				<li><a href="index.php">Home</a></li>				
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="about.php">About Us</a></li>
				<li  class="selected"><a href="contact.php">Contact Us</a></li>
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
            <td height="34" style="color:#2a4f5e; font-size:30px;">Contact Us</td>
            <td align="right"><a href="profile.php" style="text-decoration:none; color:black; font-size:22px">&nbsp;</a></td>
          </tr>
        </table>
	  </div>
	</div>

		
<div align="justify" style="font-family:Andalus; font-size:20px; line-height:32px; color:#2a4f5e; padding:0px 68px 0px 68px">This website is designed only for public necessity. So any kind of help you can expect from us. If you feel any problem just like Server Problem, Login Problem or Others Problem , you can convay us. You send your problems through message in bellow box. We must response you as early as possible and try to find the solution. You can send us any feedback for our development. Because it is very important for us to know that what your need is.</div>
<br><br><br>
	

<form action="contact_code.php" method="post" enctype="multipart/form-data">		  
  <table align="center" bgcolor="#F5F5F5" style="padding: 20px 20px 20px 20px; border:black solid thin; ">
   <tr>
    <td width="156" height="29" style="font-family:Constantia; font-size:20px; color:#2a4f5e">Name :</td>
    <td width="360"><input type="text" name="name" size="40" style="font-size:18px; font-family:Constantia; text-transform:capitalize" value="<?php if(isset($_GET['name'])) echo $_GET['name']; ?>" placeholder="What is your name ?" maxlength="100" required="required"></td>
   </tr>
   <tr>
    <td height="20">&nbsp;</td>
    <td>&nbsp;</td>
   </tr>
   <tr>
    <td height="29" style="font-family:Constantia; font-size:20px; color:#2a4f5e">Email ID :</td>
    <td><input type="text" name="email" size="34" style="font-size:20px; font-family:'Times New Roman'; text-transform:lowercase" placeholder="Give your email-id" maxlength="100" required="required"></td>
   </tr>
   <tr>
    <td height="20">&nbsp;</td>
    <td>&nbsp;</td>
   </tr>
   <tr>
    <td height="20" style="font-family:Constantia; font-size:20px; color:#2a4f5e">Message Title :</td>
    <td><input type="text" name="mtitle" size="40" style="color:#000091; font-size:18px; font-family:Constantia; font-variant:small-caps; text-transform:capitalize"  value="<?php if(isset($_GET['mtitle'])) echo $_GET['mtitle']; ?>" placeholder="Give message title" maxlength="100" required="required"></td>
   </tr>
   <tr>
    <td height="20">&nbsp;</td>
    <td>&nbsp;</td>
   </tr>
   <tr>
    <td valign="top" style="font-family:Constantia; font-size:20px; color:#2a4f5e">Message :</td>
    <td><textarea name="message" style="height:170px; width:378px;color:#000091; font-size:20px; font-family:'Times New Roman';" placeholder="Write your message within 500 charecters" maxlength="500" required><?php if(isset($_GET['message'])) echo $_GET['message']; ?></textarea></td>
   </tr>
   <tr valign="bottom">
    <td height="42" style="font-family:Constantia; font-size:20px; color:#2a4f5e">Upload  Picture :</td>
    <td style="font-family:'Times New Roman'; font-size:18px; color:#999999"><input type="file" name="pic" style="font-size:16px; font-family:Constantia; color:black; width:230px" /> (within 500kb)</td>
   </tr>
  </table><br>
  
  <div align="right" style="width:765px"><input id="round" input type="submit" value="Send" style="font-family:Constantia; font-size:15px;" /><style type="text/css"> 

input#round{
width:50px; /*same as the height*/
height:50px; /*same as the width*/
background-color:perple;
border:1px solid perple; /*same colour as the background*/
color:#fff;
font-size:	1.6em;
font-style: bold;

/*set the border-radius at half the size of the width and height*/
-webkit-border-radius: 25px;
-moz-border-radius: 25px;
border-radius: 25px;
/*give the button a small drop shadow*/
-webkit-box-shadow: 0 0 10px rgba(0,0,0, .75);
-moz-box-shadow: 0 0 10px rgba(0,0,0, .75);
box-shadow: 2px 2px 15px rgba(0,0,0, .75);
}
/***NOW STYLE THE BUTTON'S HOVER STATE***/
input#round:hover{
background:black;
border:1px solid black;
font-style: bold;
/*reduce the size of the shadow to give a pushed effect*/
-webkit-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
-moz-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
box-shadow: 0px 0px 5px rgba(0,0,0, .75);
}
            
</style>
</div><br><br>
</form>
				
		<div id="footer">
		  <div>
				<p>&copy Copyright 2015. All rights reserved</p>
		  </div>
		</div>
</body>
</html>