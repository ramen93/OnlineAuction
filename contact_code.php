<?php
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);
 
$name=$_POST['name'];
$email=strtolower($_POST['email']);
$mtitle=$_POST['mtitle'];
$message=$_POST['message'];

if(substr_count($_POST['email'],'@')!= 1)		// to check whether there is any '@' in entering email-id
	header("location:contact.php? b=Incorrect formate of email-id !& name=$name& mtitle=$mtitle& message=$message");
else  {	
	$q=mysql_query("select * from user where email='$email'"); 
	$f=mysql_fetch_array($q);
	if($f)
		$ru='Registered';
	else 
		$ru='Unregistered';
	
	$q=mysql_query("select * from contact");
	$f=mysql_fetch_array($q);
	$mn=$f[1]+1;	//	message sequence number
	$msgid=$mn;
	$q=mysql_query("update contact set mn='$mn'");
	$q=mysql_query("insert into contact values('$msgid','$mn','$ru','$email','$name','$mtitle','$message','no','no','no')");
	
	$dest='contactpics/msgid-'.$msgid.' ('.$email.')'; // Relative path under webroot
	$ext=basename($_FILES['pic']['type']);	// extension of the image_file
	$image = $dest.".".$ext;
	if(move_uploaded_file($_FILES['pic']['tmp_name'], $image))	{
		$q=mysql_query("update contact set picture='$image' where msgid='$msgid'");
	}
	header("location:contact.php? a=Your message has been sent successfully !");
}
?>