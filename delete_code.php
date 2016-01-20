<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_SESSION['email']))  {
	$e=$_SESSION['email'];
}
else	{
	header("location:index.php? b=You're not logged in! Log in first");
	exit();
}

if(isset($_GET['cat']) && $_GET['page'])	{		// to get categoty of items that will be deleted 
	$cat=$_GET['cat'];
	$page=$_GET['page'];
}	
else 
	header("location:#");

if(isset($_GET['id']))		// to get no. of items to be deleted
	$id=$_GET['id'];

if(isset($_GET['k']))		// to get no. of items to be deleted
	$k=$_GET['k'];

if(isset($_SESSION['uemail']))  {		//	this session is created on userdata.php page
	$ue=$_SESSION['uemail'];
}

if($cat=='Bidder')	{
	$advertisement_id=$_GET['advertisement_id'];
	$category=$_GET['category'];
}

$db[0]='user'; $db[1]='house'; $db[2]='vehicle'; $db[3]='furniture'; $db[4]='study'; $db[5]='jewellery'; $db[6]='antique'; $db[7]='electronics'; $db[8]='item'; $db[9]='bidders'; $db[10]='contact';

if($cat=='account')	{
	if($page=='user')	{
		for($i=1;$i<9;$i++) {
			$q=mysql_query("select * from $db[$i] where email='$id'");		//	all database of auction items is selected to see there is any advertisement uploaded by this selected user (whose account is going to be deleted)
			$r=mysql_num_rows($q); echo $r;
			if($r>0) {		//	If any advertisement of this user exists in present
				header("location:delconfirm.php? cat=$cat& id=$id& b=Sorry, your advertisement isn't expired, so you can't delete this account !");
				break;
			}
			else  {			//	No advertisement of this user exist in present
				for($i=1;$i<9;$i++) {
					$q=mysql_query("select * from $db[$i] where bidder_email='$id'");		//	all database of auction items is selected to see there is any advertisement whose present highest bidder is this selected user (whose account is going to be deleted)
					$r=mysql_num_rows($q);
					if($r>0) {		//	If this type of any advertisement exists in present
						header("location:delconfirm.php? cat=$cat& id=$id& b=Sorry, you participated in bidding, so you can't delete this account !");
						break;
					}
					else  {			//	If this type of no advertisement exist in present
						$q=mysql_query("select * from user where email='$id'");		//	'user' database is selected to fetch address of profile picture
						$f=mysql_fetch_array($q);
						$name=$f['name'];	// for sending mail
						if(strcmp($f['picture'],'images/empty.jpg')!=0)
							unlink($f['picture']);		//	delete picture file from hard disk
						$q=mysql_query("delete from user where email='$id'");		//	delete this account from 'user' database
						
						$q=mysql_query("select * from contact where email='$id'");		//	'user' database is selected to fetch address of profile picture
						$r=mysql_num_rows($q);
						for($l=0;$l<$r;$l++) {
							$f=mysql_fetch_array($q);
							if(strcmp($f['picture'],'no')!=0)
								unlink($f['picture']);		//	delete picture file from hard disk
						}
						$q=mysql_query("delete from contact where email='$id'");	//	delete this contact from 'user' database
						$_SESSION = array();
						session_destroy();          // Destroying the session.
						setcookie("email", FALSE);   // Deleting the cookie.
						
						$title="Account Delete in Online Auction";		// reply email for his delete account
						$body="Dear $name, we are very sorry to see you no more. Your account has been deleted permanently. Thank you.";
						mail($id, $title, $body, 'From: admin@onlineauction.com');
						header("location:index.php? a=Your account has been deleted successfully !");
						exit();
					}
				}
			}
		}
	}
	if($page=='admin')	{
		$q=mysql_query("select * from admin");		//	'admin' database is selecetd to fetch admin name for sending email
		$f=mysql_fetch_array($q);
		$name=$f['name'];	//	for sending mail
		$r=mysql_num_rows($q);
		if($r<2) {		//	if only one account exists in 'admin' database, then it will be never deleted
			header("location:delconfirm.php? cat=$cat& id=$id& b=Sorry, this is only account, it will be never deleted !");
		}
		else  {			//	if more than one account exist in 'admin' database
			$q=mysql_query("select * from admin where email='$id'");
			$q=mysql_query("delete from admin where email='$id'");
			if($e==$id)	{		//	if deleted account is logged in
				$_SESSION = array();
				session_destroy();       // Destroying the session.
				header("location:index.php? a=Your account has been deleted sucessfully !");
			}
			else	{		//	when deleted account and logged in account are different
				header("location:admin.php? a=Admin account has been deleted sucessfully !");
			}
			$title="Account Delete in Online Auction";		//	reply mail to delete admin for deleting his account
			$body="Dear $name, your account has been deleted permanently from our website. If you wish to be part of member of Online Auction Administrator in future, contact with present administrator. Thank you.";
			mail($id, $title, $body, 'From: admin@onlineauction.com');
		}
	}			
}


