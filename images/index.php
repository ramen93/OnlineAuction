
<!DOCTYPE html>
<!--	Project :-		Online Auction
		Document :-		Index
		Date :-			09/04/2015
		Author :-		Aniket Mazumdar
-->
<html>
<head>
<meta charset="utf-8" />
<title>Online Auction</title>
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<link rel="shortcut icon" href="images/icon.png">
<meta http-equiv="refresh" content="300">
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
<body>
  <div id="header">
	<div id="logo"><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('index','','images/index.png',1)"><img src="images/logo.gif" name="index" width="400" height="85" border="0"></a></div>
	<ul>
	 <li class="selected"><a href="index.php">Home</a></li>
	 <li><a href="gallery.php">Gallery</a></li>	
	 <li><a href="about.php">About Us</a></li>
	 <li><a href="contact.php">Contact Us</a></li>
	 <li><a href="register.php? cat=new account">Create Account</a></li>
	</ul>
  </div>
  
  <div id="body">
   <div class="header">
	<div style="color:black; font-size:22px; font-family:Constantia"><br>
	 <table height="80px"><tr><td><span style="color:red;"></span></td></tr></table>
	<div><br><br>

	
	<marquee behavior="alternate" width="140px" scrolldelay="400" onMouseOut="start()" onMouseOver="stop()"><label style="font-family:Constantia; font-size:22px; color:#2a4f5e">Log In Here !</label></marquee><br><br>
<form action="login_code.php" method="post" enctype="multipart/form-data">
	<table width="411" height="176" border="0">
     <tr>
      <td width="123" height="27" style="font-family:Constantia; font-size:18px; color:#2a4f5e">User ID :</td>
      <td width="278"><input type="text" name="email" title="Account-id" size="27" style="font-family:'Times New Roman'; font-size:18px" placeholder="Enter your email-id" maxlength="100" required></td>
	 </tr>
     <tr>
      <td height="54" style="font-family:Constantia; font-size:18px; color:#2a4f5e">Password :</td>
      <td><input type="password" name="password" title="Password" size="25" style="font-family:'Courier New'; font-weight:bolder; font-size:18px;" placeholder="Enter your password" maxlength="15" oncopy="return false" required></td>
     </tr>
     <tr>
	  <td height="32" colspan="2" align="right" valign="bottom"><label style="padding-right:94px; font-family:Arial; font-size:16px">
	  <input type="checkbox" name="rem" value="on">Remember Me</label>
	  <input id="round" input type="submit" value="Log In" style="font-family:Constantia; font-size:16px">
	  <style type="text/css"> 

input#round{
width:100px; /*same as the height*/
height:30px; /*same as the width*/
background-color:perple;
border:1px solid perple; /*same colour as the background*/
color:#fff;
font-size:	.9em;
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
     <tr>
      <td height="43" colspan="2" align="right" valign="bottom"><marquee behavior="alternate" scrolldelay="400" onMouseOut="start()" onMouseOver="stop()"><a href="verifysecurity.php? cat=editsec" style="color:black; font-family:Constantia; font-size:17px; text-decoration:none">Forgot Password ?</a></marquee></td>
     </tr>
    </table>
</form>
	</div>
   </div>
  </div>
  <div class="body">
   <div class="section">
	<a href="about.php"><img src="images/About Us.jpg" alt="" style=" border-radius: 100%; border: solid #C0C0C0" title="About Us" /></a>			
   </div>	
   <div class="article">
	<h4>What does Online Auction mean ?</h4>	
	<p>An online auction is a service in which auction users or participants sell or bid for products or services via the Internet. Virtual auctions facilitate online activities between buyers and sellers in different locations or geographical areas. Various auction sites provide users with platforms powered by different types of auction software.</p>
	<p>&nbsp;</p>
	<p>An online auction is also known as a virtual auction.</p>
   </div>
   <div class="section">
	<a href="contact.php"><img src="images/contact.png" alt="" style=" border-radius: 100%; border: solid #C0C0C0" title="Contact Us" /></a>			
   </div>		
  </div>
 </div>
 <div id="footer"><div><p>&copy Copyright 2015. All rights reserved</p></div></div>
 
 
 
 <script>
 	
 </script>
 
 
</body>
</html>