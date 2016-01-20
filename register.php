<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_GET['a']))
	$message=$_GET['a'];
if(isset($_GET['b']))
	$mess=$_GET['b'];

$page='index';

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
		$pic=$f['picture'];
		$page='user';
	}
	else  {			//	if the page is accessed from admin side
		$q=mysql_query("select * from admin where email='$e'");
		$f=mysql_fetch_array($q);
		$page='admin';
	}
	$n=$f['name'];		//	name of the account logger
}

if(isset($_GET['cat']))				// category of which work it does, create new account or security update
	$cat=$_GET['cat'];
else
	header("location:#");	

if(isset($_GET['remail']))			// validation checked email
	$re=$_GET['remail'];
else
	$re="" ;
if(isset($_GET['cemail']))			// confirmed email means valid email
	$ce=$_GET['cemail'];
else
	$ce="" ;
if(isset($_GET['aemail']))			//	selected email-id means it may be not account logger-id
	$ae=$_GET['aemail'];	
	
if(isset($_GET['name']))			//	admin name
	$rn=$_GET['name'];
else
	$rn="" ;
?>

<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		Register
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title><?php echo $cat; ?></title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="300">
</head>
<body>
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
		       <ul>
<?php	if($page=='admin') {  ?>
				<li><a href="admin.php">List of Emails</a></li>
				<li><a href="contactadmin.php">Messages</a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li <?php if($cat=='new account') { ?> class="selected" <?php } ?> ><a href="register.php? cat=new account">New Admin</a></li>
				<li><a href="logout_code.php">Log Out</a></li>		
<?php	}
		elseif($page=='index') {   ?>
			  	<li><a href="index.php">Home</a></li>
			  	<li><a href="gallery.php">Gallery</a></li>         
			  	<li><a href="about.php">About Us</a></li>		 
			  	<li><a href="contact.php">Contact Us</a></li>
			  	<li <?php if($cat=='new account') {  ?> class="selected" <?php } ?>><a href="register.php? cat=new account">Create Account</a></li>
<?php	}
		elseif($page=='user') {  ?>
				<li><a href="profile.php">My Profile</a></li>
				<li><a href="createprofile.php">Edit Profile</a></li>				
				<li class="selected"><a href="verifysecurity.php? cat=editsec">Change Security</a></li>
				<li><a href="verifysecurity.php? cat=delacc">Delete Account</a></li>
				<li><a href="logout_code.php">Log Out</a></li>
<?php	}		?>			
			</ul>
	</div>
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px;"><?php if(!empty($message)) echo $message; ?><label style="color:red"><?php if (!empty($mess)) echo $mess ?></label>
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
      <td height="34" style="color:#2a4f5e; font-size:30px;"><?php echo $cat; ?></td>
      <td width="259" align="right" style="font-size:22px;"><?php if(isset($_SESSION['email'])) { if($page=='user') { ?><a href="profile.php" style="text-decoration:none; color:black"><?php } echo $n; ?></a><?php } ?></td>
      <td width="65" align="right"><a href="profile.php"><?php if(isset($_SESSION['email']) && $page=='user') { ?><img width="50px" height="50px" src="<?php echo $pic; ?>" style="border-radius:50%;" title="Go to profile" /><?php } ?></a></td>
     </tr>
    </table>
   </div>
  </div>		



