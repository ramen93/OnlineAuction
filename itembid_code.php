<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_GET['cat']) && isset($_GET['id'])) {			//	category and id of the auction item
	$cat=$_GET['cat'];
	$id=$_GET['id'];
}
else  {
	header("location:#");
}

if(isset($_SESSION['email']))  {
	$e=$_SESSION['email'];
	$q=mysql_query("select * from user where email='$e'");
	$f=mysql_fetch_array($q);
	$name = $f['name'];
}
else  {
	header("location:index.php? b=You're not logged in! Log in first");
}

$bidding_price=intval($_POST['bidding_price']);		//	submited price by present bidder

$q=mysql_query("select * from $cat where id='".$id."'");
$f=mysql_fetch_array($q);
$bid_price=$f['bid_price'];			//	highest bidding price
$advertiser_email=$f['email'];

if($bid_price==0) {			//	if bidding isn't started
	$bid_price=$f['price'];		//	then we consider bidding price same as expected minimum price
}

if($bidding_price>$bid_price) {		//	if entering price is greater than highest bidding price/expected minimum price
	$q=mysql_query("update $cat set bid_price='$bidding_price',bidder_email='$e',bidder_name='$name' where id='".$id."'");

	$q=mysql_query("select * from bidders");
	$f=mysql_fetch_array($q);
	$n=$f['n']+1;
	$bidders_id=$n;

	date_default_timezone_set('Asia/Kolkata');
	$ts=mktime();		//	present timestamp

	$q=mysql_query("insert into bidders values('$bidders_id', '$n', '$cat', '$id', '$ts', '$bidding_price', '$e', '$name', '$advertiser_email')");
	$q=mysql_query("update bidders set n='$n'");

	header("location:itembid.php? cat=$cat& id=$id& a=You're the highest bidder !");
	exit();
}
else {
	header("location:itembid.php? cat=$cat& id=$id& b=Sorry, price is low !");
	exit();
}
?>