<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

$gen=$_POST['gen'];
$n=$_POST['name'];
$dd=$_POST['dd'];
$mm=$_POST['mm'];
$yy=$_POST['yy'];
$occ=$_POST['occ'];
$orgn=$_POST['orgname'];
$con=$_POST['country'];
$add=$_POST['add'];
$p=intval($_POST['phone']);		//	phone number is converted in integer

if(isset($_SESSION['email']))  {		//	EDIT PROFILE for old user account
	$e=$_SESSION['email'];
}
elseif(isset($_GET['email']))  {		//	CREATE PROFILE for new user account
	$e=$_GET['email'];
}
else  {
	header("location:register.php? cat=new account& b=Register first!");
}
	
$q=mysql_query("select * from user where email='$e'");
$f=mysql_fetch_array($q);
$image = $f['picture'];			// old image is fetching
	
if(isset($_GET['data']))  {		//	for delete profile picture
	if(strcmp($image,'images/empty.jpg')!=0) {
		unlink($image);
		$image='images/empty.jpg';				// empty profilepic of user
		$update=mysql_query("update user set picture='$image' where email='".$_SESSION['email']."'");
		header("location:createprofile.php? a=Profile picture has been deleted !");
		exit();
	}
	else {
		header("location:createprofile.php? b=No profile picture exists !");
	}
}
else	{		//	for create/edit the profile data
	$newimage = 'profilepic/'.$e.' ['.$_FILES['picture']['size']."] ".$_FILES['picture']['name'];
	if($image!=$newimage && move_uploaded_file($_FILES['picture']['tmp_name'], $newimage))  {		// checking whether profilepicture is changed
		if(strcmp($image,'images/empty.jpg')!=0) {		// Checking if the image isn't empty.jpg
			unlink($image);				// if itsn't then delete old image from $dest
		}
		$q=mysql_query("update user set picture='$newimage' where email='$e'");		// new image is updated
	}
	
	if($p!=0 && strlen($p)==10)	{			//	if phone number is 10 digit integer value
		$q=mysql_query("update user set name='$n', gender='$gen', dd='$dd', mm='$mm', yy='$yy', occupation='$occ', organization='$orgn', country='$con', address='$add', phone='$p' where email='$e'");
		
		if(isset($_SESSION['email']))  {
			$db[1]='house'; $db[2]='vehicle'; $db[3]='furniture'; $db[4]='study'; $db[5]='jewellery'; $db[6]='antique'; $db[7]='electronics'; $db[8]='item';
			
			for($i=1;$i<9;$i++)	{		//	modified name replaced in all database of auction items
				$query=mysql_query("update $db[$i] set bidder_name='$n' where bidder_email='$e'");
				$query=mysql_query("update $db[$i] set uploader_name='$n' where email='$e'");
			}
			$query=mysql_query("update bidders set bidder_name='$n' where bidder_email='$e'");		//	modified name replaced in all database 'bidders'
			$query=mysql_query("update contact set name='$n' where email='$e'");		//	modified name replaced in all database 'contact'
			header("location:createprofile.php? a=Profile has been updated !");
		}
		else	{
			$title="Successfully Registration in Online Auction";		//	title of mail
			$body="Dear $n, you are most welcome to Online Auction. You are registered successfully. Your Account User ID : $e .";		//	body of mail
			mail($e, $title, $body, 'From: admin@onlineauction.com');		//	mail('sender's mail', 'subject', 'body of mail', 'From: admin@OnlineAuction.com');
			header("location:index.php? a=You are registered successfully !");
		}	
	}
	else	{
		header("location:createprofile.php? email=$e& b=Incorrect phone number !");
	}	
}
?> 