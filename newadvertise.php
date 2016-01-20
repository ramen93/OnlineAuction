<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_GET['b']))
$message=$_GET['b'];

if(isset($_GET['cat'])) {		//	auction items category
	$cat=$_GET['cat'];
}
else  {
	header("location:#");
}

if(isset($_SESSION['email']))				//	if there is any logged in email-id in session 'email'
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

$q=mysql_query("select * from $cat");
$f=mysql_fetch_array($q);
$id=$f['n']+1;

if(isset($_GET['id'])) {	//	for modifying advertisement from admin side
	$id=$_GET['id'];
	$q=mysql_query("select * from $cat where id='$id'");
	$f=mysql_fetch_array($q);	
}
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		New Advertisement
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title><?php  echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item"; ?> Adverisement</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="600">
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body <?php if($page=='user') { ?> onLoad="frmnewadv.btnSubmit.disabled=true" <?php } ?> >
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>
<?php	if($page=='user') {  ?>		
			<ul>
				<li><a href="profile.php">My Profile</a></li>
				<li class="selected"><a href="mystore.php">New Advertise</a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="createprofile.php">Settings</a></li>
				<li><a href="logout_code.php">Log Out</a></li>
			</ul>
<?php  	}  ?>
</div>
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px; color:red"><?php if(!empty($message)) echo $message; ?>
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
  <div id="body">
   <div class="about">
	<table width="941" height="75" border="0" align="center">
     <tr style="font-family:Constantia; text-transform:capitalize;">
      <td height="34" style="color:#2a4f5e; font-size:30px;"><?php if($page=='user') echo "New "; else echo "Edit "; echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item"; ?> Advertisement</td>
      <td width="259" align="right" style="font-size:22px;"><?php if($page=='user') { ?><a href="profile.php" style="text-decoration:none; color:black"><?php } echo $n; ?></a></td>
      <td width="65" align="right"><a href="profile.php"><?php if(isset($_SESSION['email']) && $page=='user') { ?><img width="50px" height="50px" src="<?php echo $pic; ?>" style="border-radius:50%;" title="Go to profile" /><?php } ?></a></td></td>
     </tr>
    </table>
   </div>
  </div>				


  
  <div align="right" style="font-family:Andalus; font-size:20px; color:#2a4f5e">Change Category &nbsp;
   <select style="font-family:Constantia; font-size:16px;" onChange="MM_jumpMenu('parent',this,0)">
    <option <?php if($cat=='house') { ?> selected <?php } ?> value="? cat=house">House Advertisement</option>
    <option <?php if($cat=='vehicle') { ?> selected <?php } ?> value="? cat=vehicle">Vehicle Advertisement</option>
    <option <?php if($cat=='furniture') { ?> selected <?php } ?> value="? cat=furniture">Furniture Advertisement</option>
    <option <?php if($cat=='study') { ?> selected <?php } ?> value="? cat=study">Study Material Advertisement</option>
    <option <?php if($cat=='jewellery') { ?> selected <?php } ?> value="? cat=jewellery">Jewellery Advertisement</option>
    <option <?php if($cat=='antique') { ?> selected <?php } ?> value="? cat=antique">Antique Item Advertisement</option>
    <option <?php if($cat=='electronics') { ?> selected <?php } ?> value="? cat=electronics">Electronics Item Advertisement</option>
    <option <?php if($cat=='item') { ?> selected <?php } ?> value="? cat=item">Other Item Advertisement</option>
   </select> &nbsp;&nbsp;&nbsp;
</div><br><br>
					
<form name="frmnewadv" action="newadvertise_code.php? cat=<?php echo $cat; ?>& id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
<div align="right" style="font-family:'Liberation Serif'; font-size:22px; font-style:italic; color:#2a4f5e; width:1250px; height:32px">Advertisement ID :&nbsp;&nbsp; <span style="color:black;"><?php echo $cat.' - '.$id; ?></span></div>

<table width="1149" border="0" align="center" style="outline:black solid thin; padding:30px 30px 30px 30px;" bgcolor="#F5F5DC">

