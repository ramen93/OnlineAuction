<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_GET['a']))
	$message=$_GET['a'];
if(isset($_GET['b']))
	$mess=$_GET['b'];
	
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
	$q=mysql_query("select * from $cat where id=$id");
	$f=mysql_fetch_array($q);
}
else  {
	header("location:#");
}
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		Item Bidding
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title><?php echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item"; ?> Bidding</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="300">
</head>
<body>
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>
<?php	$now=mktime();	//	present timestamp
?>
  <div align="right" style="font-size:30px; font-family:Segoe UI Light; color:black;" >Remaining time for bidding : &nbsp;&nbsp; 
	<script language="javascript">
		var cd1 = new countdown('cd1');
		cd1.Div			= "clock1";
		cd1.TargetDate		= "08/15/2010 8:00 PM";
		cd1.DisplayFormat	= "%%D%% days, %%H%% hours, %%M%% minutes, %%S%% seconds until event AAA happens";
		
		var cd2			= new countdown('cd2');
		cd2.Div			= "clock2";
		cd2.TargetDate		= "02/01/2020 5:30 PM";
		cd2.DisplayFormat	= "%%D%% days, %%H%% hours, %%M%% minutes, %%S%% seconds until event BBB happens...";
	</script>
	
    </div>
	</div>
	<div align="center" style="font-size:20px; font-family:Constantia;padding-right:30px;">
	<?php if(!empty($message)) echo $message ?><label style="color:red;"><?php if(!empty($mess)) echo $mess ?></label>
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999">
	</span></div>
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px;">
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
</div>
  <div id="body">
   <div class="about">
	<table width="941" height="75" border="0" align="center">
     <tr style="font-family:Constantia; text-transform:capitalize;">
      <td height="34" style="color:#2a4f5e; font-size:30px;"><?php echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item"; if($page=='user') echo " Bidding"; elseif($page=='admin') echo "'s Data"; ?></td>
      <td width="259" align="right" style="font-size:22px;"><?php if($page=='user') { ?><a href="profile.php" style="text-decoration:none; color:black"><?php } echo $n; ?></a></td>
      <td width="65" align="right"><a href="profile.php"><?php if($page=='user') { ?><img width="50px" height="50px" src="<?php echo $pic; ?>" style="border-radius:50%;" title="Go to profile" /><?php } ?></a></td>
     </tr>
    </table><br>		

					

<div align="right" style="font-family:'Liberation Serif'; font-size:22px; font-style:italic; color:#2a4f5e; width:1000px">Advertisement ID :&nbsp;&nbsp; <span style="color:black;"><?php echo $cat.' - '.$id; ?></span></div><br>
<div align="center" style="font-family:Constantia; font-size:30px; color:#2a4f5e;">Information about the <?php echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item"; ?></div><br>

<table width="1002" border="0" align="center" style="outline:black solid thin; padding:20px 30px 30px 30px; font-family:'Liberation Serif'; font-size:22px; color:#2a4f5e; " bgcolor="#F8F8F8">