<?php if($page=='admin' || ($page=='index' && $cat=='new account'))	{	?>
<form action="register_code.php? page=<?php echo $page; ?>& cat=<?php echo $cat; ?>& data=vcheck& <?php if(isset($_GET['aemail'])) echo "aemail=".$ae; ?>" method="post" enctype="multipart/form-data">
  <table width="820" border="0" align="center">
	<tr>
      <td width="232" height="20" style="font-family:Constantia; font-size:20px; color:#2a4f5e">Enter an Email ID : </td>
	  <td width="370"><input type="text" name="remail" title="Email-id" size="40" style="font-family:'Open Sans'; font-size:16px; text-transform:lowercase" value="<?php echo $re ?>" placeholder="Enter an email-id as your login-id" maxlength="100" required></td>
      <td width="204"><input id="round" input type="submit" value="Check Validation" style="font-family:Constantia; font-size:12px;">
	  <style type="text/css"> 

input#round{
width:100px; /*same as the height*/
height:30px; /*same as the width*/
background-color:perple;
border:1px solid perple; /*same colour as the background*/
color:#fff;
font-size:	1.6em;
font-style: bold;

/*set the border-radius at half the size of the width and height*/
-webkit-border-radius: 20px;
-moz-border-radius: 20px;
border-radius: 20px;
/*give the button a small drop shadow*/
-webkit-box-shadow: 0 0 10px rgba(0,0,0, .75);
-moz-box-shadow: 0 0 10px rgba(0,0,0, .75);
box-shadow: 2px 2px 15px rgba(0,0,0, .75);
}
/***NOW STYLE THE BUTTON'S HOVER STATE***/
input#round:hover{
background:#c20b0b;
border:1px solid #c20b0b;
font-style: bold;
/*reduce the size of the shadow to give a pushed effect*/
-webkit-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
-moz-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
box-shadow: 0px 0px 5px rgba(0,0,0, .75);
}
            
</style>
</td>
	</tr>
  </table>
</form>
			
<br><br>			

<?php	if($page=='admin' || ($page=='index' && $cat=='new account')) { ?>
<form action="register_code.php? page=<?php echo $page; ?>& cat=<?php echo $cat; ?>& data=other& remail=<?php echo $re; ?>& <?php if(isset($_GET['aemail'])) echo "aemail=".$ae; ?>" method="post" enctype="multipart/form-data">
<?php	}	?>			
  <table width="819" border="0" align="center">
    <tr>
      <td width="231" style="font-family:Constantia; font-size:20px; color:#2a4f5e">Confirmed Email ID :</td>
      <td width="374"><input type="text" name="conemail" title="Same Email-id" size="40" style="font-family:'Open Sans'; font-size:16px; text-transform:lowercase" value="<?php echo $ce ?>" placeholder="Re-enter the email-id" maxlength="100" onpaste="return false" required></td>
      <td width="200"><?php  if($cat=='change security data')	{	?><input type="submit" value="Change ID" style="font-family:Constantia; font-size:16px;" /> <?php	}	?></td>
    </tr>
<?php	if($cat=='change user-id')	{	?>
    <tr valign="bottom">
      <td height="38" colspan="3" align="right" style="padding-right:240px"><input type="submit" value="Change User ID" style="font-family:Constantia; font-size:16px;">   </td>
    </tr>
<?php	}	?>
  </table>
