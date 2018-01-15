<?php

$id = $_GET['u'];
$price_i = 0;
$price_e = 0;

$con = mysql_connect("localhost","root","");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

// vriskoume to order_id sto opoio anikei to item 
$result = mysql_query("SELECT * FROM item_in_order WHERE id='$id'")or die(mysql_error());
$row = mysql_fetch_array($result);
$order_id = $row['order_id'];
$title = $row['product_name'];
$extra =  $row['property_name'];

// vriskoume posa items exei to order_id 
$result2 = mysql_query("SELECT * FROM item_in_order WHERE order_id='$order_id'")or die(mysql_error());
$num_items = mysql_num_rows($result2);

// periptwsi pou i paraggelia exei ena item
if($num_items == 1)
{
	mysql_query("DELETE FROM item_in_order WHERE id='$id'")or die(mysql_error());
	mysql_query("DELETE FROM orders WHERE id='$order_id'")or die(mysql_error());
	
	/* meiwsi tou popularity tou product stin vasi */
	$result3 = mysql_query("SELECT * FROM product WHERE title='$title'")or die(mysql_error());
	$row3 = mysql_fetch_array($result3);
	$popularity = $row3['popularity'] - 1;
	$result4 = mysql_query("UPDATE product SET popularity='$popularity' WHERE title='$title'") or die(mysql_error());
	
	exit;
}

// periptwsi pou i paraggelia exei parapanw apo ena items: prepei na ypologistei i kainouria total_price 
// kai na ananewthei o synolikos arithmos twn items tis paraggelias 
if($num_items > 1)
{
	$result5 = mysql_query("SELECT * FROM product WHERE title='$title'")or die(mysql_error());
	$row5 = mysql_fetch_array($result5);
	$price_i = $row5['price'];
	
	/* meiwsi tou popularity tou product stin vasi */
	$popularity = $row5['popularity'] - 1;
	$result6 = mysql_query("UPDATE product SET popularity='$popularity' WHERE title='$title'") or die(mysql_error());

	// tsekaroume an exei extra to item pou diagrafoume 
	 if ($extra != null)
	{
		$res = mysql_query("SELECT * FROM property WHERE name ='$extra'")or die(mysql_error());
		$row6 = mysql_fetch_array($res);
		$price_e = $row6['extraPrice'];
	}
	
	$result7 = mysql_query("SELECT * FROM orders WHERE id='$order_id'")or die(mysql_error());
	$row7 = mysql_fetch_array($result7);	
	$total_price = $row7['price'];
	
	// ypologismos kainourias timis 
	$total_price = $total_price - $price_i - $price_e;
	
	$num_items = $num_items - 1;

	$result = mysql_query("UPDATE orders SET price='$total_price',num_items='$num_items' WHERE id='$order_id'") or die(mysql_error());
	mysql_query("DELETE FROM item_in_order WHERE id='$id'")or die(mysql_error());
}

?>