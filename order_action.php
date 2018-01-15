<?php
session_start();
$username = $_SESSION['username'];
$item = $_POST['products'];
$extra = $_POST['extras'];

$flag_for_extra = 0;
$flag_for_new_order = 0;

if ($extra == "")
{
	$flag_for_extra = 1;
}

if(!isset($_SESSION['order_id']))
{
	$flag_for_new_order = 1;
	/* creation of a random number which will be the unique id of the order */
	list($usec, $sec) = explode(' ', microtime());
	$seed = (float) $sec + ((float) $usec * 100000);	
	srand($seed);
	/* the unique id of the order */
	$randval = rand();
	$_SESSION['order_id'] = $randval;
	$_SESSION['num_items'] = 0;
}
else
{
	$randval = $_SESSION['order_id'];
}

/* set the default timezone to use. */
date_default_timezone_set("Europe/Athens");

/* current date */
$d = date('Y-m-d H:i:s');

$con = mysql_connect("localhost","root","");
if (!$con)
	die('Could not connect: ' . mysql_error());
	
mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

/* dimiourgia tou order id  */
if($flag_for_new_order == 1){
	$sql = "INSERT INTO orders (id, waiter_name, the_date) VALUES ('$randval', '$username', '$d')";
	if (!mysql_query($sql,$con))
		die('Error: ' . mysql_error());
}
	
// order includes extra product
if($flag_for_extra == 0){
	$sql = "INSERT INTO item_in_order (order_id, waiter_name, product_name, property_name, order_date)
		VALUES
		('$randval', '$username', '$item', '$extra', '$d')";
	if (!mysql_query($sql,$con))
		die('Error: ' . mysql_error());
}
else{ // without extra product
	$sql = "INSERT INTO item_in_order (order_id, waiter_name, product_name, order_date)
		VALUES
		('$randval', '$username', '$item', '$d')";
	if (!mysql_query($sql,$con))
		die('Error: ' . mysql_error());
}

$result = mysql_query("SELECT * FROM product WHERE title='$item'")or die(mysql_error());
$row = mysql_fetch_array( $result );

/* afksisi tou popularity tou product stin vasi */
$popularity = $row['popularity']+1 ;
$result = mysql_query("UPDATE product SET popularity='$popularity' WHERE title='$item'") or die(mysql_error());
	
$_SESSION['num_items']++;

mysql_close($con);

header("Location: choose_category.php");
?>