<?php if($cat=='house') { ?>
  <tr valign="top" align="center" height="46">
    <td colspan="2" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Category : &nbsp;&nbsp;&nbsp;<span style="color:black">
      <input name="category" type="radio" value="House" <?php if($page=='admin' && $f[4]=='House') { ?> checked <?php } ?> required>House &nbsp;&nbsp;
	  <input name="category" type="radio" value="Flat" <?php if($page=='admin' && $f[4]=='Flat') { ?> checked <?php } ?> required>Flat &nbsp;&nbsp;
	  <input name="category" type="radio" value="Building" <?php if($page=='admin' && $f[4]=='Building') { ?> checked <?php } ?> required>Building</span></td>
    </tr>
  <tr valign="top" height="35">
    <td width="693" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Number of Floors of the house : &nbsp;&nbsp;&nbsp;&nbsp;
   <select name="floor" style="font-family:'Liberation Serif'; font-size:18px;" required>
	<option selected value="">Select</option>
<?php if($page=='admin') { ?> <option selected> <?php echo $f[5]; ?> </option> <?php } ?>
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option>5</option>
	<option>6 - 10</option>
	<option>11 - 15</option>
	<option>16 - 20</option>
	<option>21 - 30</option>
	<option>31 - 40</option>
	<option>41 - 50</option>
	<option>More than 50</option>
   </select></td>
    <td width="446" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Number of Rooms : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="text" name="room" title="Enter in digit" style="font-family:'Liberation Serif'; font-size:17px" value="<?php if($page=='admin') echo $f[6]; ?>" placeholder="How many rooms are there?" maxlength="4" required></td>
  </tr>
  <tr valign="top" height="35">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Is Air Conditioned ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black">
	<input name="aircondition" type="radio" value="Yes" <?php if($page=='admin' && $f[7]=='Yes') { ?> checked <?php } ?> required>Yes &nbsp;&nbsp;&nbsp;
	<input name="aircondition" type="radio" value="No" <?php if($page=='admin' && $f[7]=='No') { ?> checked <?php } ?> required>No</span></td>
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Have any Balcony ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black">
	<input name="balcony" type="radio" value="Yes" <?php if($page=='admin' && $f[8]=='Yes') { ?> checked <?php } ?> required>Yes &nbsp;&nbsp;&nbsp;
	<input name="balcony" type="radio" value="No" <?php if($page=='admin' && $f[8]=='No') { ?> checked <?php } ?> required>No</span></td>
  </tr>
  <tr valign="top" height="46">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Have any Kitchen ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black">
	<input name="kitchen" type="radio" value="Yes" <?php if($page=='admin' && $f[9]=='Yes') { ?> checked <?php } ?> required>Yes &nbsp;&nbsp;&nbsp;
	<input name="kitchen" type="radio" value="No" <?php if($page=='admin' && $f[9]=='No') { ?> checked <?php } ?> required>No</span></td>
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Bathroom / Toilet attached ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black">
	<input name="bathroom" type="radio" value="Yes" <?php if($page=='admin' && $f[10]=='Yes') { ?> checked <?php } ?> required>Yes &nbsp;&nbsp;&nbsp;
	<input name="bathroom" type="radio" value="No" <?php if($page=='admin' && $f[10]=='No') { ?> checked <?php } ?> required>No</span></td>
  </tr>
  <tr valign="top">
    <td colspan="2" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">What about the Water Supply Process in the house ? &nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="water" style="font-family:Constantia; font-size:20px; height:51px; width:570px" placeholder="Write about the water supply process of the house within 200 charecters" maxlength="200" required><?php if($page=='admin') echo $f[11]; ?></textarea></td>
    </tr>
  <tr valign="top" height="46">
    <td colspan="2" style="font-family:Constantia; font-size:25px; color:#2a4f5e; font-weight:bold">Location of the House :      </td>
    </tr>
  <tr valign="top" height="35">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">House Number : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="hno" style="font-family:'Liberation Serif'; font-size:17px" placeholder="What is house number?" value="<?php if($page=='admin') echo $f[12]; ?>" maxlength="20" required></td>
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Road / Street / Lane : &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="road" style="font-family:'Liberation Serif'; text-transform:capitalize; font-size:17px" value="<?php if($page=='admin') echo $f[13]; ?>" placeholder="What is nearest road/street?" maxlength="20" required></td>
    </tr>
  <tr valign="top" height="35">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Area / Landmark : &nbsp;&nbsp;&nbsp;
      <input type="text" name="area" style="font-family:'Liberation Serif'; font-size:17px" placeholder="What is area / landmark?" value="<?php if($page=='admin') echo $f[14]; ?>" maxlength="30" required></td>
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">City : <span style="padding-right:163px"></span>
      <input type="text" name="city" style="font-family:'Liberation Serif'; text-transform:capitalize;  font-size:17px" placeholder="In which city it belongs?" value="<?php if($page=='admin') echo $f[15]; ?>" maxlength="20" required></td>
    </tr>
  <tr valign="top" height="35">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">District : <span style="padding-right:103px"></span>
      <input type="text" name="district" style="font-family:'Liberation Serif'; text-transform:capitalize; font-size:17px;" placeholder="In which district it belongs?" value="<?php if($page=='admin') echo $f[16]; ?>" maxlength="10" required></td>
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">PIN / ZIP Code : <span style="padding-right:68px"></span>
      <input type="text" name="pin" style="font-family:'Liberation Serif'; font-size:17px" placeholder="Give PIN/ZIP of the location" value="<?php if($page=='admin') echo $f[17]; ?>" maxlength="10" required></td>
    </tr>
  <tr valign="top" height="53">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">State : <span style="padding-right:125px"></span>
      <input type="text" name="state" style="font-family:'Liberation Serif'; text-transform:capitalize;  font-size:17px" placeholder="In which state it belongs?" value="<?php if($page=='admin') echo $f[18]; ?>" maxlength="50" required></td>
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Country : <span style="padding-right:84px"></span>
	  <select name="country" style="font-family:'Liberation Serif'; font-size:18px" required >
	    <option selected value="">Select country..</option>
  <?php if($page=='admin') { ?> <option selected> <?php echo $f[19]; ?> </option> <?php } ?>
	    <option>Afghanistan</option>
	    <option>Albania</option>
	    <option>Algeria</option>
	    <option>America Samoa</option>
	    <option>Andorra</option>
	    <option>Angola</option>
	    <option>Anguilla</option>
	    <option>Antigua & Barbuda</option>
	    <option>Argentina</option>
	    <option>Armenia</option>
	    <option>Aruba</option>
	    <option>Australia</option>
	    <option>Austria</option>
	    <option>Azerbaijan</option>
	    <option>Bahamas</option>
	    <option>Bahrain</option>
	    <option>Bangladesh</option>
	    <option>Barbados</option>
	    <option>Belarus</option>
	    <option>Belgium</option>
	    <option>Belize</option>
	    <option>Benin</option>
	    <option>Bermuda</option>
	    <option>Bhutan</option>
	    <option>Bolivia</option>
	    <option>Bonaire</option>
	    <option>Bosnia &amp; Herzegovina</option>
	    <option>Botswana</option>
	    <option>Brazil</option>
	    <option>British Indian Ocean Ter</option>
	    <option>Brunei</option>
	    <option>Bulgaria</option>
	    <option>Burkina Faso</option>
	    <option>Burundi</option>
	    <option>Cambodia</option>
	    <option>Cameroon</option>
	    <option>Canada</option>
	    <option>Canary Islands</option>
	    <option>Cape Verde</option>
	    <option>Cayman Islands</option>
	    <option>Central African Republic</option>
	    <option>Chad</option>
	    <option>Channel Islands</option>
	    <option>Chile</option>
	    <option>China</option>
	    <option>Christmas Island</option>
	    <option>Cocos Island</option>
	    <option>Colombia</option>
	    <option>Comoros</option>
	    <option>Congo</option>
	    <option>Cook Islands</option>
	    <option>Costa Rica</option>
	    <option>Cote D'Ivoire</option>
	    <option>Croatia</option>
	    <option>Cuba</option>
	    <option>Curacao</option>
	    <option>Cyprus</option>
	    <option>Czech Republic</option>
	    <option>Denmark</option>
	    <option>Djibouti</option>
	    <option>Dominica</option>
	    <option>Dominican Republic</option>
	    <option>East Timor</option>
	    <option>Ecuador</option>
	    <option>Egypt</option>
	    <option>El Salvador</option>
	    <option>Equatorial Guinea</option>
	    <option>Eritrea</option>
	    <option>Estonia</option>
	    <option>Ethiopia</option>
	    <option>Falkland Islands</option>
	    <option>Faroe Islands</option>
	    <option>Fiji</option>
	    <option>Finland</option>
	    <option>France</option>
	    <option>French Guiana</option>
	    <option>French Polynesia</option>
	    <option>French Southern Ter</option>
	    <option>Gabon</option>
	    <option>Gambia</option>
	    <option>Georgia</option>
	    <option>Germany</option>
	    <option>Ghana</option>
	    <option>Gibraltar</option>
	    <option>Great Britain</option>
	    <option>Greece</option>
	    <option>Greenland</option>
	    <option>Grenada</option>
	    <option>Guadeloupe</option>
	    <option>Guam</option>
	    <option>Guatemala</option>
	    <option>Guinea</option>
	    <option>Guyana</option>
	    <option>Haiti</option>
	    <option>Hawaii</option>
	    <option>Honduras</option>
	    <option>Hong Kong</option>
	    <option>Hungary</option>
	    <option>Iceland</option>
	    <option>India</option>
	    <option>Indonesia</option>
	    <option>Iran</option>
	    <option>Iraq</option>
	    <option>Ireland</option>
	    <option>Isle of Man</option>
	    <option>Israel</option>
	    <option>Italy</option>
	    <option>Jamaica</option>
	    <option>Japan</option>
	    <option>Jordan</option>
	    <option>Kazakhstan</option>
	    <option>Kenya</option>
	    <option>Kiribati</option>
	    <option>Korea North</option>
	    <option>Korea South</option>
	    <option>Kuwait</option>
	    <option>Kyrgyzstan</option>
	    <option>Laos</option>
	    <option>Latvia</option>
	    <option>Lebanon</option>
	    <option>Lesotho</option>
	    <option>Liberia</option>
	    <option>Libya</option>
	    <option>Liechtenstein</option>
	    <option>Lithuania</option>
	    <option>Luxembourg</option>
	    <option>Macau</option>
	    <option>Macedonia</option>
	    <option>Madagascar</option>
	    <option>Malaysia</option>
	    <option>Malawi</option>
	    <option>Maldives</option>
	    <option>Mali</option>
	    <option>Malta</option>
	    <option>Marshall Islands</option>
	    <option>Martinique</option>
	    <option>Mauritania</option>
	    <option>Mauritius</option>
	    <option>Mayotte</option>
	    <option>Mexico</option>
	    <option>Midway Islands</option>
	    <option>Moldova</option>
	    <option>Monaco</option>
	    <option>Mongolia</option>
	    <option>Montserrat</option>
	    <option>Morocco</option>
	    <option>Mozambique</option>
	    <option>Myanmar</option>
	    <option>Nambia</option>
	    <option>Nauru</option>
	    <option>Nepal</option>
	    <option>Netherland Antilles</option>
	    <option>Netherlands (Holland, Europe)</option>
	    <option>Nevis</option>
	    <option>New Caledonia</option>
	    <option>New Zealand</option>
	    <option>Nicaragua</option>
	    <option>Niger</option>
	    <option>Nigeria</option>
	    <option>Niue</option>
	    <option>Norfolk Island</option>
	    <option>Norway</option>
	    <option>Oman</option>
	    <option>Pakistan</option>
	    <option>Palau Island</option>
	    <option>Palestine</option>
	    <option>Panama</option>
	    <option>Papua New Guinea</option>
	    <option>Paraguay</option>
	    <option>Peru</option>
	    <option>Philippines</option>
	    <option>Pitcairn Island</option>
	    <option>Poland</option>
	    <option>Portugal</option>
	    <option>Puerto Rico</option>
	    <option>Qatar</option>
	    <option>Republic of Montenegro</option>
	    <option>Republic of Serbia</option>
	    <option>Reunion</option>
	    <option>Romania</option>
	    <option>Russia</option>
	    <option>Rwanda</option>
	    <option>St Barthelemy</option>
	    <option>St Eustatius</option>
	    <option>St Helena</option>
	    <option>St Kitts-Nevis</option>
	    <option>St Lucia</option>
	    <option>St Maarten</option>
	    <option>St Pierre &amp; Miquelon</option>
	    <option>St Vincent &amp; Grenadines</option>
	    <option>Saipan</option>
	    <option>Samoa</option>
	    <option>Samoa American</option>
	    <option>San Marino</option>
	    <option>Sao Tome &amp; Principe</option>
	    <option>Saudi Arabia</option>
	    <option>Senegal</option>
	    <option>Seychelles</option>
	    <option>Sierra Leone</option>
	    <option>Singapore</option>
	    <option>Slovakia</option>
	    <option>Slovenia</option>
	    <option>Solomon Islands</option>
	    <option>Somalia</option>
	    <option>South Africa</option>
	    <option>Spain</option>
	    <option>Sri Lanka</option>
	    <option>Sudan</option>
	    <option>Suriname</option>
	    <option>Swaziland</option>
	    <option>Sweden</option>
	    <option>Switzerland</option>
	    <option>Syria</option>
	    <option>Tahiti</option>
	    <option>Taiwan</option>
	    <option>Tajikistan</option>
	    <option>Tanzania</option>
	    <option>Thailand</option>
	    <option>Togo</option>
	    <option>Tokelau</option>
	    <option>Tonga</option>
	    <option>Trinidad &amp; Tobago</option>
	    <option>Tunisia</option>
	    <option>Turkey</option>
	    <option>Turkmenistan</option>
	    <option>Turks &amp; Caicos Is</option>
	    <option>Tuvalu</option>
	    <option>Uganda</option>
	    <option>Ukraine</option>
	    <option>United Arab Emirates</option>
	    <option>United Kingdom</option>
	    <option>United States of America</option>
	    <option>Uruguay</option>
	    <option>Uzbekistan</option>
	    <option>Vanuatu</option>
	    <option>Vatican City State</option>
	    <option>Venezuela</option>
	    <option>Vietnam</option>
	    <option>Virgin Islands (Brit)</option>
	    <option>Virgin Islands (USA)</option>
	    <option>Wake Island</option>
	    <option>Wallis &amp; Futana Is</option>
	    <option>Yemen</option>
	    <option>Zaire</option>
	    <option>Zambia</option>
	    <option>Zimbabwe</option>
        </select></td>
    </tr>
  <tr valign="top" height="46">
    <td colspan="2" style="font-family:Constantia; font-size:25px; color:#2a4f5e; font-weight:bold">Communication Facility : </td>
    </tr>
  <tr valign="top" height="35">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Nearest Bustand : <span style="padding-right:73px"></span>
      <select name="busstand" style="font-family:'Liberation Serif'; font-size:18px;" required>
	      <option value="">Select distance</option>
	      <option <?php if($page=='admin' && $f[20]=='within 1 km') { ?> selected <?php }	?>>within 1 km</option>
	      <option <?php if($page=='admin' && $f[20]=='more than 1 km') { ?> selected <?php }	?> >more than 1 km</option>
      </select></td>
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Nearest Railway Station :  <span style="padding-right:48px"></span>
      <select name="railway" style="font-family:'Liberation Serif'; font-size:18px;" required>
	      <option value="">Select distance</option>
	      <option <?php if($page=='admin' && $f[21]=='within 1 km') { ?> selected <?php }	?> >within 1 km</option>
	   	  <option <?php if($page=='admin' && $f[21]=='more than 1 km') { ?> selected <?php }	?> >more than 1 km</option>
      </select></td>
    </tr>
  <tr valign="top" height="35">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Nearest Hospital : <span style="padding-right:70px"></span>
      <select name="hospital" style="font-family:'Liberation Serif'; font-size:18px;" required>
	      <option value="">Select distance</option>
	      <option <?php if($page=='admin' && $f[22]=='within 1 km') { ?> selected <?php }	?>>within 1 km</option>
	      <option <?php if($page=='admin' && $f[22]=='more than 1 km') { ?> selected <?php }	?> >more than 1 km</option>
      </select></td>
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Nearest Fire Brigade Office : &nbsp;&nbsp;&nbsp;
      <select name="firebrigade" style="font-family:'Liberation Serif'; font-size:18px;" required>
	      <option value="">Select distance</option>
	      <option <?php if($page=='admin' && $f[23]=='within 1 km') { ?> selected <?php }	?>>within 1 km</option>
	      <option <?php if($page=='admin' && $f[23]=='more than 1 km') { ?> selected <?php }	?> >more than 1 km</option>
      </select>    </td>
    </tr>
  <tr valign="top" height="35">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Nearest Police Station : &nbsp;&nbsp;&nbsp;&nbsp;
      <select name="police" style="font-family:'Liberation Serif'; font-size:18px;" required>
	      <option value="">Select distance</option>
	      <option <?php if($page=='admin' && $f[24]=='within 1 km') { ?> selected <?php }	?>>within 1 km</option>
	      <option <?php if($page=='admin' && $f[24]=='more than 1 km') { ?> selected <?php }	?> >more than 1 km</option>
      </select>    </td>
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Nearest Market : <span style="padding-right:120px"></span>
      <select name="market" style="font-family:'Liberation Serif'; font-size:18px;" required>
	      <option value="">Select distance</option>
	      <option <?php if($page=='admin' && $f[25]=='within 1 km') { ?> selected <?php }	?>>within 1 km</option>
	      <option <?php if($page=='admin' && $f[25]=='more than 1 km') { ?> selected <?php }	?> >more than 1 km</option>
	  </select>    </td>
    </tr>
  <tr valign="top" height="46">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Nearest School : <span style="padding-right:85px"></span>
      <select name="school" style="font-family:'Liberation Serif'; font-size:18px;" required>
	      <option value="">Select distance</option>
	      <option <?php if($page=='admin' && $f[26]=='within 1 km') { ?> selected <?php }	?>>within 1 km</option>
	      <option <?php if($page=='admin' && $f[26]=='more than 1 km') { ?> selected <?php }	?> >more than 1 km</option>
      </select>    </td>
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Nearest College : <span style="padding-right:118px"></span>
      <select name="college" style="font-family:'Liberation Serif'; font-size:18px;" required>
	      <option value="">Select distance</option>
	      <option <?php if($page=='admin' && $f[27]=='within 1 km') { ?> selected <?php }	?>>within 1 km</option>
	      <option <?php if($page=='admin' && $f[27]=='more than 1 km') { ?> selected <?php }	?> >more than 1 km</option>
      </select>    </td>
    </tr>
  <tr align="center" valign="top">
    <td height="46" colspan="2" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Environment of the house : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black">
      <input name="environment" type="radio" value="Noisy" <?php if($page=='admin' && $f[28]=='Noisy') { ?> checked <?php } ?> required>Noisy &nbsp;&nbsp;
	  <input name="environment" type="radio" value="Silent" <?php if($page=='admin' && $f[28]=='Silent') { ?> checked <?php } ?> required>Silent</span></td>
    </tr>
<?php	}




		elseif($cat=='vehicle')	{	?>
	<tr valign="top" height="46">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Wheeler Category : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <select name="wheeler" style="font-family:'Liberation Serif'; font-size:18px;" required>
    <option value="">Select</option>
<?php if($page=='admin') { ?> <option selected> <?php echo $f[4]; ?> </option> <?php } ?>
    <option>2 wheeler</option>
    <option>3 wheeler</option>
    <option>4 wheeler</option>
    <option>6 wheeler</option>
    <option>10 wheeler</option>
    <option>Other</option>
   </select></td>
    <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e; padding-right:116px">Type of Vehicle : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <select name="type" style="font-family:'Liberation Serif'; font-size:18px;" required>
    <option value="">Select</option>
  <?php if($page=='admin') { ?> <option selected> <?php echo $f[5]; ?> </option> <?php } ?>
    <option>Bicycle</option>
    <option>Motor Bike</option>
    <option>Rickshaw</option>
    <option>Auto-rickshaw</option>
    <option>Car</option>
    <option>Van</option>
    <option>Bus</option>
    <option>Mini Truck</option>
    <option>Lorry</option>
    <option>Tractor</option>
    <option>Road Roller</option>
    <option>Crane</option>
    <option>Bulldozer</option>
    <option>Other</option>
   </select></td>
    </tr>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Engine Category : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <select name="engine" style="font-family:'Liberation Serif'; font-size:18px;" required>
<?php if($page=='admin') { ?> <option selected> <?php echo $f[6]; ?> </option> <?php } ?>
	<option value="">Select</option>
	<option onClick="capacity.disabled=false">Diesel Engine</option>
	<option onClick="capacity.disabled=false">Petrol Engine</option>
	<option onClick="capacity.disabled=false">CNG Engine</option>
	<option onClick="capacity.disabled=false">Battery Engine</option>
	<option onClick="capacity.disabled=false">Solar Engine</option>
	<option onClick="capacity.disabled=true">No Engine Based</option>
   </select></td>
	  <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e; padding-right:124px">Engine Capacity :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <input type="text" name="capacity" title="Enter in digit" style="font-family:'Liberation Serif'; font-size:18px; width:80px" value="<?php if($page=='admin') echo $f[7]; ?>" placeholder="Write" maxlength="6"> &nbsp; CC</td>
    </tr>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Number of Sit (with driving sit) : &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="sit" title="Enter in digit" style="font-family:'Liberation Serif'; font-size:18px; width:80px" value="<?php if($page=='admin') echo $f[8]; ?>" placeholder="Write" maxlength="2" required></td>
	  <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e; padding-right:122px">Air Conditioned ? &nbsp;&nbsp;&nbsp;&nbsp; 
        <input name="aircondition" type="radio" value="Yes" <?php if($page=='admin' && $f[9]=='Yes') { ?> checked <?php } ?> required> Yes &nbsp;&nbsp;&nbsp;
	    <input name="aircondition" type="radio" value="No" <?php if($page=='admin' && $f[9]=='No') { ?> checked <?php } ?> required>No</td>
    </tr>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;"> Company of the Vehicle :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <input type="text" name="company" style="font-family:'Liberation Serif'; text-transform:capitalize; font-size:18px;" placeholder="Which company of it is?" value="<?php if($page=='admin') echo $f[10]; ?>" maxlength="50" required></td>
	  <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Model of the Vehicle :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <input type="text" name="model" style="font-family:'Liberation Serif'; text-transform:capitalize; font-size:18px;" placeholder="Which model of it is?" value="<?php if($page=='admin') echo $f[11]; ?>" maxlength="50" required></td>
    </tr>
<?php	}	




		elseif($cat=='furniture')	{	?>
	<tr valign="top" height="46">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Furniture Name/Type : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="type" style="font-family:Constantia; text-transform:capitalize;  font-size:18px;" placeholder="What furniture is it?" value="<?php if($page=='admin') echo $f[4]; ?>" maxlength="20" required></td>
    <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e; padding-right:80px">Is it Antique ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	  <input name="antique" type="radio" value="Yes" <?php if($page=='admin' && $f[5]=='Yes') { ?> checked <?php } ?> required>Yes &nbsp;&nbsp;&nbsp; 
	  <input name="antique" type="radio" value="No" <?php if($page=='admin' && $f[5]=='No') { ?> checked <?php } ?> required>No</td>
    </tr>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Is it Branded ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black;">
	  <input name="branded" type="radio" value="Yes" <?php if($page=='admin' && $f[6]=='Yes') { ?> checked <?php } ?> onClick="brand.disabled=false" required>Yes &nbsp;&nbsp;&nbsp; 
	  <input name="branded" type="radio" value="No" <?php if($page=='admin' && $f[6]=='No') { ?> checked <?php } ?> onClick="brand.disabled=true" required>No</span></td>
	  <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Brand Name :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="brand" style="font-family:Constantia; text-transform:capitalize; font-size:18px;" placeholder="Which brand of it is?" value="<?php if($page=='admin') echo $f[7]; ?>" maxlength="50"></td>
    </tr>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">It is made by : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <select name="madeby" style="font-family:'Liberation Serif'; font-size:18px;" required>
    <option value="">Select</option>
<?php if($page=='admin') { ?> <option selected> <?php echo $f[8]; ?> </option> <?php } ?>
    <option>Wood</option>
    <option>Metal</option>
    <option>Fiber</option>
    <option>Plastic</option>
    <option>Clay</option>
    <option>Other</option>
   </select></td>
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">&nbsp;</td>
    </tr>
<?php	}




		elseif($cat=='study')	{	?>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Item Category : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <select name="type" style="font-family:'Liberation Serif'; font-size:18px;" required>
   <option value="">Select</option>
<?php if($page=='admin') { ?> <option selected> <?php echo $f[4]; ?> </option>	<?php } ?>
   <option>Book</option>
   <option>Notebook</option>
   <option>Theory Paper</option>
   <option>News Paper</option>
   <option>Map</option>
   <option>Chart</option>
   <option>Pen</option>
   <option>Ink</option>
   <option>Box</option>
   <option>Globe</option>
   <option>Other</option>
  </select></td>
      <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e; padding-right:240px">Is it Antique ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <input name="antique" type="radio" value="Yes" <?php if($page=='admin' && $f[5]=='Yes') { ?> checked <?php } ?>  required>Yes &nbsp;&nbsp;&nbsp;
        <input name="antique" type="radio" value="No" <?php if($page=='admin' && $f[5]=='No') { ?> checked <?php } ?>  required>No</td>
    </tr>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Brand/Publisher Name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="text" name="brand" style="font-family:Constantia; text-transform:capitalize;  font-size:18px;" placeholder="Write brand/publisher name" value="<?php if($page=='admin') echo $f[6]; ?>" size="25" maxlength="50" required></td>
	  <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Author name (only for book) : &nbsp;&nbsp;&nbsp;
      <input type="text" name="author" style="font-family:Constantia; text-transform:capitalize; font-size:18px;" placeholder="Who is author of the book?" value="<?php if($page=='admin') echo $f[7]; ?>" size="25" maxlength="100"></td>
    </tr>
<?php	}




		elseif($cat=='jewellery')	{	?>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Jewellary Name/Type : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="text" name="type" style="font-family:Constantia; text-transform:capitalize;  font-size:18px;" placeholder="What type of jewellery is it?" value="<?php if($page=='admin') echo $f[4]; ?>" size="25" maxlength="50" required></td>
	  <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e; padding-right:80px">Is it Antique ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	    <input name="antique" type="radio" value="Yes" <?php if($page=='admin' && $f[5]=='Yes') { ?> checked <?php } ?> required>Yes &nbsp;&nbsp;&nbsp;
  	    <input name="antique" type="radio" value="No" <?php if($page=='admin' && $f[5]=='No') { ?> checked <?php } ?> required>No</td>
    </tr>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Brand Name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="brand" style="font-family:Constantia; text-transform:capitalize;  font-size:18px;" placeholder="In which brand of it is?" value="<?php if($page=='admin') echo $f[6]; ?>" size="25" maxlength="50" required></td>
	  <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Material of Jewellery : &nbsp;&nbsp;&nbsp; <span style="font-family:Constantia; font-size:20px; color:#2a4f5e;">
  <select name="material" style="font-family:'Liberation Serif'; font-size:18px;" required>
   <option value="">Select</option>
<?php if($page=='admin') { ?>   <option selected> <?php echo $f[7]; ?> </option> <?php } ?>
   <option>Bronze</option>
   <option>Gold</option>
   <option>Pearl</option>
   <option>Diamond</option>
   <option>Platinum</option>
   <option>Precius Stone</option>
   <option>Gold & Pearl</option>
   <option>Gold & Diamond</option>
   <option>Gold & Platinum</option>
   <option>Gold & Stone</option>
   <option>Pearl & Diamond</option>
   <option>Diamond & Stone</option>
   <option>Other</option>
  </select>
	  </span></td>
    </tr>
<?php	}




		elseif($cat=='antique')	{	?>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Name of Item : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	    
	  <input type="text" name="type" style="font-family:Constantia; text-transform:capitalize;  font-size:18px;" placeholder="What item is it?" value="<?php if($page=='admin') echo $f[4]; ?>" maxlength="20" required></td>
      <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">User / Owner Name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <input type="text" name="user" style="font-family:Constantia; text-transform:capitalize; font-size:18px;" placeholder="Who is the user/owner?" value="<?php if($page=='admin') echo $f[5]; ?>" size="25" maxlength="50" required></td>
    </tr>
	<tr valign="top" height="46">
      <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Is it Branded ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black;">
      <input name="branded" type="radio" value="Yes" <?php if($page=='admin' && $f[6]=='Yes') { ?> checked <?php } ?> onClick="brand.disabled=false" required>Yes &nbsp;&nbsp;&nbsp;
      <input name="branded" type="radio" value="No" <?php if($page=='admin' && $f[6]=='No') { ?> checked <?php } ?> onClick="brand.disabled=true" required>No</span></td>
	  <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Brand Name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <input type="text" name="brand" style="font-family:Constantia; text-transform:capitalize; font-size:18px;" placeholder="Which brand of it is?" size="25" value="<?php if($page=='admin') echo $f[7]; ?>" maxlength="50"></td>
    </tr>
<?php	}




		elseif($cat=='electronics')	{	?>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Item Name/Type : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="type" style="font-family:Constantia; text-transform:capitalize; font-size:18px;" placeholder="What type of item is it?" value="<?php if($page=='admin') echo $f[4]; ?>" size="25" maxlength="50" required></td>
	  <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e;"> Purpose of the Item : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="purpose" style="font-family:Constantia; text-transform:capitalize;  font-size:18px;" placeholder="For which purpose is it used ?" value="<?php if($page=='admin') echo $f[5]; ?>" size="25" maxlength="50" required></td>
    </tr>
	<tr valign="top" height="46">
	  <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Working on &nbsp;&nbsp; 
	  <input type="text" name="volt" title="Enter in digit" style="font-family:'Liberation Serif'; font-size:18px;" value="<?php if($page=='admin') echo $f[6]; ?>" placeholder="Enter voltage amount" size="15" maxlength="10"> &nbsp;&nbsp; Volt.      </td>
	  <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e; padding-right:124px">AC / DC Category : &nbsp;&nbsp;&nbsp;&nbsp;
	    <input name="current" type="radio" value="AC" <?php if($page=='admin' && $f[7]=='Yes') { ?> checked <?php } ?>  required>AC &nbsp;&nbsp;&nbsp;
		<input name="current" type="radio" value="DC" <?php if($page=='admin' && $f[7]=='No') { ?> checked <?php } ?>  required>DC</td>
    </tr>		
<?php	}




		elseif($cat=='item')	{	?>		
	<tr valign="top" height="46">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Item Name/Type : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="type" style="font-family:Constantia; text-transform:capitalize;  font-size:18px;" placeholder="What type of item is it?" value="<?php if($page=='admin') echo $f[4]; ?>" maxlength="20" required></td>
    <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e;"> Purpose of the Item : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="purpose" style="font-family:Constantia; text-transform:capitalize;  font-size:18px;" placeholder="For which purpose is it used ?" value="<?php if($page=='admin') echo $f[5]; ?>" size="25" maxlength="50" required></td>
    </tr>
	<tr valign="top" height="46">
      <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Is it Branded ? <span style="padding-left:60px; color:black;">
        <input name="branded" type="radio" value="Yes" <?php if($page=='admin' && $f[6]=='Yes') { ?> checked <?php } ?> onClick="brand.disabled=false" required>Yes &nbsp;&nbsp;&nbsp;
        <input name="branded" type="radio" value="No" <?php if($page=='admin' && $f[6]=='No') { ?> checked <?php } ?> onClick="brand.disabled=true" required>No</span></td>
	  <td align="right" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Brand Name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="brand" style="font-family:Constantia; text-transform:capitalize; font-size:18px;" placeholder="Which brand of it is?" size="25" value="<?php if($page=='admin') echo $f[7]; ?>" maxlength="50"></td>
    </tr>				
<?php	}	?>



	
  <tr valign="top" height="46">
    <td colspan="2" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Age of the <?php echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item"; ?> : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:black"> 
    <select name="year" style="font-family:'Liberation Serif'; font-size:18px;" required>
	<option selected value="">Select</option>
