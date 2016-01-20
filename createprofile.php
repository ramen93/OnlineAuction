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

if(isset($e))  {		//	edit profile
	$q=mysql_query("select * from user where email='$e'");
	$f=mysql_fetch_array($q);						
	$n = $f['name'];
	$pic = $f['picture'];
}
elseif(isset($_GET['email']))  {		//	create profile
	$e=$_GET['email'];
}
else  {
	header("location:register.php? cat=new account& b=Register first!");
}				
?>



<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		Create Profile
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title><?php if(isset($_SESSION['email'])) echo "Edit"; else echo "Create"; ?> Profile</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="300">
</head>
<body>
  <div id="header">
	<div id="logo"><a href="index.php"><img src="images/logo.gif" alt="" /></a></div>		
			<ul>
<?php  if(isset($_SESSION['email']))	{	?>
				<li><a href="profile.php">My Profile</a></li>
				<li class="selected"><a href="createprofile.php">Edit Profile</a></li>
				<li><a href="verifysecurity.php? cat=editsec">Change Security</a></li>
				<li><a href="verifysecurity.php? cat=delacc">Delete Account</a></li>				
				<li><a href="logout_code.php">Log Out</a></li>
<?php	}	else	{	?>
	 			<li class="selected"><a href="index.php">Home</a></li>
				<li><a href="gallery.php">Gallery</a></li>	
				<li><a href="about.php">About Us</a></li>
				<li><a href="contact.php">Contact Us</a></li>
				<li><a href="register.php? cat=new account">Create Account</a></li>
<?php	}	?>		
			</ul>
	</div>
	
	<div align="right" style="font-size:20px; font-family:Constantia;padding-right:30px; color:black"><?php if(!empty($message)) echo $message; ?><label style="color:red"><?php if (!empty($mess)) echo $mess ?></label>
	<span style="padding-left:175px;font-family:'Liberation Sans'; font-size:18px; color:#999999"><?php date_default_timezone_set('Asia/Kolkata'); print date('h:i A d-m-Y D'); ?></span></div>
	
	<div id="body">
	  <div class="about">
		<table width="941" height="75" border="0" align="center">
          <tr style="font-family:Constantia; text-transform:capitalize;">
            <td height="34" style="color:#2a4f5e; font-size:30px;"><?php if(isset($_SESSION['email'])) echo "Edit"; else echo "Create"; ?> Your Profile</td>
            <td width="259" align="right"><a href="profile.php" style="text-decoration:none; color:black; font-size:22px"><?php if(isset($_SESSION['email'])) echo $n; ?></a></td>
            <td width="65" align="right"><a href="profile.php"><?php if(isset($_SESSION['email'])) { ?><img width="50px" height="50px" src="<?php echo $pic; ?>" style="border-radius:50%;" title="Go to profile" /><?php } ?></a></td>
          </tr>
        </table>
		<br><br><br>
			
			
<form action="createprofile_code.php? email=<?php echo $e; ?>" method="post" enctype="multipart/form-data">
 <table width="810" border="0">
  <tr valign="top" height="55">
   <td width="238" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Name :</td>
   <td width="558">
    <select name="gen" title="Sex" style="font-family:Constantia; font-size:16px" required>
	<option selected value="">Gender</option>
	<option <?php if(isset($_SESSION['email']) && $f[1]=='Mr.') { ?> selected <?php } ?> >Mr.</option>
	<option <?php if(isset($_SESSION['email']) && $f[1]=='Ms.') { ?> selected <?php } ?> >Ms.</option>
	<option <?php if(isset($_SESSION['email']) && $f[1]=='Mrs.') { ?> selected <?php } ?> >Mrs.</option>
    </select>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="name" title="Full Name" size="40" style="font-family:Constantia; font-size:16px; text-transform:capitalize" <?php if(isset($_SESSION['email'])) { ?> value="<?php echo $f[2]; ?>" <?php } ?> placeholder="What is your name ?" maxlength="100" required /></td>               
  </tr>
  <tr valign="top" height="55">
   <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Date of Birth :</td>
   <td><select name="dd" title="Day" style="font-family:'Times New Roman'; font-size:16px" required >
    <option value="" selected>Day</option>
<?php if(isset($_SESSION['email'])) { ?> <option  value="<?php echo $f[3]; ?>" selected><?php echo $f[3]; ?></option> <?php } ?>
	<option value="01">01</option>
	<option value="02">02</option>
	<option value="03">03</option>
	<option value="04">04</option>
	<option value="05">05</option>
	<option value="06">06</option>
	<option value="07">07</option>
	<option value="08">08</option>
	<option value="09">09</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>
    </select>&nbsp;&nbsp;&nbsp;&nbsp;
    <select name="mm" title="Month" style="font-family:Constantia; font-size:16px" required><option value="" selected>Month</option>
<?php if(isset($_SESSION['email'])) { ?> <option value="<?php echo $f[4]; ?>" selected><?php echo $f[4]; ?></option> <?php	}	?>
	<option value="January">January</option>
	<option value="Febuary">February</option>
	<option value="March">March</option>
	<option value="April">April</option>
	<option value="May">May</option>
	<option value="June">June</option>
	<option value="July">July</option>
	<option value="August">August</option>
	<option value="September">September</option>
	<option value="October">October</option>
	<option value="November">November</option>
	<option value="December">December</option>
    </select>&nbsp;&nbsp;&nbsp;&nbsp;
    <select name="yy" title="Year" style="font-family:'Times New Roman'; font-size:16px" required >
	<option value="" selected>Year</option>
