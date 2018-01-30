<?php
session_start();
$username = $_SESSION['username'];
$category = $_POST['catt'];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css"  href="order_style.css" />
<script type="text/javascript">

function add_item(elem)
{
	var j=0;
	var product;
	var extra;
	var k=0;
	var i=0;
	
	for(var j=0;j<elem.length;j++)
	{
		/* check how many products were chosen */
		if((elem[j].name.search("products") != -1) && (elem[j].checked==true))
		{
			k = k + 1;
			product = elem[j].value;
		}
		
		/* check how many extras were chosen */
		if((elem[j].name.search("extras") != -1) && (elem[j].checked==true))
		{
			i = i + 1;
			extra = elem[j].value;
		}
	}
	
	/* case the products chosen are 0 */
	if(k==0)
	{
		alert("Πρέπει να επιλέξετε προιόν.");
		return false;
	}
	/* case the products more than 1 */
	if(k>1)
	{
		alert("Πρέπει να επιλέξετε 1 προιόν.");
		return false;
	}
	/* case the extras more than 1 */
	if(i>1)
	{
		alert("Πρέπει να επιλέξετε 1 μόνο επιπλέον υλικό.");
		return false;
	}
	return true;

}

</script>
</head>
<body>
<div id="wrapper">
<h3> Προϊόντα </h3>
<ul class="the_list">
	
<?php
	
	$con = mysql_connect("localhost","root","");
	if (!$con)
		die('Could not connect: ' . mysql_error());
	
	mysql_set_charset('utf8',$con);  
	mysql_select_db("my_db", $con);
	mysql_query("SET NAMES 'utf8'", $con);
	
	// selected category's products
	$result_items = mysql_query("SELECT * FROM product WHERE in_category='$category' ORDER BY popularity DESC") or die(mysql_error());
	$rows_items = mysql_num_rows($result_items);
	
	// selected category's extras
	$result_extras = mysql_query("SELECT * FROM property WHERE into_category='$category'") or die(mysql_error());
	$rows_extras = mysql_num_rows($result_extras);
	
	$i = 0;	
	$j = 0;
	
	$forma = "<form name = \"item_in_order_form\" enctype=\"multipart/form-data\" action=\"order_action.php\" method=\"post\" onsubmit=\"return add_item(this.elements);\" >";
	echo $forma;
	
	// products (title)
	while($row_items = mysql_fetch_array( $result_items )) 
	{
		$product = $row_items['title'];
		$repeat = "
		<li><input type=\"checkbox\" name=\"products\" value=\"$product\" id=\"$product\">$product</li>";
		$i++;
		echo $repeat;
	}
	$end_list="</ul>";
	echo $end_list;
	
	echo "<h3> Έξτρα προϊόντα/ιδιότητες </h3>";
	
	$new_list = "<ul class=\"the_list\">";
	echo $new_list;
	
	// extras (name)
	while($row_extras = mysql_fetch_array( $result_extras )) 
	{
		$extra = $row_extras['name'];
		$repeat = "
		<li><input type=\"checkbox\" name=\"extras\" value=\"$extra\" id=\"$extra\">$extra</li>";
		$j++;
		echo $repeat;
	}
	echo $end_list;
	
	$add_item_name = $i."_".$j;
	$button_add_item = "<button type=\"submit\" class=\"butt\" name =\"submit\"> Προσθήκη </button>";
	echo $button_add_item;
	echo "<br />";
	$end_form = "</form>";
	echo $end_form;
	
	mysql_close($con);
?>

</div>
<body>
</html>


