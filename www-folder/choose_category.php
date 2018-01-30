<?php
session_start();
$username = $_SESSION['username'];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="order_style.css" />
<script type="text/javascript">

function check(elem)
{
	var j=0;
	var category;
	var k=0;
	
	for(var j=0; j<elem.length; j++)
	{
		if((elem[j].name.search("catt") != -1) && (elem[j].checked==true))
		{
			k = k + 1;
			category = elem[j].id;
		}
	}
	
	if(k==0)
	{
		alert("Πρέπει να επιλέξετε κατηγορία.");
		return false;
	}
	if(k>1)
	{
		alert("Πρέπει να επιλέξετε 1 κατηγορία.");
		return false;
	}
	//alert(category);
	
	return true;
}

function end_order()
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			window.location.href = "mobile_menu.php";
			//alert("ok");
		}
	}
	
	var url= "end_order.php";
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
}

</script>

</head>
<body>
<div id="wrapper">
<h3> Επιλέξτε κατηγορία </h3>
<form name = "categories_form" enctype="multipart/form-data" action="order_form.php" method="post" onsubmit="return check(this.elements);" >
<ul class="the_list">
	
<?php
	$con = mysql_connect("localhost","root","");
	if (!$con)
		die('Could not connect: ' . mysql_error());
	
	mysql_set_charset('utf8',$con);  
	mysql_select_db("my_db", $con);
	mysql_query("SET NAMES 'utf8'", $con);
	
	$result_items = mysql_query("SELECT * FROM category") or die(mysql_error());
	$rows = mysql_num_rows($result_items);
	
	if($rows == 0)
	{
		echo "Δεν υπάρχουν κατηγορίες.<br />";
		include("mobile_menu.php");
	}
	
	$i=0;	
	
	// category list
	while($row_items = mysql_fetch_array( $result_items )) 
	{
		$cat = $row_items['title'];
		$repeat = "
		<li><input type=\"checkbox\" name=\"catt\" value=\"$cat\" id=\"$cat\">$cat</li>";
		$i++;
		echo $repeat;
	}
	$end_list="</ul>";
	echo $end_list;
	
	$button_add_item = "<button type=\"submit\" class=\"butt\" name =\"submit\" > Επιλογή </button>";
	echo $button_add_item;
	echo "<br>&nbsp;<br>";
	$button_end_order = "<button type=\"button\" class=\"butt\" name =\"end\" onclick=\"end_order();\">Τερματισμός <br>Παραγγελίας</button>";
	echo $button_end_order;

	$end_form = "</form>";
	echo $end_form;
	
	mysql_close($con);
?>

</div>
<body>
</html>
