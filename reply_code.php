<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(empty($_SESSION['email']))  {
	header("location:index.php? b=You're not logged in! Log in first");
	exit();
}
		
$msgid=$_GET['msgid'];
$rt=$_POST['rtitle'];
$repl=$_POST['reply'];

$q=mysql_query("update contact set reply='$repl', rtitle='$rt' where msgid='$msgid'");

$q=mysql_query("select * from contact where msgid='$msgid'");
$f=mysql_fetch_array($q);
$email=$f[3];
mail($email, $rt, $repl, 'From: admin@onlineauction.com');		//	mail('sender's mail', 'subject', 'body of mail', 'From: admin@onlineauction.com');
header("location:reply.php? msgid=$msgid& a=Reply has been sent successfully !");
?> 