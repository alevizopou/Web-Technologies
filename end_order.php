<?php
session_start();
$order = $_SESSION['order_id'];
$num_items = $_SESSION['num_items'];
echo $num_items;

// calculate total price of an order and insert the total number of items 

$con = mysql_connect("localhost","root","");
if (!$con)
	die('Could not connect: ' . mysql_error());
	
mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$total_price = 0;
$extra_price = 0;

// apo to item_in_order vriskoume ta ids 
$res_items = mysql_query("SELECT * FROM item_in_order WHERE order_id='$order'")or die(mysql_error());

while($rows=mysql_fetch_assoc($res_items)){
     $extra_price = 0;
	 // pairnoume ta products me to idio order_id
	  $title_items = $rows['product_name'];
	//  echo  $title_items . "<br />";
	  $the_extra = $rows['property_name'];
	  
	 // tsekaroume an gia kathe item exoume extra ingredient 
	  if ($the_extra != null)
	  {
		$res_extra_price = mysql_query("SELECT extraPrice FROM property WHERE name ='$the_extra'")or die(mysql_error());
		
		 // pairnoume tin timi tou extra ingredient  
		while($rows_extra=mysql_fetch_assoc($res_extra_price)){
	  
			$extra_price = $rows_extra['extraPrice'];
		} 
	  }
	  // pairnoume tin timi tou item 
	  $res_item_prices = mysql_query("SELECT price FROM product WHERE title ='$title_items'")or die(mysql_error());
	  
	  while($rows_prices=mysql_fetch_assoc($res_item_prices)){
	  
		$item_prices = $rows_prices['price'];
		$total_price = $total_price + $item_prices;
	}
	
	// ypologismos telikis timis 
	 $total_price = $total_price + $extra_price;
}

// enimerwsi database gia tin timi kai ton ari8mo tvn items 

$result = mysql_query("UPDATE orders SET price='$total_price', num_items ='$num_items' WHERE id='$order'") or die(mysql_error());

mysql_close($con);
unset($_SESSION['order_id']);
unset($_SESSION['num_items']);

?>