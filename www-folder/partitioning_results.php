<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<?php
session_start();
include("toolbar.php");

$page =$_GET['page'];
$response = $_SESSION['response'];
echo "<br />";
echo "Βρέθηκαν  " . count($response) . " αποτελέσματα." ."<br>";
echo "<br />";
echo "<br />";

$con = mysql_connect("localhost","root","");
if (!$con)
	die('Could not connect: ' . mysql_error());
	
mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

if (isset($_SESSION['response'])) 
{
//print_r($response);

	if(count($response)<10)
	{
		echo "<div>";
		for ($i=0; $i<count($response); $i++)
		{
			echo "<b>Παραγγελία " . ($i + 1 ) . "</b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" ;
			echo "<br />";
			$data2 = mysql_query("SELECT * FROM item_in_order WHERE order_id LIKE'$response[$i]'"); 
			$l=0;
		
			while($result = mysql_fetch_array( $data2 )) 
			{
				if($l==0)
				{
					echo "<i>Ημερομηνία: </i>". $result['order_date'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <i>Σερβιτόρος: </i>" . $result['waiter_name'];
					echo "<br />";
					echo "<i>Προιόν/Προιόντα:</i>";
					echo "<br />";
				}
				// gia na typw8oun ola ta items tis paraggelias (xwris na epanalamvanontai ta parapanw stoixeia)
				echo "- " . $result['product_name'] . " " . $result['property_name'];
				echo "<br />";
				echo "<br />";
			
				$data = mysql_query("SELECT * FROM orders WHERE id LIKE'$response[$i]'"); 
				$result2 = mysql_fetch_array( $data );
			
				$l++;
			}
			
			echo "<i>Συνολική Τιμή: </i>" . $result2['price'] . " euros";
			echo "<br />";
			echo "<br />";
		}
		echo "</div>";
	}//if response<10
	else
	{
		//ypologismos twn selidwn pou tha xreiastoun etsi wste to response na einai 10 images ana page.
		$pages = ceil(count($response)/10);
	
		if($page==1)
		{
			echo "Σελίδα αποτελεσμάτων " . $page . " από " . $pages . "<br>";
			echo "<br />";

			echo "<div >";
			for ($i=0;$i<=9;$i++)
			{
				echo "<b>Παραγγελία " . ($i + 1 ) . "</b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" ;
				echo "<br />";
				$data2 = mysql_query("SELECT * FROM item_in_order WHERE order_id LIKE'$response[$i]'"); 
				$l=0;
			
				while($result = mysql_fetch_array( $data2 ))
				{
					if($l==0)
					{
						echo "<i>Ημερομηνία: </i>". $result['order_date'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <i>Σερβιτόρος: </i>" . $result['waiter_name'];
						echo "<br />";
						echo "<i>Προιόν/Προιόντα:</i>";
						echo "<br />";	
					}
					
					echo "- " . $result['product_name'] . " " . $result['property_name'];
					echo "<br />";
					echo "<br />";
					$data = mysql_query("SELECT * FROM orders WHERE id LIKE'$response[$i]'"); 
					$result2 = mysql_fetch_array( $data );
				
					$l++;
				}
				
				echo "<i>Συνολική Τιμή: </i>" . $result2['price'] . " euros";
				echo "<br />";
				echo "<br />";
			}
			$page++;
		
			echo "<p style=\"text-align:center;\"><a href=\"partitioning_results.php?page=$page\"> Next Page </a></p>";
			echo "</div>";
		}
		else
		{
			if($page<$pages)
			{
				echo "Σελίδα αποτελεσμάτων " . $page . " από " . $pages . "<br>";
				echo "<br />";

				$start=($page-1)*10;
				$end=(($page-1)*10)+9;
				echo "<div >";
			
				for ($i=$start;$i<=$end;$i++)
				{
					echo "<b>Παραγγελία " . ($i + 1 ) . "</b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" ;
					echo "<br />";
					$data2 = mysql_query("SELECT * FROM item_in_order WHERE order_id LIKE'$response[$i]'"); 
					$l=0;
					while($result = mysql_fetch_array( $data2 )) 
					{
						if($l==0)
						{
							echo "<i>Ημερομηνία: </i>". $result['order_date'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <i>Σερβιτόρος: </i>" . $result['waiter_name'];
							echo "<br />";
							echo "<i>Προιόν/Προιόντα:</i>";
							echo "<br />";
						}
						
						echo "- " . $result['product_name'] . " " . $result['property_name'];
						echo "<br />";
						echo "<br />";
					
						$data = mysql_query("SELECT * FROM orders WHERE id LIKE'$response[$i]'"); 
						$result2 = mysql_fetch_array( $data );
					
						$l++;
					}
					
					echo "<i>Συνολική Τιμή: </i>" . $result2['price'] . " euros";
					echo "<br />";
					echo "<br />";
				}
				echo "</div>";
			
				$page++;
				echo "<p style=\"text-align:center;\"><a href=\"partitioning_results.php?page=$page\"> Next Page </a></p>";
			}
			else if($page == $pages)
			{
				echo "Σελίδα αποτελεσμάτων " . $page . " από " . $pages . "<br>";
				echo "<br />";
				$results_shown = ($page-1)*10;
				$results_remain = count($response)-$results_shown;
				$end = count($response)-1;
				$start = count($response)- $results_remain;
				echo "<div >";
			
				for ($i=$start;$i<=$end;$i++)
				{
					echo "<b>Παραγγελία " . ($i + 1 ) . "</b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" ;
					echo "<br />";
					$data2 = mysql_query("SELECT * FROM item_in_order WHERE order_id LIKE'$response[$i]'"); 
					$l=0;
				
					while($result = mysql_fetch_array( $data2 )) 
					{
						if($l==0)
						{
							echo "<i>Ημερομηνία: </i>". $result['order_date'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <i>Σερβιτόρος: </i>" . $result['waiter_name'];
							echo "<br />";
							echo "<i>Προιόν/Προιόντα:</i>";
							echo "<br />";
						}
						
						echo "- " . $result['product_name'] . " " . $result['property_name'];
						echo "<br />";
						echo "<br />";
						$data = mysql_query("SELECT * FROM orders WHERE id LIKE'$response[$i]'"); 
						$result2 = mysql_fetch_array( $data );
					
						$l++;
					}
					
					echo "<i>Συνολική Τιμή: </i>" . $result2['price'] . " euros";
					echo "<br />";
					echo "</div>";
				}
			}
		}//end of else
	}

	// download xml file
	echo "<p>Εξαγωγή xml αρχείου: Πατήστε <a href='generate_xml.php'>ΕΔΩ</a> για download.</br>";
}//end of isset

?>
</html>