<?php	if($page=='admin' && $cat=='change security data') { ?>  </form>	<?php	}	?>	
<br><br><br>
<?php }


	  if($page=='admin' && $cat!='change user-id')	{
		if($page=='admin' && $cat=='change security data') { ?>
<form action="register_code.php? page=<?php echo $page; ?>& cat=<?php echo $cat; ?>& data=editname& <?php if(isset($_GET['aemail'])) echo "aemail=".$ae; ?>" method="post" enctype="multipart/form-data">
<?php	}	?>	
  <table width="821" border="0" align="center">
   <tr>
    <td width="231" height="20" style="font-family:Constantia; font-size:20px; color:#2a4f5e">Administrator Name : </td>
    <td width="376"><input type="text" name="name" title="Admin Name" size="36" style="font-family:Constantia; font-size:18px; text-transform:capitalize" value="<?php echo $rn ?>" placeholder="Enter administrator's name" maxlength="100" required></td>
    <td width="200">
<?php  if($cat=='change security data')	{ ?><input type="submit" value="Change Name" style="font-family:Constantia; font-size:16px;" /><?php  }	?></td>
   </tr>
  </table>
<?php  if($page=='admin' && $cat=='change security data') { ?>	</form>	<?php	}	?>
<br><br><br>				
<?php }



	  if($cat!='change user-id')	{
		if($cat=='new account') { 	?>
  <table width="994" height="31" border="0" align="center" cellspacing="0" style="padding: 0px 15px 15px 15px; outline:#000000 solid thin;" bgcolor="#F5F5DC">
<?php 	}
		else	{ ?>
  <table width="994" height="31" border="0" align="center" cellspacing="0">
<?php 	}	 ?>
   <tr>
    <td width="448" height="31" align="center">
<?php	if($cat=='change security data') { ?>
<form action="register_code.php? page=<?php echo $page; ?>& cat=<?php echo $cat; ?>& data=pass& remail=<?php echo $re ?>& <?php if(isset($_GET['aemail'])) { echo "aemail=".$ae; }  ?>" method="post" enctype="multipart/form-data">
<?php	}	?>
	  <table width="448" border="0" style="padding:15px 15px 15px 15px; <?php if($cat=='change security data') { ?> outline:#000000 solid thin; background-color:#FBF6D9 <?php  }  ?>">
	   <tr>
		<td height="31" colspan="2" align="center" style="font-family:Constantia; font-size:24px; font-weight:bold; text-decoration:underline">Password</td>
	   </tr>
	   <tr>
		<td colspan="2" height="30">&nbsp;</td>
	   </tr>
	   <tr>
		<td width="255" style="font-family:Constantia; font-size:20px;">New Password : </td>
		<td width="180"><input type="password" name="npwd" title="Enter at least 6 charecters" size="18" style="font-family:'Courier New'; font-size:16px; font-weight:bolder;" placeholder="Enter password" maxlength="15" required /></td>
	   </tr>
	   <tr>
		<td colspan="2">&nbsp;</td>
	   </tr>
	   <tr>
		<td style="font-family:Constantia; font-size:20px;">Confirmed Password :</td>
		<td><input type="password" name="cpwd" title="Re-enter those charecters" size="18" style="font-family:'Courier New'; font-size:16px; font-weight:bolder;" placeholder="Re-enter password" maxlength="15" onpaste="return false" required /></td>
	   </tr>
	   <tr>
		<td colspan="2">&nbsp;</td>
	   </tr>
<?php	if($cat=='change security data') { ?>
	   <tr>
		<td height="33" colspan="2" align="right"><input id="round" input type="submit" value="Update" style="font-family:Constantia; font-size:16px;" />
		<style type="text/css"> 

input#round{
width:100px; /*same as the height*/
height:30px; /*same as the width*/
background-color:perple;
border:1px solid perple; /*same colour as the background*/
color:#fff;
font-size:	1.6em;
font-style: bold;

/*set the border-radius at half the size of the width and height*/
-webkit-border-radius: 20px;
-moz-border-radius: 20px;
border-radius: 20px;
/*give the button a small drop shadow*/
-webkit-box-shadow: 0 0 10px rgba(0,0,0, .75);
-moz-box-shadow: 0 0 10px rgba(0,0,0, .75);
box-shadow: 2px 2px 15px rgba(0,0,0, .75);
}
/***NOW STYLE THE BUTTON'S HOVER STATE***/
input#round:hover{
background:#c20b0b;
border:1px solid #c20b0b;
font-style: bold;
/*reduce the size of the shadow to give a pushed effect*/
-webkit-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
-moz-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
box-shadow: 0px 0px 5px rgba(0,0,0, .75);
}
            
</style>
</td>
	   </tr>
<?php	}	?>	  
	  </table>
<?php 	if($cat=='change security data') { ?>	</form>		<?php	}	?>
	</td>