<?php if($page=='admin') { ?> <option selected> <?php echo $f['year']; ?> </option> <?php } ?>
	<option>0</option>
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option>5</option>
	<option>6</option>
	<option>7</option>
	<option>8</option>
	<option>9</option>
	<option>10</option>
	<option>11 - 15</option>
	<option>16 - 20</option>
	<option>21 - 30</option>
	<option>31 - 50</option>
	<option>51 - 75</option>
	<option>76 - 100</option>
	<option>101 - 150</option>
	<option>151 - 200</option>
	<option>More than 200</option>
   </select>&nbsp;&nbsp;years &nbsp;&nbsp;&nbsp;
   <select name="month" style="font-family:'Liberation Serif'; font-size:18px;" required>
	<option selected value="">Select</option>
<?php if($page=='admin') { ?> <option selected> <?php echo $f['month']; ?> </option> <?php } ?>
	<option>0</option>
	<option>1</option>
	<option>2</option>
	<option>3</option>
	<option>4</option>
	<option>5</option>
	<option>6</option>
	<option>7</option>
	<option>8</option>
	<option>9</option>
	<option>10</option>
	<option>11</option>
  </select>&nbsp;&nbsp;months</span></td>
  </tr>
  <tr valign="top" height="90">
    <td colspan="2" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Write about your <?php echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item"; ?> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="something" style="font-family:Constantia; font-size:20px; height:75px; width:700px" placeholder="Write within 500 charecters"><?php if($page=='admin') echo $f['something']; ?></textarea></td>
  </tr>
  <tr valign="top" height="46">
    <td colspan="2" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Upload a colour picture of your <?php  echo $cat; if($cat=='study') echo " material"; elseif($cat=='antique' || $cat=='electronics') echo " item";  ?> <span style="font-family:'Times New Roman'">(maximum size 500kb)</span> : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="file" name="picture" style="font-family:Constantia; font-size:16px" <?php if($page!='admin') { ?> required <?php } ?> >
	</td>
  </tr>
  <tr valign="top" height="46">
    <td colspan="2" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Expected Minimum Price (Rs.) : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="price" title="Enter in digit" style="font-family:'Liberation Serif'; font-size:17px" placeholder="What is your expected price?" value="<?php if($page=='admin') echo $f['price']; ?>" maxlength="20" required></td>
  </tr>
  <tr valign="top" height="46">
    <td colspan="2" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Last Date of Bidding : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <select name="dd" style="font-size:17px; font-family:'Liberation Serif';" required>
    <option selected value="">Day</option>
