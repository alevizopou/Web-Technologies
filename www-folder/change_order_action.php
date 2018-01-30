<?php
session_start();

$order_id = $_POST['order_id'];
$_SESSION['order_id'] = $order_id;

$con = mysql_connect("localhost","root","");
if (!$con)
	die('Could not connect: ' . mysql_error());
	
mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$result = mysql_query("SELECT * FROM orders WHERE id='$order_id'")or die(mysql_error());
$row = mysql_fetch_array( $result );

$num = $row['num_items'] ;

$_SESSION['num_items'] = $num;

mysql_close($con);

/* php function gia na min ektypwnontai ta notices, evgaze sto parakatw include */ 
error_reporting(0);
include("choose_category.php");

?>