<?php	if(!($cat=='change security data' && $page=='index')) { ?>
    <td width="36"><span class="style137"></span></td>
    <td width="504" height="31" align="center">
<?php	 if($cat=='change security data') { ?>
	<form action="register_code.php? page=<?php echo $page; ?>& cat=<?php echo $cat; ?>& data=qsan& remail=<?php echo $re ?>& <?php if(isset($_GET['aemail'])) { echo "aemail=".$ae; }  ?>" method="post" enctype="multipart/form-data">
<?php	 }	?>
	  <table width="505" border="0" style="padding:15px 15px 15px 15px; <?php if($cat=='change security data')  {  ?> outline:#000000 solid thin; background-color:#FBF6D9<?php  }  ?>" >
       <tr>
        <td height="31" colspan="2" align="center" style="font-family:Constantia; font-size:24px; font-weight:bold"><u>Security Question / Answer</u></td>
       </tr>
       <tr>
        <td colspan="2" height="30">&nbsp;</td>
       </tr>
       <tr>
        <td width="219" height="27" style="font-family:Constantia; font-size:20px;">Security Question : </td>
        <td width="276">
		  <select name="ques" title="Security Question" style="font-family:Constantia; font-size:16px" required="required">
          <option selected="selected" value="">Select the security question</option>
          <option>What is your nickname ?</option>
          <option>What is your fabourite dish ?</option>
          <option>Where is your mother's birthplace ?</option>
          <option>What is the name of your pet ?</option>
          <option>Who is your best friend ?</option>
          <option>What is your fabourite color ?</option>
          </select></td>
       </tr>
       <tr>
        <td colspan="2">&nbsp;</td>
       </tr>
       <tr>
        <td height="27" style="font-family:Constantia; font-size:20px;">Security Answer :</td>
        <td><input type="text" name="ans" title="Security Answer" size="32"  style="font-family:Constantia; font-size:16px;" placeholder="Enter security answer" maxlength="20" required /></td>
       </tr>
       <tr>
        <td colspan="2">&nbsp;</td>
       </tr>
<?php	 if($cat=='change security data') { ?>
       <tr>
        <td height="29" colspan="2" align="right"><input id="round" input type="submit" value="Update" style="font-family:Constantia; font-size:16px;" />
		<style type="text/css"> 

input#round{
width:100px; /*same as the height*/
height:30px; /*same as the width*/
background-color:perple;
border:1px solid perple; /*same colour as the background*/
color:#fff;
font-size:	1.6em;
font-style: bold;

/*set the border-radius at half the size of the width and height*/
-webkit-border-radius: 20px;
-moz-border-radius: 20px;
border-radius: 20px;
/*give the button a small drop shadow*/
-webkit-box-shadow: 0 0 10px rgba(0,0,0, .75);
-moz-box-shadow: 0 0 10px rgba(0,0,0, .75);
box-shadow: 2px 2px 15px rgba(0,0,0, .75);
}
/***NOW STYLE THE BUTTON'S HOVER STATE***/
input#round:hover{
background:#c20b0b;
border:1px solid #c20b0b;
font-style: bold;
/*reduce the size of the shadow to give a pushed effect*/
-webkit-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
-moz-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
box-shadow: 0px 0px 5px rgba(0,0,0, .75);
}
            
</style>
</td>
       </tr>
<?php	 }	?>	
      </table>
<?php	 if($cat=='change security data') { ?>	</form>		<?php	}	?>
	 </td>
<?php	}	?>	
    </tr>
   </table><br>
<?php	if($cat=='new account') { ?> <div align="center"><input id="round" input type="submit" value="Create Account" style="font-family:Constantia; font-size:12px;">
<style type="text/css"> 

input#round{
width:100px; /*same as the height*/
height:30px; /*same as the width*/
background-color:perple;
border:1px solid perple; /*same colour as the background*/
color:#fff;
font-size:	1.6em;
font-style: bold;

/*set the border-radius at half the size of the width and height*/
-webkit-border-radius: 20px;
-moz-border-radius: 20px;
border-radius: 20px;
/*give the button a small drop shadow*/
-webkit-box-shadow: 0 0 10px rgba(0,0,0, .75);
-moz-box-shadow: 0 0 10px rgba(0,0,0, .75);
box-shadow: 2px 2px 15px rgba(0,0,0, .75);
}
/***NOW STYLE THE BUTTON'S HOVER STATE***/
input#round:hover{
background:#c20b0b;
border:1px solid #c20b0b;
font-style: bold;
/*reduce the size of the shadow to give a pushed effect*/
-webkit-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
-moz-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
box-shadow: 0px 0px 5px rgba(0,0,0, .75);
}
            
</style>
</div> <?php	}
	}	?>
<br /><br />		
<?php if(($page=='admin' && $cat!='change security data') || ($page=='index' && $cat=='new account')) { ?>  </form>	<?php	}	?>		
				
	  	  	
		<div id="footer">
		  <div>
				<p>&copy Copyright 2015. All rights reserved</p>
		  </div>
		</div>	
</body>
</html>