<?php if($page=='admin') { ?> <option selected> <?php print date('d',$f['ts']) ?> </option> <?php } ?>
    <option>01</option>
    <option>02</option>
    <option>03</option>
    <option>04</option>
    <option>05</option>
    <option>06</option>
    <option>07</option>
    <option>08</option>
    <option>09</option>
    <option>10</option>
    <option>11</option>
    <option>12</option>
    <option>13</option>
    <option>14</option>
    <option>15</option>
    <option>16</option>
    <option>17</option>
    <option>18</option>
    <option>19</option>
    <option>20</option>
    <option>21</option>
    <option>22</option>
    <option>23</option>
    <option>24</option>
    <option>25</option>
    <option>26</option>
    <option>27</option>
    <option>28</option>
    <option>29</option>
    <option>30</option>
    <option>31</option>
  </select>
  &nbsp;
  <select name="mm" style="font-size:17px; font-family:Constantia;" required>
    <option selected value="">Month</option>
<?php if($page=='admin') { ?> <option value="<?php print date('m',$f['ts']) ?>" selected> <?php print date('F',$f['ts']) ?> </option> <?php } ?>
    <option value="01">January</option>
    <option value="02">February</option>
    <option value="03">March</option>
    <option value="04">April</option>
    <option value="05">May</option>
    <option value="06">June</option>
    <option value="07">July</option>
    <option value="08">August</option>
    <option value="09">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
  </select>
  &nbsp;
  <select name="yy" style="font-size:17px; font-family:'Liberation Serif';" required>
    <option selected value="">Year</option>
