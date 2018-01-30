<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<?php 
 session_start();
$date = $_POST['date'];
$waiter = $_POST['waiter_name'];
$price = $_POST['price'];
$product = $_POST['product'];

$con = mysql_connect("localhost","root","");
if (!$con)
	die('Could not connect: ' . mysql_error());
	
mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$k = 0;
$j = 0;
$counter = 0;
$final_orders = array();

// anazitisi vasi date
if( ($date!=0) && ($waiter=="") && ($price==0) && ($product==""))
{
	$data = mysql_query("SELECT * FROM orders WHERE the_date LIKE '$date'") or die(mysql_error()); 
	$anymatches = mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$final_orders[$k] = $result['id']; 
			$k++;
		}
	}
}

// anazitisi vasi waiter username
if( ($date==0) && ($waiter != "") && ($price==0) && ($product==""))
{
	$data = mysql_query("SELECT * FROM orders WHERE waiter_name LIKE '$waiter'"); 
	$anymatches = mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$final_orders[$k] = $result['id']; 
			$k++;
		}
	}
}

// anazitisi vasi price
if( ($date==0) && ($waiter == "") && ($price!=0) && ($product==""))
{
	$data = mysql_query("SELECT * FROM orders WHERE price LIKE '$price'"); 
	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$final_orders[$k] = $result['id']; 
			$k++;
		}
	}
}

// anazitisi vasi product
if( ($date==0) && ($waiter == "") && ($price==0) && ($product!=""))
{
	$data = mysql_query("SELECT * FROM item_in_order WHERE product_name LIKE'$product'"); 
	$anymatches=mysql_num_rows($data); 
	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{
			$final_orders[$k] = $result['order_id']; 
			$k++;
		}
	}
}

// anazitisi ana 2ades 
// date - waiter
if( ($date!=0) && ($waiter != "") && ($price==0) && ($product==""))
{
	$data = mysql_query("SELECT * FROM orders WHERE the_date LIKE '$date' AND waiter_name LIKE '$waiter'"); 
	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$final_orders[$k] = $result['id']; 
			$k++;
		}
	}
}

//date - price
if( ($date!=0) && ($waiter == "") && ($price!=0) && ($product==""))
{
	$data = mysql_query("SELECT * FROM orders WHERE the_date LIKE '$date' AND price LIKE '$price'"); 
	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$final_orders[$k] = $result['id']; 
			$k++;
		}
	}
}

//date - product
if( ($date!=0) && ($waiter == "") && ($price==0) && ($product!=""))
{
	$data = mysql_query("SELECT * FROM item_in_order WHERE order_date LIKE '$date' AND product_name LIKE '$product'"); 
	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$flagg = 0;
			//psaxnoume mipws exoume apothikeysei pali to idio order_id
			for($j=0;$j<$k;$j++)
			{
				if($result['order_id'] == $final_orders[$j])
				{
					$flagg = 1;
				}
			}
			
			if($flagg == 0)
			{
				$final_orders[$k] = $result['order_id']; 
				$k++;
			}
		}
	}
}

//waiter - price
if( ($date==0) && ($waiter != "") && ($price!=0) && ($product==""))
{
	$data = mysql_query("SELECT * FROM orders WHERE waiter_name LIKE '$waiter' AND price LIKE '$price'"); 
	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{	 
			$final_orders[$k] = $result['id']; 
			$k++;
		}
	}
}

//waiter - product
if( ($date==0) && ($waiter != "") && ($price==0) && ($product!=""))
{
	$data = mysql_query("SELECT * FROM item_in_order WHERE waiter_name LIKE '$waiter' AND product_name LIKE '$product'"); 
	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$flagg = 0;
			//psaxnoume mipws exoume apothikeysei pali to idio order_id
			for($j=0; $j<$k; $j++)
			{
				if($result['order_id'] == $final_orders[$j])
				{
					$flagg = 1;
				}
			}
			
			if($flagg == 0)
			{
				$final_orders[$k] = $result['order_id']; 
				$k++;
			}
		}
	}
}

// price -product
if( ($date==0) && ($waiter == "") && ($price!=0) && ($product!=""))
{
	$data = mysql_query("SELECT orders.id
	FROM orders JOIN item_in_order ON orders.id = item_in_order.order_id  
	WHERE orders.price LIKE '$price' AND item_in_order.product_name LIKE '$product'"); 

	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{
			$flagg = 0;
			//psaxnoume mipws exoume apothikeysei pali to idio order_id
			for($j=0; $j<$k; $j++)
			{
				if($result['id'] == $final_orders[$j])
				{
					$flagg = 1;
				}
			}
			
			if($flagg == 0)
			{
				$final_orders[$k] = $result['id']; 
				$k++;
			}
		}
	}
}