<?php if(isset($_SESSION['email'])) { ?> <option value="<?php echo $f[5]; ?>" selected><?php echo $f[5]; ?></option> <?php	}	?>
	<option>2000</option>
	<option>1999</option>
	<option>1998</option>
	<option>1997</option>
	<option>1996</option>
	<option>1995</option>
	<option>1994</option>
	<option>1993</option>
	<option>1992</option>
	<option>1991</option>
	<option>1990</option>
	<option>1989</option>
	<option>1988</option>
	<option>1987</option>
	<option>1986</option>
	<option>1985</option>
	<option>1984</option>
	<option>1983</option>
	<option>1982</option>
	<option>1981</option>
	<option>1980</option>
	<option>1979</option>
	<option>1978</option>
	<option>1977</option>
	<option>1976</option>
	<option>1975</option>
	<option>1974</option>
	<option>1973</option>
	<option>1972</option>
	<option>1971</option>
	<option>1970</option>
	<option>1969</option>
	<option>1968</option>
	<option>1967</option>
	<option>1966</option>
	<option>1965</option>
	<option>1964</option>
	<option>1963</option>
	<option>1962</option>
	<option>1961</option>
	<option>1960</option>
	<option>1959</option>
	<option>1958</option>
	<option>1957</option>
	<option>1956</option>
	<option>1955</option>
	<option>1954</option>
	<option>1953</option>
	<option>1952</option>
	<option>1951</option>
	<option>1950</option>
    </select></td>               
  </tr>
  <tr valign="top" height="55">
   <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Occupation :</td>
   <td><input type="text" name="occ" title="Profession" size="40" style="font-family:Constantia; font-size:16px; text-transform:capitalize" <?php if(isset($_SESSION['email'])) { ?> value="<?php echo $f[6]; ?>" <?php } ?> placeholder="What do you work ?" maxlength="100" required /></td>
  </tr>
  <tr>
   <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Organization Name :</td>
   <td><input type="text" name="orgname" title="Full name of Organization" size="40" style="font-family:Constantia; font-size:16px; text-transform:capitalize" <?php if(isset($_SESSION['email'])) { ?> value="<?php echo $f[7]; ?>" <?php } ?> placeholder="Where do you work ?" maxlength="100" required /></td>               
  </tr>
 </table>
			
<br><br>

 <table width="919" border="0">
  <tr height="55" valign="top">
   <td width="127" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Country :</td>              
   <td width="280">
    <select name="country" title="Country" style="font-family:Constantia; font-size:16px" required>
<?php if(isset($_SESSION['email'])) { ?>  <option selected value="<?php echo $f[8]; ?>"><?php echo $f[8]; ?></option>	<?php	}	?>
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
   <td width="75">&nbsp;</td>
   <td width="131" style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Address :</td>
   <td rowspan="2" width="284"><textarea name="add" title="Full Postal Address" style="height:80px; width:260px; font-family:'Times New Roman'; font-size:18px;" placeholder="Where do you live ?" maxlength="100" required><?php if(isset($_SESSION['email'])) echo $f[9]; ?></textarea></td>
  </tr>
  <tr>
   <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Phone :</td>
   <td colspan="3"><input type="text" name="phone" title="Enter 10 digit number" size="23" style="font-family:'Liberation Sans'; font-size:17px" <?php if(isset($_SESSION['email'])) { ?> value="<?php echo $f[10]; ?>" <?php } ?> placeholder="Give your contact number" maxlength="10" required></td>
  </tr>
 </table>

		<br><br>
		
  <table width="598" border="0" align="center">
   <tr>
    <td width="325">&nbsp;</td>
    <td width="263" rowspan="3"><img width = "255" height="255" src="<?php if(isset($_SESSION['email'])) echo $f[11]; else echo "images/empty.jpg" ?>"  class="hbgimg" style=" border-radius: 27%; border:solid black" /></td>
   </tr>
   <tr height="60">
    <td style="font-family:Constantia; font-size:20px; color:#2a4f5e;">Upload your profile picture:<br>
	<span style="font-family:'Times New Roman'; font-size:16px; color:#999999">(Maximum size 500kb)</span><br></td>
   </tr>
   <tr valign="top">
    <td><input name="picture" type="file" style="font-family:'Liberation Serif'; font-size:18px; color:#000000" /></td>
   </tr>       
<?php  if(isset($_SESSION['email'])) {  ?>
   <tr>
    <td height="23">&nbsp;</td>
    <td align="center"><a href="createprofile_code.php? data=delpic"><img src="images/deletepic1.png" /></a></td>
   </tr>
<?php	}	?>
  </table>
		
		<br><br>
		
  <div align="center"><input id="round" input type="submit" value="Save Profile Data" style="font-family:Constantia; font-size:15px;" />
  <style type="text/css"> 

input#round{
width:150px; /*same as the height*/
height:30px; /*same as the width*/
background-color:perple;
border:1px solid perple; /*same colour as the background*/
color:#fff;
font-size:	1.5em;
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
			
  </div>
	</div>
		<div id="footer">
		  <div>
				<p class="style10">&copy Copyright 2014. All rights reserved</p>
		  </div>
</div>
</body>
</html>