<?php if($page=='admin') { ?> <option selected> <?php print date('Y',$f['ts']) ?> </option> <?php } ?>
    <option>2013</option>
    <option>2014</option>
    <option>2015</option>
    <option>2016</option>
    <option>2017</option>
    <option>2018</option>
    <option>2019</option>
    <option>2020</option>
    <option>2021</option>
    <option>2022</option>
    <option>2023</option>
    <option>2024</option>
    <option>2025</option>
    <option>2026</option>
    <option>2027</option>
    <option>2028</option>
    <option>2029</option>
    <option>2030</option>
    <option>2031</option>
    <option>2032</option>
    <option>2033</option>
    <option>2034</option>
    <option>2035</option>
    <option>2036</option>
    <option>2037</option>
    <option>2038</option>
    <option>2039</option>
    <option>2040</option>
  </select>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Time : &nbsp; <span style="color:black; font-family:'Liberation Serif';">11:59:59 PM</span>    </td>
    </tr>
<?php if($page=='user') { ?>
  <tr valign="top">
    <td height="61" colspan="2" style="font-family:Constantia; font-size:20px; color:#E90000; font-weight:bold; font-style:italic; text-align:justify">** Before uploading read again your information very carefully if there is any mistake. Because you can't modify &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;your information after uploaded.</td>
  </tr>
  <tr align="center">
    <td colspan="2" style="font-family:Constantia; font-size:20px;"> &nbsp;
	<input type="checkbox" name="chkAgree" onClick="btnSubmit.disabled=false" style="height:15px; width:15px" / > I hereby declare that the above information's are true to best of my knowledge.</td>
  </tr>
<?php } ?>
</table>	
<br>
<div align="center"> <input id="round" input type="submit" name="btnSubmit" style="font-family:Constantia; font-size:15px;" value="<?php if($page=='admin') echo "Save"; else echo "Upload"; ?> Advertisement">
<style type="text/css"> 

input#round{
width:17
0px; /*same as the height*/
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
 </div>
</form>
<br><br>
<div id="footer">
		  <div>
				<p>&copy Copyright 2015. All rights reserved</p>
		  </div>
</div>

</body>
</html>