<?php if($cat=='house') { ?>
  <tr valign="top" align="center">
    <td height="46" colspan="2">Category : &nbsp;&nbsp;&nbsp;<span style="color:black"><?php echo $f[4]; ?></span></td>
  </tr>
  <tr valign="top">
    <td width="555" height="35">Number of Floors of the house : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[5]; ?> </span></td>
    <td width="450"><span style="padding-left:100px"></span>Number of Rooms : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[6]; ?> </span></td>
  </tr>
  <tr valign="top">
    <td height="35">Is Air Conditioned ? &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[7]; ?> </span></td>
    <td><span style="padding-left:100px"></span> Have any Balcony ? &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[8]; ?> </span></td>
  </tr>
  <tr valign="top">
    <td height="46">Have any Kitchen ? &nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[9]; ?> </span></td>
    <td><span style="padding-left:100px"></span>Bathroom / Toilet attached ? &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[10]; ?> </span></td>
  </tr>
  <tr valign="top">
    <td height="66" colspan="2">Water Supply Process in the house : &nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[11]; ?> </span></td>
    </tr>
  <tr valign="top">
    <td height="46" colspan="2" style="font-family:Constantia; font-size:25px; font-weight:bold">Location of the House :      </td>
    </tr>
  <tr valign="top">
    <td height="35">House Number : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[12]; ?></span></td>
    <td><span style="padding-left:50px"></span>Road / Street / Lane : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"><?php echo $f[13]; ?></span></td>
    </tr>
  <tr valign="top">
    <td height="35">Area / Landmark : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"><?php echo $f[14]; ?> </span></td>
    <td><span style="padding-left:50px"></span>City : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"><?php echo $f[15]; ?></span></td>
    </tr>
  <tr valign="top">
    <td height="35">District : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[16]; ?> </span></td>
    <td><span style="padding-left:50px"></span>PIN / ZIP Code : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"><?php echo $f[17]; ?></span></td>
    </tr>
  <tr valign="top">
    <td height="53">State : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"><?php echo $f[18]; ?> </span></td>
    <td><span style="padding-left:50px"></span>Country : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[19]; ?> </span></td>
    </tr>
  <tr valign="top">
    <td height="46" colspan="2" style="font-family:Constantia; font-size:25px; font-weight:bold">Communication Facility : </td>
    </tr>
  <tr valign="top">
    <td height="35">Nearest Bustand : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[20]; ?> </span></td>
    <td>Nearest Railway Station : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[21]; ?></span></td>
    </tr>
  <tr valign="top">
    <td height="35">Nearest Hospital : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[22]; ?></span></td>
    <td>Nearest Fire Brigade Office: &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[23]; ?></span></td>
    </tr>
  <tr valign="top">
    <td height="35">Nearest Police Station : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[24]; ?></span></td>
    <td>Nearest Market : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[25]; ?></span></td>
    </tr>
  <tr valign="top">
    <td height="46">Nearest School : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[26]; ?></span></td>
    <td>Nearest College : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[27]; ?></span></td>
    </tr>
  <tr align="center" valign="top">
    <td height="46" colspan="2">Environment of the house : &nbsp;&nbsp;&nbsp; <span style="color:black"><?php echo $f[28]; ?></span></td>
    </tr>
<?php	}



		elseif($cat=='vehicle')	{	?>
	<tr valign="top">
    <td height="46">Wheeler Category : &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php echo $f[4]; ?></span></td>
    <td><span style="padding-left:200px"></span>Type of Vehicle : &nbsp;&nbsp;&nbsp; <span style="color:black;"><?php echo $f[5]; ?></span></td>
    </tr>
<?php	if($f[6]!='No Engine Based')	{	?>
	<tr valign="top">
	  <td height="46">Engine Category : &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php echo $f[6]; ?></span></td>
	  <td><span style="padding-left:200px"></span>Engine Capacity : &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php echo $f[7]; ?> CC</span></td>
	  </tr>
<?php	}	?>
	<tr valign="top">
	  <td height="46">Number of Sit (with driving sit) : &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php echo $f[8]; ?></span></td>
	  <td><span style="padding-left:200px"></span>Air Conditioned ? &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php echo $f[9]; ?> </span></td>
	  </tr>
	<tr valign="top">
	  <td height="46"> Company of the Vehicle : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php echo $f[10]; ?></span></td>
	  <td><span style="padding-left:200px"></span>Model of the Vehicle : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php echo $f[11]; ?></span></td>
	  </tr>
<?php	}	



		elseif($cat=='furniture')	{	?>
	<tr valign="top">
    <td height="46">Furniture Name/Type : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php echo $f[4]; ?></span></td>
    <td><span style="padding-left:250px"></span>Is it Antique ? &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php echo $f[5]; ?> </span> </td>
    </tr>
	<tr valign="top">
	  <td height="46">Is it Branded ? &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php echo $f[6]; ?></span></td>
	  <td><span style="padding-left:250px"></span><?php if($f[6]=='Yes') {	?> Brand Name : <?php } ?> &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php if($f[6]=='Yes') echo $f[7]; ?> </span> </td>
	  </tr>
<?php 		if($f[8]!='Other')	{	?>
	<tr valign="top">
	  <td height="46">It is made by : &nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php echo $f[8]; ?></span></td>
	  <td>&nbsp;</td>
	  </tr>
<?php		}	
		}	



		elseif($cat=='study')	{	?>
	<tr valign="top">
	  <td height="46">Item Category : &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php  echo $f[4];  ?> </span></td>
	  <td><span style="padding-left:100px"></span>Is it Antique ? &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php  echo $f[5];  ?> </span> </td>
	  </tr>
	<tr valign="top">
	  <td height="46"> <?php if($f[4]=='Book') echo "Publisher"; else echo "Brand"; ?> Name : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php  echo $f[6];  ?> </span>  </td>
	  <td><span style="padding-left:100px"></span><?php if($f[4]=='Book') { ?> Author Name : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php  echo $f[7];  ?> </span> <?php } ?>  </td>
	  </tr>
<?php	}



		elseif($cat=='jewellery')	{	?>
	<tr valign="top">
	  <td height="46">Jewellery Name/Type : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php  echo $f[4];  ?> </span></td>
	  <td><span style="padding-left:230px"></span>Is it Antique ? &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php  echo $f[5];  ?> </span> </td>
	  </tr>
	<tr valign="top">
	  <td height="46"> Brand Name : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php  echo $f[6];  ?> </span>  </td>
	  <td><span style="padding-left:230px"></span><?php if($f[7]!='Other') { ?> Material of Jewellery : &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php echo $f[7]; ?> </span> <?php } ?>  </td>
	  </tr>
<?php	}
	  


		elseif($cat=='antique')	{	?>
	<tr valign="top">
	  <td height="46">Item Name/Type : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php  echo $f[4];  ?> </span></td>
	  <td><span style="padding-left:270px"></span>User / Owner : &nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php  echo $f[5];  ?> </span> </td>
	  </tr>
	<tr valign="top">
	  <td height="46"> Is it branded ? &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php  echo $f[6];  ?> </span>  </td>
	  <td><span style="padding-left:270px"></span><?php if($f[6]!='No') { ?> Brand Name : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php  echo $f[7];  ?> </span> <?php } ?>  </td>
	  </tr>
<?php	}



		elseif($cat=='electronics')	{	?>
	<tr valign="top">
	  <td height="46">Item Name/Type : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php  echo $f[4];  ?> </span></td>
	  <td><span style="padding-left:200px"></span>Purpose : &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php  echo $f[5];  ?> </span> </td>
	  </tr>
	<tr valign="top">
	  <td height="46"> Working on <span style="color:black;"> &nbsp; <?php  echo $f[6];  ?> </span> &nbsp; volt. </td>
	  <td><span style="padding-left:200px"></span> AC/DC Category : &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php echo $f[7]; ?> </span> </td>
	  </tr>
<?php	}



		elseif($cat=='item')	{	?>
	<tr valign="top">
	  <td height="46">Item Name/Type : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php  echo $f[4];  ?> </span></td>
	  <td><span style="padding-left:250px"></span> Purpose : &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php  echo $f[5];  ?> </span> </td>
	  </tr>
	<tr valign="top">
	  <td height="46"> Is it branded ? &nbsp;&nbsp;&nbsp; <span style="color:black;"> <?php  echo $f[6];  ?> </span>  </td>
	  <td><span style="padding-left:250px"></span> <?php if($f[6]!='No') { ?> Brand Name : &nbsp;&nbsp;&nbsp; <span style="color:black; text-transform:capitalize"> <?php  echo $f[7];  ?> </span> <?php } ?>  </td>
	  </tr>
<?php	}	?>

	  
	<tr valign="top">
	  <td height="46" colspan="2">Age of the <?php echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item"; ?> : &nbsp;&nbsp;&nbsp; <span style="color:black">
      <?php echo $f['year']; ?> years &nbsp;&nbsp; <?php echo $f['month']; ?> months </td>
    </tr>