if($cat=='user account')	{
	for($j=0;$j<$k;$j++)  {
		$id=$_SESSION['useracnt'.$j];		// to get mid of on_clicked message from array session['m']
		for($i=0;$i<11;$i++) {		//	all databse where column 'email' is same as selected email
			$q=mysql_query("select * from $db[$i] where email='$id'");		//	all database selected for fetching address of 'picture' and name for email
			$r=mysql_num_rows($q);
			for($l=0;$l<$r;$l++) {
				$f=mysql_fetch_array($q);
				if($db[$i]=='user')	{
					$name=$f['name'];		//	user name is needed for sending mail
				}
				if($db[$i]=='bidders')	{
					$bidder_email=$f['bidder_email'];	//	bidder email needed for sending mail
					$bidder_name=$f['bidder_name'];		//	bidder name is needed for sending mail
					$category=$f['category'];			//	advertisement category email is needed for sending mail
					$advertisement_id=$f['id'];						//	advertisement id is needed for sending mail
					$title="Advertisement Delete in Online Auction";		//	sending to all bidders of that advertisment which deleting user uploaded
					$body="Dear $bidder_name, we are sorry to say the $category advertisement(ID: $category-$advertisement_id) which you bade, was deleted from our website as per the advertiser's request. This advertisement was uploaded by his own mistake. For this mistake one and only the advertiser is responsible. So I think you understand this incident. So, please avoid this item and choose other one from the advertisement list. Thank you.";
					mail($bidder_email, $title, $body, 'From: admin@onlineauction.com');
				}
				$image = $f['picture'];
				if(strcmp($image,'images/empty.jpg')!=0)
					unlink($image);		//	delete picture file from hard disk
			}
			$q=mysql_query("delete from $db[$i] where email='$id'");		//	delete all data from all database where column 'email' value is same as selected email-id
		}
		$q=mysql_query("delete from bidders where bidder_email='$id'");		//	delete all data from 'bidders' present highest bidder is the selected deleting user
		
		for($i=1;$i<9;$i++) {			//	all database of auction items where present highest bidder is deleted user
			$q=mysql_query("select * from $db[$i] where bidder_email='$id'");
			$r=mysql_num_rows($q);
			for($l=0;$l<$r;$l++) {		//	for more than one same category advertisement where present highest bidder is deleted user
				$f=mysql_fetch_array($q);
				$category=$db[$i];
				$advertisement_id=$f['id'];
				$q=mysql_query("select * from bidders where category='$category' and advertisement_id='$advertisement_id'");	//	all bid_price of selected advertisement from bidders
				$rb=mysql_num_rows($q);
				for($lb=1;$lb<$rb+1;$lb++) {
					$f=mysql_fetch_array($q);
					$bid_price=$f['bid_price'];
					$bidder_email[$lb]=$f['bidder_email'];
					$bidder_name[$lb]=$f['bidder_name'];
				}
				for($lb=1;$lb<$rb+1;$lb++) {
					$title="Last Bidding Price changed in Online Auction";		//	all bidders of that auction item whose present highest bidder is deleting user
					$body="Dear $bidder_name[$lb], we are sorry to say that the last highest bidding price of the advertisement whose Advertisement ID: $category-$advertisement_id is changed. The last highest bidder removed his name from bidding. For this case last highest bidding price became Rs. $bid_price and highest bidder became again $bidder_name[$rb] whose Email-id: $bidder_email[$rb]. Thank you.";
					mail($bidder_email[$lb], $title, $body, 'From: admin@onlineauction.com');
				}
				$q=mysql_query("update $category set bid_price='$bid_price', bidder_email='$bidder_email', bidder_name='$bidder_name' where id='$advertisement_id'");
			}
		}
		$title="Account Delete in Online Auction";		//	reply mail to deleting user for delete his account
		$body="Dear $name, we are very sorry to see you no more. Your account has been deleted permanently. Thank you.";
		mail($id, $title, $body, 'From: admin@onlineauction.com');
	}
	if($k==1)
		header("location:admin.php? a=User account has been deleted !");
	else
		header("location:admin.php? a=$k User accounts have been deleted !");
}


