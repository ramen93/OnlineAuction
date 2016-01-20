<?php
session_start();
$con=mysql_connect("localhost","root","");
mysql_select_db("auction",$con);

if(isset($_GET['cat']) && isset($_GET['id'])) {
	$cat=$_GET['cat'];		//	category of auction item
	$id=$_GET['id'];		//	id of the auction item
}
else  {
	header("location:#");
}

if(isset($_SESSION['email']))  {
	$e=$_SESSION['email'];
	$q=mysql_query("select * from user where email='$e'");
	$f=mysql_fetch_array($q);
	if($f) {			//	if the page is accessed from user side
		$page='user';
	}
	else	{			//	if the page is accessed from admin side
		$q=mysql_query("select * from admin where email='$e'");
		$f=mysql_fetch_array($q);
		$page='admin';
	}
	$name=$f['name'];		//	name of the account logger
}
else  {
	header("location:index.php? b=You're not logged in! Log in first");
}	

$year=$_POST['year'];
$month=$_POST['month'];
$something=$_POST['something'];
$price=intval($_POST['price']);		//	value of price is converted in integer
$dd=$_POST['dd'];
$mm=$_POST['mm'];
$yy=$_POST['yy'];

$n=$id;		//	$n is the value of column 'n' in every auction item databse whose value is same as advertisement-id

date_default_timezone_set('Asia/Kolkata');
$ts = mktime(23, 59, 59, $mm, $dd, $yy);		//	mktime(hour, minute, second, month, day, year);	& $ts=0 when mktime(1, 0, 0, 1, 1, 1970);
$now = mktime();	//	present timestamp

if($page=='admin')	{
	$q=mysql_query("select * from $cat where id='$id'");
	$f=mysql_fetch_array($q);
	$image=$f['picture'];		//	$image contains address of old picture
	$e=$f['email'];
}

$dest = 'auctionpics/'.$cat.'-'.$id.' ('.$e.') ['.$_FILES['picture']['size']."] ".$_FILES['picture']['name'];
if(move_uploaded_file($_FILES['picture']['tmp_name'], $dest))	{		//	if the picture file goes to 'auctionpics' folder from its original destination
	$image=$dest;		//	$image contains address of new picture instead of old picture
	if($page=='admin' && strcmp($image,$f['picture'])!=0) {		//	when advertisement is modifying and uploading picture & old picture file aren't same
		unlink($f['picture']);			//	then delete old picture file from hard disk
	}
}
		
