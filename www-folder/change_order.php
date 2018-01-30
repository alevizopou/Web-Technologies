
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="change_order_style.css" />

<script type="text/javascript">

function delete_item(tid)
{
	
	// pairnei to id tou item pou prepei na diagraftei
	var a = tid.split("_");
	var nm = document.getElementById(a[1]).value;
	alert(nm);
	
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
		window.location.reload();
		var s = xmlhttp.responseText;
		//alert(s);
    }
	}
	//apostoli tou id tou order pou prepei na diagraftei to item sto arxeio delete_item.php
	
	var url= "delete_item.php?u=" + nm;
	xmlhttp.open("GET",url,true);
	xmlhttp.send();

}

</script>

</head>
<body>
<div id="wrapper">
<a href="mobile_menu.php"> &nbsp; Αρχικό menu &nbsp; </a>
<h3> Παραγγελίες </h3>

<table class="myTable" >
<?php 

session_start();
$username = $_SESSION['username'];
$con = mysql_connect("localhost","root","");

if (!$con)
	die('Could not connect: ' . mysql_error());
	
mysql_set_charset('utf8',$con);
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$j=0;

$result1 = mysql_query("SELECT * FROM orders")or die(mysql_error());
$num_of_orders = mysql_num_rows($result1);

echo "<tr>
<th>Κωδικός<br>παραγγελίας</th>
<th>Προϊόν</th>
<th>Έξτρα<br>προϊόν/ιδιότητα</th>
<th>Αλλαγή</th>
<th>Διαγραφή</th>
</tr>";
while ($rowz = mysql_fetch_array($result1)) {
$j++;

echo "<tr><th COLSPAN=5> Order no." . $j . "</ th></tr>";

$id = $rowz['id'];
$i=0;
$result = mysql_query("SELECT * FROM item_in_order WHERE order_id='$id'")or die(mysql_error());

	while ($row = mysql_fetch_array($result)) {
		$forma = "<form name = \"myform\" enctype=\"multipart/form-data\"  action=\"change_order_action.php\" method=\"post\" \" >";

		echo $forma;
		$num_id = $row['id'];
		$item = $row['product_name'];
		$extra = $row['property_name'];
		$tid="t_".$num_id;
		
		$repeat = "
		<tr>
		<td>
		<input type=\"hidden\" name=\"order_id\" value=\"$id\" />
		<label>$id</label>
		</td>
		<td>
		<input type=\"hidden\" name=\"id\" id=\"$num_id\" value=\"$num_id\" />
		<label>$item</label>
		<input type=\"hidden\" name=\"item\" value=\"$item\" />
		</td>
		<td>
		<label>$extra</label>
		<input type=\"hidden\" name=\"extra\" value=\"$extra\" />
		</td>
		<td>
		<input type=\"submit\" class=\"butt\" name=\"submit\" value=\"Προσθήκη\" align=\"center\"/>
		</td>
		<td>
		<button type=\"button\" class=\"butt\" name =$tid  onclick=\"delete_item(this.name);\">Διαγραφή</button>
		</td>
		</tr>
		</form>
		";
		$i++;
		echo $repeat;
	}	
}

mysql_close($con);
?>
</table>
</div>
</body>
</html>