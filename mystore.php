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
	$n=$f['name'];
	$pic=$f['picture'];
}
else  {
	header("location:index.php? b=You're not logged in! Log in first");
}
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		My Store
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>My Store</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="120">
</head>
<body>
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
			<ul>
				<li><a href="profile.php">My Profile</a></li>
				<li class="selected"><a href="mystore.php">New Advertise</a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="createprofile.php">Settings</a></li>
				<li><a href="logout_code.php">Log Out</a></li>		
			</ul>
	</div>
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px;"><?php if(!empty($message)) echo $message; ?>
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
	<div id="body">
	  <div class="about">
		<table width="941" height="75" border="0" align="center">
          <tr style="font-family:Constantia; text-transform:capitalize;">
            <td height="34" style="color:#2a4f5e; font-size:30px;">My Store</td>
            <td width="259" align="right"><a href="profile.php" style="text-decoration:none; color:black; font-size:22px"><?php echo $n; ?></a></td>
            <td width="65" align="right"><a href="profile.php"><img width="50px" height="50px" src="<?php echo $pic; ?>" style="border-radius:50%;" title="Go to profile" /></a></td>
          </tr>
        </table>
		<br><br><br>
		

<div align="center" style="font-family:Constantia; font-size:28px; color:#2a4f5e"><marquee behavior="alternate">Choose a Category which you want to upload</marquee></div><br>			
  <table width="940" height="468" border="0" align="center" style="padding:20px 0px 25px 0px; outline:#000000 solid thin;" bgcolor="#95B9C7">
   <tr align="center" style="font-family:Constantia; font-size:24px;">
    <td width="235" height="26"><a href="newadvertise.php? cat=house" style="text-decoration:none; color:black">House</a></td>
    <td width="235"><a href="newadvertise.php? cat=vehicle" style="text-decoration:none; color:black">Vehicle</a></td>
    <td width="235"><a href="newadvertise.php? cat=furniture" style="text-decoration:none; color:black">Furniture</a></td>
    <td width="235"><a href="newadvertise.php? cat=study" style="text-decoration:none; color:black">Study Material</a></td>
   </tr>
   <tr align="center" valign="bottom">
    <td height="180"><a href="newadvertise.php? cat=house" title="House Advertisement"><img src="images/h1.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="newadvertise.php? cat=vehicle" title="Vehicle Advertisement"><img src="images/v1.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="newadvertise.php? cat=furniture" title="Furniture Advertisement"><img src="images/f1.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="newadvertise.php? cat=study" title="Study Material Advertisement"><img src="images/sm1.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
   </tr>
   <tr align="center" valign="bottom" style="font-family:Constantia; font-size:24px;">
    <td width="235" height="71"><a href="newadvertise.php? cat=jewellery" style="text-decoration:none; color:black">Jewellery</a></td>
    <td width="235"><a href="newadvertise.php? cat=antique" style="text-decoration:none; color:black">Antique Item</a></td>
    <td width="235"><a href="newadvertise.php? cat=electronics" style="text-decoration:none; color:black">Electronics Item</a></td>
    <td width="235"><a href="newadvertise.php? cat=item" style="text-decoration:none; color:black">Other Item</a></td>
   </tr>
   <tr align="center" valign="bottom">
    <td height="180"><a href="newadvertise.php? cat=jewellery" title="Jewellery Advertisement"><img src="images/j1.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="newadvertise.php? cat=antique" title="Antique Item Advertisement"><img src="images/a1.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="newadvertise.php? cat=electronics" title="Electronics Item Advertisement"><img src="images/e1.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
    <td><a href="newadvertise.php? cat=item" title="Other Item Advertisement"><img src="images/o1.gif" height="160" width="160" style="border-radius:50%; border:solid #000000;"></a></td>
   </tr>
  </table>
		  
		  
<?php	$db[0]='house'; $db[1]='vehicle'; $db[2]='furniture'; $db[3]='study'; $db[4]='jewellery'; $db[5]='antique'; $db[6]='electronics'; $db[7]='item';
		$count=0;
		for($k=0;$k<8;$k++)	{
        	$q=mysql_query("select * from $db[$k] where email='$e'");
		  	$r=mysql_num_rows($q);	// The Sequence Number of Rows
			if($r!=0) {
				if($count==0)	{
					$count++;	?>
<br><br><br>
<div align="center" style="font-family:Constantia; font-size:28px; color:#2a4f5e"><marquee behavior="alternate">Your uploaded advertisement</marquee></div><br>
<div style="background:#E9E9E9; outline:#000000 solid thin; padding:20px 0px 10px 0px;" align="center">
<marquee behavior="scroll" scrollamount="10" onMouseOut="start()" onMouseOver="stop()"> 
<?php			}
				for($i=0;$i<$r;$i++)  {
					$f=mysql_fetch_array($q);
					$pic=$f['picture'];
					$id=$f['id'];	?>
<a href="itembid.php? cat=<?php echo $db[$k]; ?>&id=<?php echo $id;?>"><img src="<?php echo $pic; ?>" height="150" width="200" style="border-radius:100%; border:solid #000000" title="<?php echo $db[$k]."-".$id;?>" /></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php  			}	
			}
		}	 ?>
</marquee></div>
<br><br>	    
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