//anazitisi ana 3ades
//date - waiter - price
if( ($date!=0) && ($waiter != "") && ($price!=0) && ($product==""))
{
	$data = mysql_query("SELECT * FROM orders WHERE waiter_name LIKE '$waiter' AND price LIKE '$price' AND the_date LIKE '$date'"); 
	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$final_orders[$k] = $result['id']; 
			$k++;
		}
	}
}

//date - waiter - product
if( ($date!=0) && ($waiter != "") && ($price==0) && ($product!=""))
{
	$data = mysql_query("SELECT orders.id
	FROM orders JOIN item_in_order ON orders.id = item_in_order.order_id  
	WHERE orders.waiter_name LIKE '$waiter' AND item_in_order.product_name LIKE '$product' AND orders.the_date LIKE '$date'"); 

	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$flagg = 0;
			//psaxnoume mipws exoume apothikeysei pali to idio order_id
			for($j=0; $j<$k; $j++)
			{
				if($result['id'] == $final_orders[$j])
				{
					$flagg = 1;
				}
			}
			
			if($flagg == 0)
			{
				$final_orders[$k] = $result['id']; 
				$k++;
			}
		}
	}
}

// date - price - product
if( ($date!=0) && ($waiter == "") && ($price!=0) && ($product!=""))
{
	$data = mysql_query("SELECT orders.id
	FROM orders JOIN item_in_order ON orders.id = item_in_order.order_id  
	WHERE orders.price LIKE '$price' AND item_in_order.product_name LIKE '$product' AND orders.the_date LIKE '$date'"); 

	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$flagg = 0;
			//psaxnoume mipws exoume apothikeysei pali to idio order_id
			for($j=0;$j<$k;$j++)
			{
				if($result['id'] == $final_orders[$j])
				{
					$flagg = 1;
				}
			}
			
			if($flagg == 0)
			{
				$final_orders[$k] = $result['id']; 
				$k++;
			}
		}
	}
}

// waiter - price - product
if( ($date==0) && ($waiter != "") && ($price!=0) && ($product!=""))
{
	$data = mysql_query("SELECT orders.id
	FROM orders JOIN item_in_order ON orders.id = item_in_order.order_id  
	WHERE orders.price LIKE '$price' AND item_in_order.product_name LIKE '$product' AND orders.waiter_name LIKE '$waiter'"); 

	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$flagg = 0;
			//psaxnoume mipws exoume apothikeysei pali to idio order_id
			for($j=0;$j<$k;$j++)
			{
				if($result['id'] == $final_orders[$j])
				{
					$flagg = 1;
				}
			}
			
			if($flagg == 0)
			{
				$final_orders[$k] = $result['id']; 
			$k++;
			}
		}
	}
}
//i monadiki 4ada
//date - waiter - price - product
if( ($date!=0) && ($waiter != "") && ($price!=0) && ($product!=""))
{
	$data = mysql_query("SELECT orders.id
	FROM orders JOIN item_in_order ON orders.id =  item_in_order.order_id  
	WHERE orders.price LIKE '$price' AND item_in_order.product_name LIKE '$product' AND orders.waiter_name LIKE '$waiter' AND orders.the_date LIKE '$date'"); 

	$anymatches=mysql_num_rows($data); 

	if($anymatches!=0)
	{
		while($result = mysql_fetch_array( $data )) 
		{ 
			$flagg = 0;
			//psaxnoume mipws exoume apothikeysei pali to idio order_id
			for($j=0;$j<$k;$j++)
			{
				if($result['id'] == $final_orders[$j])
				{
					$flagg = 1;
				}
			}
			
			if($flagg == 0)
			{
				$final_orders[$k] = $result['id']; 
			$k++;
			}
		}
	}
}

//-----------------------------
if (count($final_orders)==0)
{
	echo " Δεν βρέθηκαν αποτελέσματα.  ";
	mysql_close($con);
	exit;
} 

mysql_close($con);
//kanw session olo ton pinaka me ta apotelesmata gia na ton xrisimopoiisei to partitioning_results.php pou selidopoiei ta dedomena
$_SESSION['response'] = $final_orders;
//print_r($response);
header("Location: partitioning_results.php?page=1");

 ?>
 </html>