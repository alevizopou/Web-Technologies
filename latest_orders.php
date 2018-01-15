<?php
//arxeio ypeythyno na vrei apo tin vasi poies einai oi 5 pio prosfates paraggelies 
//kai na steilei tin apantisi ston ajax kwdika tou first page
$con = mysql_connect("localhost","root","");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$j=0;

$result = mysql_query("SELECT * FROM orders ORDER BY order_id DESC LIMIT 5") or die(mysql_error());
$rows = mysql_num_rows($result);

while ($db_field = mysql_fetch_assoc($result)) 
{
	$latest_id[] = $db_field['id'];
	$latest_waiter[] = $db_field['waiter_name'];
	$latest_date[] = $db_field['the_date'];
	$latest_price[] = $db_field['price'];
	$latest_num_items[]= $db_field['num_items'];
	
	$idd = $db_field['id'];
	$data2 = mysql_query("SELECT * FROM item_in_order WHERE order_id LIKE '$idd'"); 
	
	while($result2 = mysql_fetch_array( $data2 )) {
	
		$latest_items[] = $result2['product_name'];
		
		if($result2['property_name'] == "NULL")
		{
			$latest_extras[] = " ";
		}
		else
		{
			$latest_extras[] = $result2['property_name'];
		}
	}
}

$path="";
if ($rows<5)
{
	for($i=0;$i<$rows;$i++)
	{
		if ($i==0)
		{
			$path = $latest_date[$i]  . "," . $latest_waiter[$i]  . "," . $latest_num_items[$i] . ",";
			
			for ($j=0; $j<$latest_num_items[$i]; $j++)
			{
				$path = $path . $latest_items[$j] . " " . $latest_extras[$j] . ",";
			}
			$path = $path . $latest_price[$i]. ",";
		}
		else if ($i==$rows-1)
		{
			$path = $path . $latest_date[$i]  . "," . $latest_waiter[$i]  . "," . $latest_num_items[$i] . ",";
			$counter=0;
			do{
				$counter++;
				$path = $path . $latest_items[$j] . " " . $latest_extras[$j] . ",";
				$j++;
			}while($counter<$latest_num_items[$i]);
			$path = $path . $latest_price[$i];
		}
		else
		{
			$path = $path . $latest_date[$i]  . "," . $latest_waiter[$i]  . "," . $latest_num_items[$i] . ",";
		
			$counter=0;
			do{
				$counter++;
				$path = $path . $latest_items[$j] . " " . $latest_extras[$j] . ",";
				$j++;
			}while($counter<$latest_num_items[$i]);
			
			$path = $path . $latest_price[$i]. ",";
		}
	}
}
else
{
	for($i=0;$i<5;$i++)
	{
		if ($i==0)
		{
			$path = $latest_date[$i]  . "," . $latest_waiter[$i]  . "," . $latest_num_items[$i] . ",";
			for ($j=0; $j<$latest_num_items[$i]; $j++)
			{
				$path = $path . $latest_items[$j] . " " . $latest_extras[$j] . ",";	 
			}
			$path = $path . $latest_price[$i]. ",";
		}
		else if ($i==4)
		{
			$path = $path . $latest_date[$i]  . "," . $latest_waiter[$i]  . "," . $latest_num_items[$i] . ",";
			$counter = 0;
			do{
				$counter++;
				$path = $path . $latest_items[$j] . " " . $latest_extras[$j] . ",";
				$j++;
			}while($counter<$latest_num_items[$i]);
			$path = $path . $latest_price[$i];
		}
		else
		{
			$path = $path . $latest_date[$i]  . "," . $latest_waiter[$i]  . "," . $latest_num_items[$i] . ",";

			$counter = 0;
			do{
				$counter++;
				$path = $path . $latest_items[$j] . " " . $latest_extras[$j] . ",";
				$j++;
			}while($counter<$latest_num_items[$i]);
			
			$path = $path . $latest_price[$i]. ",";
		}
	}
}

mysql_close($con);

echo $path;

?>