if($now>$ts)	{		//	if selected time is expired
	header("location:newadvertise.php? cat=$cat& id=$id& b=You select expired time for bidding !");
	unlink($image);
}
else	{		//	if selected time is not expired
	if($price==0)	{		//	if price is not integer value or '0' value
		header("location:newadvertise.php? cat=$cat& id=$id& b=Incorrect bidding price !");
		unlink($image);
	}
	else	{		//	if price is correct integer value
		if($cat=='house')  {			//	when category is HOUSE
			$category=$_POST['category'];
			$floor=$_POST['floor'];
			$room=intval($_POST['room']);		//	value of room is converted in integer
			$aircondition=$_POST['aircondition'];
			$balcony=$_POST['balcony'];
			$kitchen=$_POST['kitchen'];
			$bathroom=$_POST['bathroom'];
			$water=$_POST['water'];
			$hno=$_POST['hno'];
			$road=$_POST['road'];
			$area=$_POST['area'];
			$city=$_POST['city'];
			$district=$_POST['district'];
			$pin=intval($_POST['pin']);			//	value of pin is converted in integer
			$state=$_POST['state'];
			$country=$_POST['country'];
			$busstand=$_POST['busstand'];
			$railway=$_POST['railway'];
			$hospital=$_POST['hospital'];
			$firebrigade=$_POST['firebrigade'];
			$police=$_POST['police'];
			$market=$_POST['market'];
			$school=$_POST['school'];
			$college=$_POST['college'];
			$environment=$_POST['environment'];
			
			if($room==0)	{		//	if number of room is not integer value or '0' value
				header("location:newadvertise.php? cat=$cat& id=$id& b=Number of room is incorrect !");
				unlink($image);
			}
			else	{			//	if number of room is correct integer value
				if($pin==0)	{		//	if PIN/ZIP is not integer value or '0' value
					header("location:newadvertise.php? cat=$cat& id=$id& b=Incorrect PIN/ZIP code !");
					unlink($image);
				}
				else	{		//	if PIN/ZIP is correct integer value
					if($page=='user')	{		//	when new advertisement is uploading
						$q=mysql_query("insert into house values('$id', '$n', '$e', '$name', '$category', '$floor','$room', '$aircondition', '$balcony', '$kitchen', '$bathroom', '$water', '$hno', '$road', '$area', '$city', '$district', '$pin', '$state', '$country', '$busstand', '$railway', '$hospital', '$firebrigade', '$police', '$market', '$school', '$college', '$environment', '$year', '$month', '$something', '$image', '$price', '$ts', 'no', 'no', 'no')");
											
						$q=mysql_query("update $cat set n='$id'");	
						header("location:mystore.php? a=Advertisement is uploaded successfully !");
						
						$title="Uploaded House Advertisement in Online Auction";
						$body="Dear $name, your House Advertisement is successfully uploaded in our website. Your Advertisement ID: $cat-$id. Thank you.";
						mail($e, $title, $body, 'From: admin@onlineauction.com');
					}
					elseif($page=='admin')	{		//	when old advertisement is modifying
						$q=mysql_query("update house set category='$category', floor='$floor',room='$room', aircondition='$aircondition', balcony='$balcony', kitchen='$kitchen', bathroom='$bathroom', water='$water', hno='$hno', road='$road', area='$area', city='$city', district='$district', pin='$pin', state='$state', country='$country', busstand='$busstand', railway='$railway', hospital='$hospital', firebrigade='$firebrigade', police='$police', market='$market', school='$school', college='$college', environment='$environment', year='$year', month='$month', something='$something', picture='$image', price='$price', ts='$ts' where id='$id'");
						header("location:itembid.php? cat=$cat& id=$id& a=Advertisement is modified !");
						
						$title="Modified House Advertisement in Online Auction";
						$body="Dear user, your House Advertisement(ID: $cat-$id) is modified as per your request. Thank you.";
						mail($e, $title, $body, 'From: admin@onlineauction.com');
					}	
				}
			}
		}	



		elseif($cat=='vehicle')  {			//	when category is VEHICLE
			$wheeler=$_POST['wheeler'];
			$type=$_POST['type'];
			$engine=$_POST['engine'];
			$capacity=intval($_POST['capacity']);			//	value of engine capacity is converted in integer
			$sit=intval($_POST['sit']);			//	value of number of sit is converted in integer
			$aircondition=$_POST['aircondition'];
			$company=$_POST['company'];
			$model=$_POST['model'];
				
			if(!empty($_POST['capacity']) && $capacity==0)	{		//	if engine capacity is not interger value or '0' value
				header("location:newadvertise.php? cat=$cat& id=$id& b=Sorry, value of engine capacity is incorrect !");
				unlink($image);
			}
			else	{			//	if engine capacity is correct interger value
				if($sit==0)	{		//	if number of sit is not integer value or '0' value
					header("location:newadvertise.php? cat=$cat& id=$id& b=Sorry, number of sits is incorrect !");
					unlink($image);
				}
				else	{		//	if number of sit is correct integer value
					if($page=='user') {			//	when new advertisement is uploading
						$q=mysql_query("insert into vehicle values('$id', '$n', '$e', '$name', '$wheeler', '$type', '$engine', '$capacity', '$sit', '$aircondition', '$company', '$model', '$year', '$month', '$something', '$image', '$price', '$ts', 'no', 'no', 'no')");
							
						$q=mysql_query("update $cat set n='$id'");	
						header("location:mystore.php? a=Advertisement is uploaded successfully !");

						$title="Uploaded Vehicle Advertisement in Online Auction";
						$body="Dear $name, your Vehicle Advertisement is successfully uploaded in our website. Your Advertisement ID: $cat-$id. Thank you.";
						mail($e, $title, $body, 'From: admin@onlineauction.com');
					}
					elseif($page=='admin')	{		//	when old advertisement is modifying
						$q=mysql_query("update vehicle set wheeler='$wheeler', type='$type', engine='$engine', capacity='$capacity', sit='$sit', aircondition='$aircondition', company='$company', model='$model', year='$year', month='$month', something='$something', picture='$image', price='$price', ts='$ts' where id='$id'");
						header("location:itembid.php? cat=$cat& id=$id& a=Advertisement is modified !");

						$title="Modified Vehicle Advertisement in Online Auction";
						$body="Dear user, your Vehicle Advertisement(ID: $cat-$id) is modified as per your request. Thank you.";
						mail($e, $title, $body, 'From: admin@onlineauction.com');
					}
				}
			}		
		}
					

				
		elseif($cat=='furniture')  {			//	when category is FURNITURE
			$type=$_POST['type'];
			$antique=$_POST['antique'];
			$branded=$_POST['branded'];
			$brand=$_POST['brand'];
			$madeby=$_POST['madeby'];
				
			if($page=='user') {			//	when new advertisement is uploading
				$q=mysql_query("insert into furniture values('$id', '$n', '$e', '$name', '$type', '$antique', '$branded', '$brand', '$madeby', '$year', '$month', '$something', '$image', '$price', '$ts', 'no', 'no', 'no')");

				$q=mysql_query("update $cat set n='$id'");	
				header("location:mystore.php? a=Advertisement is uploaded successfully !");

				$title="Uploaded Furniture Advertisement in Online Auction";
				$body="Dear $name, your Furniture Advertisement is successfully uploaded in our website. Your Advertisement ID: $cat-$id. Thank you.";
				mail($e, $title, $body, 'From: admin@onlineauction.com');
			}
			elseif($page=='admin')	{		//	when old advertisement is modifying
				$q=mysql_query("update furniture set type='$type', antique='$antique', branded='$branded', brand='$brand', madeby='$madeby', year='$year', month='$month', something='$something', picture='$image', price='$price', ts='$ts' where id='$id'");
				header("location:itembid.php? cat=$cat& id=$id& a=Advertisement is modified !");

				$title="Modified Furniture Advertisement in Online Auction";
				$body="Dear user, your Furniture Advertisement(ID: $cat-$id) is modified as per your request. Thank you.";
				mail($e, $title, $body, 'From: admin@onlineauction.com');
			}
		}
		
		
		
		elseif($cat=='study')  {			//	when category is STUDY MATERIAL
			$type=$_POST['type'];
			$antique=$_POST['antique'];
			$brand=$_POST['brand'];
			$author=$_POST['author'];
				
			if($page=='user') {			//	when new advertisement is uploading
				$q=mysql_query("insert into study values('$id', '$n', '$e', '$name', '$type', '$antique', '$brand', '$author', '$year', '$month', '$something', '$image', '$price', '$ts', 'no', 'no', 'no')");

				$q=mysql_query("update $cat set n='$id'");	
				header("location:mystore.php? a=Advertisement is uploaded successfully !");

				$title="Uploaded Study Material Advertisement in Online Auction";
				$body="Dear $name, your Study Material Advertisement is successfully uploaded in our website. Your Advertisement ID: $cat-$id. Thank you.";
				mail($e, $title, $body, 'From: admin@onlineauction.com');
			}
			elseif($page=='admin')	{		//	when old advertisement is modifying
				$q=mysql_query("update study set type='$type', antique='$antique', brand='$brand', author='$author', year='$year', month='$month', something='$something', picture='$image', price='$price', ts='$ts' where id='$id'");
				header("location:itembid.php? cat=$cat& id=$id& a=Advertisement is modified !");

				$title="Modified Study Material Advertisement in Online Auction";
				$body="Dear user, your Study Material Advertisement(ID: $cat-$id) is modified as per your request. Thank you.";
				mail($e, $title, $body, 'From: admin@onlineauction.com');
			}
		}



		elseif($cat=='jewellery')  {			//	when category is JEWELLERY
			$type=$_POST['type'];
			$antique=$_POST['antique'];
			$brand=$_POST['brand'];
			$material=$_POST['material'];
				
			if($page=='user') {			//	when new advertisement is uploading
				$q=mysql_query("insert into jewellery values('$id', '$n', '$e', '$name', '$type', '$antique', '$brand', '$material', '$year', '$month', '$something', '$image', '$price', '$ts', 'no', 'no', 'no')");
				
				$q=mysql_query("update $cat set n='$id'");	
				header("location:mystore.php? a=Advertisement is uploaded successfully !");


				$title="Uploaded Jewellery Advertisement in Online Auction";
				$body="Dear $name, your Jewellery Advertisement is successfully uploaded in our website. Your Advertisement ID: $cat-$id. Thank you.";
				mail($e, $title, $body, 'From: admin@onlineauction.com');
			}
			elseif($page=='admin')	{		//	when old advertisement is modifying
				$q=mysql_query("update jewellery set type='$type', antique='$antique', brand='$brand', material='$material', year='$year', month='$month', something='$something', picture='$image', price='$price', ts='$ts' where id='$id'");
				header("location:itembid.php? cat=$cat& id=$id& a=Advertisement is modified !");

				$title="Modified Jewellery Advertisement in Online Auction";
				$body="Dear user, your Jewellery Advertisement(ID: $cat-$id) is modified as per your request. Thank you.";
				mail($e, $title, $body, 'From: admin@onlineauction.com');
			}
		}



		elseif($cat=='antique')  {			//	when category is ANTIQUE ITEM
			$type=$_POST['type'];
			$user=$_POST['user'];
			$branded=$_POST['branded'];
			$brand=$_POST['brand'];
				
			if($page=='user') {			//	when new advertisement is uploading
				$q=mysql_query("insert into antique values('$id', '$n', '$e', '$name', '$type', '$user', '$branded', '$brand', '$year', '$month', '$something', '$image', '$price', '$ts', 'no', 'no', 'no')");
				
				$q=mysql_query("update $cat set n='$id'");	
				header("location:mystore.php? a=Advertisement is uploaded successfully !");

				$title="Uploaded Antique Item Advertisement in Online Auction";
				$body="Dear $name, your Antique Item Advertisement is successfully uploaded in our website. Your Advertisement ID: $cat-$id. Thank you.";
				mail($e, $title, $body, 'From: admin@onlineauction.com');
			}
			elseif($page=='admin')	{		//	when old advertisement is modifying
				$q=mysql_query("update antique set type='$type', user='$user', branded='$branded', brand='$brand', year='$year', month='$month', something='$something', picture='$image', price='$price', ts='$ts' where id='$id'");
				header("location:itembid.php? cat=$cat& id=$id& a=Advertisement is modified !");

				$title="Modified Antique Item Advertisement in Online Auction";
				$body="Dear user, your Antique Item Advertisement(ID: $cat-$id) is modified as per your request. Thank you.";
				mail($e, $title, $body, 'From: admin@onlineauction.com');
			}
		}



		elseif($cat=='electronics')  {			//	when category is ELECTRONICS ITEM
			$type=$_POST['type'];
			$purpose=$_POST['purpose'];
			$volt=intval($_POST['volt']);			//	value of volt is converted in integer
			$current=$_POST['current'];
			
			if($volt==0)	{		//	if volt is not interger value or '0' value
				header("location:newadvertise.php? cat=$cat& id=$id& b=Sorry, voltage ammount is incorrect !");
				unlink($image);

				$title="Uploaded Electronics Item Advertisement in Online Auction";
				$body="Dear $name, your Electronics Item Advertisement is successfully uploaded in our website. Your Advertisement ID: $cat-$id. Thank you.";
				mail($e, $title, $body, 'From: admin@onlineauction.com');
			}
			else	{			//	if volt is correct interger value
				if($page=='user') {			//	when new advertisement is uploading
					$q=mysql_query("insert into electronics values('$id', '$n', '$e', '$name', '$type', '$purpose', '$volt', '$current', '$year', '$month', '$something', '$image', '$price', '$ts', 'no', 'no', 'no')");
					
					$q=mysql_query("update $cat set n='$id'");	
					header("location:mystore.php? a=Advertisement is uploaded successfully !");
				}
				elseif($page=='admin')	{		//	when old advertisement is modifying
					$q=mysql_query("update electronics set type='$type', purpose='$purpose', volt='$volt', current='$current', year='$year', month='$month', something='$something', picture='$image', price='$price', ts='$ts' where id='$id'");
					header("location:itembid.php? cat=$cat& id=$id& a=Advertisement is modified !");

					$title="Modified Electronics Item Advertisement in Online Auction";
					$body="Dear user, your Electronics Item Advertisement(ID: $cat-$id) is modified as per your request. Thank you.";
					mail($e, $title, $body, 'From: admin@onlineauction.com');
				}
			}
		}



		elseif($cat=='item')  {			//	when category is OTHER ITEM
			$type=$_POST['type'];
			$purpose=$_POST['purpose'];
			$branded=$_POST['branded'];
			$brand=$_POST['brand'];
				
			if($page=='user') {			//	when new advertisement is uploading
				$q=mysql_query("insert into item values('$id', '$n', '$e', '$name', '$type', '$purpose', '$branded', '$brand', '$year', '$month', '$something', '$image', '$price', '$ts', 'no', 'no', 'no')");
				
				$q=mysql_query("update $cat set n='$id'");	
				header("location:mystore.php? a=Advertisement is uploaded successfully !");

				$title="Uploaded Item Advertisement in Online Auction";
				$body="Dear $name, your Item Advertisement is successfully uploaded in our website. Your Advertisement ID: $cat-$id. Thank you.";
				mail($e, $title, $body, 'From: admin@onlineauction.com');
			}
			elseif($page=='admin')	{		//	when old advertisement is modifying
				$q=mysql_query("update item set type='$type', purpose='$purpose', branded='$branded', brand='$brand', year='$year', month='$month', something='$something', picture='$image', price='$price', ts='$ts' where id='$id'");
				header("location:itembid.php? cat=$cat& id=$id& a=Advertisement is modified !");

				$title="Modified Item Advertisement in Online Auction";
				$body="Dear user, your Item Advertisement(ID: $cat-$id) is modified as per your request. Thank you.";
				mail($e, $title, $body, 'From: admin@onlineauction.com');
			}
		}
	}
}					
?>