elseif($cat=='house' || $cat=='vehicle' || $cat=='furniture' || $cat=='study' || $cat=='jewellery' || $cat=='antique' || $cat=='electronics' || $cat=='item')	{
	$q=mysql_query("select * from $cat where id='$id'");	//	database of the auction item is selected to fetch the address of picture
	$f=mysql_fetch_array($q);
	$image=$f['picture'];
	unlink($image);
	$uploader_name=$f['uploader_name'];		//	$uploader_name (Advertiser's name) is needed for reply email
	$email=$f['email'];		//	$email (Advertiser's email) is the sending address of the reply mail
	
	$title="Advertisement Delete in Online Auction";		//	reply to the advertiser for deleting his advertisement
	$body="Dear $uploader_name, we delete your adevrtisement (Id: $cat-$id) from our website as per your request. Thank you.";
	mail($email, $title, $body, 'From: admin@onlineauction.com');

	$q=mysql_query("select * from bidders where category='$cat' and advertisement_id='$id'");	//	'bidders' database is selected to fetch the $bidder_email, $bidder_name
	$r=mysql_num_rows($q);
	for($l=0;$l<$r;$l++) {
		$f=mysql_fetch_array($q);
		$bidder_email=$f['bidder_email'];		//	$bidder_email (Bidder's email) is the sending address of the reply mail
		$bidder_name=$f['bidder_name'];			//	$bidder_name (Bidder's name) is needed for reply email
		if($bidder_email!=$uploader_name)	{
			$title="Advertisement Delete in Online Auction";		//	sending to all bidders of that advertisement which is deleted
			$body="Dear $bidder_name, we are sorry to say the $cat advertisement(ID: $cat-$id) which you bade, was deleted from our website as per the advertiser's request. This advertisement was uploaded by his own mistake. For this mistake one and only the advertiser is responsible. So I think you understand this incident. So, please avoid this item and choose other one from the advertisement list. Thank you.";
			mail($bidder_email, $title, $body, 'From: admin@onlineauction.com');
		}
	}
	$q=mysql_query("delete from $cat where id='$id'");		//	delete the advertisement from its particular database
	$q=mysql_query("delete from bidders where category='$cat' and advertisement_id='$id'");		//	delete the bidders of this advertisement from database 'bidders'
	header("location:list.php? cat=$cat& a=One $cat advertisement has been deleted !");
}


elseif($cat=='Bidder')	{
	$q=mysql_query("select * from bidders where id='$id'");		//	select the bidder from database 'bidders' to fetch his name & email-id for sending email to him
	$f=mysql_fetch_array($q);
	$bidder_name=$f['bidder_name'];			//	name of the bidder is going to be delete
	$bidder_email=$f['bidder_email'];		//	email-id of the bidder is going to be delete
	$q=mysql_query("delete from bidders where id='$id'");	//	delete the bidder from database 'bidders'
	
	$title="Remove name from bidding in Online Auction";	//	reply to that bidder whose name is deleted
	$body="Dear $bidder_name, we delete your name from bidding whose Advertisement ID: $category-$advertisement_id as per your request. Thank you.";
	mail($bidder_email, $title, $body, 'From: admin@onlineauction.com');
	
	$q=mysql_query("select * from bidders where category='$category' and advertisement_id='$advertisement_id'");	//	all bid_price of selected advertisement from bidders
	$r=mysql_num_rows($q);
	for($l=1;$l<$r+1;$l++) {		//	for more than one bidders
		$f=mysql_fetch_array($q);
		$bid_price=$f['bid_price'];
		$bidder_email[$l]=$f['bidder_email'];
		$bidder_name[$l]=$f['bidder_name'];
	}
	for($l=1;$l<$r+1;$l++) {
		$title="Change highest bidding price in Online Auction";	//	sending to all bidders of that advertisement of which one bidder is deleted
		$body="Dear $bidder_name[$l], we are sorry to say that the last highest bidding price of the advertisement whose Advertisement ID: $category-$advertisement_id is changed. The last highest bidder removed his name from bidding. For this case last highest bidding price became Rs.- $bid_price and highest bidder became again $bidder_name[$r] whose Email-id: $bidder_email[$r]. Thank you.";
		mail($bidder_email[$l], $title, $body, 'From: admin@onlineauction.com');
	}
	$q=mysql_query("update $category set bid_price='$bid_price', bidder_email='$bidder_email[$r]', bidder_name='$bidder_name[$r]' where id='$advertisement_id'");
	header("location:bidderlist.php? cat=$category& id=$advertisement_id& a=One bidder has been deleted !");
}	


elseif($cat=='message')	{
	for ($j=0;$j<$k;$j++)  {
		$msgid=$_SESSION['m'.$j];		// to get mid of on_clicked message from array session['m']
		$q=mysql_query("select * from contact where msgid='$msgid'");
		$f=mysql_fetch_array($q);
		$image=$f['picture'];
		if(strcmp($image,'images/emptypic.png')!=0)
			unlink($image);
		$q=mysql_query("delete from contact where msgid='$msgid'");		// on_clicked message is deleting from database
	}
if($k==1)
	header("location:contactadmin.php? a=Message has been deleted !");
else
	header("location:contactadmin.php? a=$k messages have been deleted !");
}
?>