<?php	if(!empty($f['something'])) {	?>
  <tr valign="top">
    <td colspan="2" style="color:black; font-style:italic; outline:#000000 dashed thin; padding:10px 10px 10px 10px" align="center"><?php echo $f['something']; ?></td>
  </tr>
<?php	}	?>  
  </table>
 
<br>
<br>
<?php if($page=='user') {  ?>
<form action="itembid_code.php? cat=<?php echo $cat; ?>& id=<?php echo $id; ?>" method="post" enctype="multipart/form-data"> 
<?php }  elseif($page=='admin')  {  ?>
<form action="newadvertise.php? cat=<?php echo $cat; ?>& id=<?php echo $id; ?>" method="post" enctype="multipart/form-data"> 
<?php }  ?> 
  <table width="1001" border="0" align="center" style="outline:black dashed thin; padding:30px 20px 10px 0px; font-family:'Liberation Serif'; font-size:22px; color:#333366;" bgcolor="#E3E4FA">
  <tr valign="top">
    <td width="414" height="42" rowspan="5" align="center"><img src="<?php echo $f['picture']; ?>" height="250" width="350" style="border-radius:6%; border:solid #000000"/></td>
    <td width="225" height="45">Name of the Owner :</td>
    <td width="348"><a href="<?php if($page=='user') echo "profile.php? pemail=".$f[2]; else echo "userdata.php?uemail=".$f[2]; ?>" style="text-decoration:none; text-transform:capitalize; color:black"><?php if($e==$f[2]) echo "You"; else echo $f[3]; ?></a></td>
  </tr>
  <tr valign="top">
    <td height="45">Last date of Bidding : </td>
    <td width="348" style="color:black;"><?php echo date('d F , Y',$f['ts']) ?> &nbsp; (11:59:59 PM)</td>
  </tr>
  <tr valign="top">
    <td height="45">Higest Bidder Name : </td>
    <td width="348" style="color:black;"><?php if($f['bid_price']==0) echo "No One"; else { ?><a href="<?php if($page=='user') echo "profile.php? pemail=".$f['bidder_email']; else echo "userdata.php?uemail=".$f['bidder_email']; ?>" style="text-decoration:none; text-transform:capitalize; color:black"><?php echo $f['bidder_name']; ?></a><?php } ?> </td>
  </tr>
  <tr valign="top">
    <td height="45" colspan="2"><?php if($f['bid_price']==0) echo "Expected Minimum Price (Rs.) :"; else echo "Last Bidding Price (Rs.) :"; ?> &nbsp;&nbsp;&nbsp;
	<span style="color:black;"> <?php if($f['bid_price']==0) echo $f['price']; else	 echo $f['bid_price'];  ?></span> </td>
    </tr>
  <tr valign="top">
