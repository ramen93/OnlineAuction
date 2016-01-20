<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(empty($_SESSION['email']))  {
	header("location:index.php? b=You're not logged in! Log in first");
	exit();
}

$q=mysql_query("select * from contact");
$r=mysql_num_rows($q);	// The Sequence Number of Rows
$k=0;		// var 'k' is initialized. this var declares size of the array $_SESSION['m'] for on_clicked message
for($i=0;$i<$r;$i++)  {
	$f=mysql_fetch_array($q);
	if($_POST["mchk-$i"]=='on')  {		//	if any message is on_clicked. $i is the sequence no. of messages
		$_SESSION['m'.$k]=$f[0];		//	mid of on_clicked message is stored in array session['m'] whose location is declared by var 'k'
		$k++;		//	size of array is increased
	}
}
if($k==0)
	header("location:contactadmin.php? a=No message is selected !");
else
	header("location:delconfirm.php? cat=message& k=$k");
?>			