<?php
	  if($page=='user') {  ?>
    <td height="27" colspan="2" style="color:green;" align="center">
<?php if($now<$f['ts']) { ?>Start to bid (in rupee) :  &nbsp;&nbsp;&nbsp;
	  <input type="text" name="bidding_price" title="Enter in digit" style="font-family:'Liberation Serif'; font-size:18px;" placeholder="Enter your bidding price" minlength="0" maxlength="20" required>
	  &nbsp;&nbsp;&nbsp;&nbsp;<input id="round" input type="submit" value="BID" style="font-family:Constantia; font-size:18px; width:80px">
<style type="text/css"> 

input#round{
width:100px; /*same as the height*/
height:40px; /*same as the width*/
background-color:purple;
border:0px purple ; /*same colour as the background*/
color:#ffff00;
font-size:	1.6em;
font-style: italic;

/*set the border-radius at half the size of the width and height*/
-webkit-border-radius: 20px;
-moz-border-radius: 20px;
border-radius: 20px;
/*give the button a small drop shadow*/
-webkit-box-shadow: 0 0 0px rgba(0,0,0, );
-moz-box-shadow: 0 0 0px rgba(0,0,0, );
box-shadow: 0px 0px 0px rgba(0,0,0, );
}
/***NOW STYLE THE BUTTON'S HOVER STATE***/
input#round:hover{
background:cyan;
border:0px solid;
font-style: italic;
/*reduce the size of the shadow to give a pushed effect*/
-webkit-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
-moz-box-shadow: 0px 0px 5px rgba(0,0,0, .75);
box-shadow: 0px 0px 5px rgba(0,0,0, .75);
}
            
</style>
<?php	}	else	{	?> <span style="font-size:24px; color:red; font-weight:bold">Sold Out !</span> <?php	}	?>  </td>
<?php }  elseif($page=='admin')  {  ?>
	<td><a href="delconfirm.php? cat=<?php echo $cat; ?>& id=<?php echo $id; ?>&k=1" style="font-family:Constantia; font-size:22px; text-decoration:none; color:red">Delete Advertisemnt</a></td>
    <td height="27" align="right" style="padding-right:30px"><?php if($now<$f['ts']) { ?>
	<input type="submit" value="Edit Advertisement" style="font-family:Constantia; font-size:20px; width:200px">
<?php	}	else	{	?> <span style="font-size:24px; color:red; font-weight:bold">Sold Out !</span> <?php	}	?>  </td>
<?php	 }   ?>	  
    </tr>
  <tr valign="top">
    <td height="34" align="center"><a href="<?php echo $f['picture']; ?>" download="<?php echo $cat."-".$f[0]." (Owner - ".$f[3].")"; ?>"><img src="images/download.jpg"></a></td>
    <td height="34" colspan="2" align="right" style="padding-right:30px">
<?php 	$q=mysql_query("select * from bidders where category='$cat' and advertisement_id='$id'");
		$f=mysql_fetch_array($q);	// The Sequence Number of Rows
		if($f)	{	?>	
	<marquee behavior="alternate" scrolldelay="150" onMouseOut="start()" onMouseOver="stop()"><a href="bidderlist.php? cat=<?php echo $cat; ?>& id=<?php echo $id; ?>" style="font-family:Constantia; font-size:18px; text-decoration:none; color:#666666">See the list of bidders</a></marquee>
<?php	}	?>	</td>
    </tr>
</table>	
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