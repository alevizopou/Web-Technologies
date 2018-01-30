<?php

session_start();
$username = $_SESSION['username'];

/* Έλεγχος για απαγορευμένη πρόσβαση στη σελίδα */
if (!isset($_SESSION["username"]))
{
	echo '<script>';
		echo 'alert("Δεν έχετε πρόσβαση σε αυτή τη σελίδα!\nΠρέπει πρώτα να συνδεθείτε!");';
		echo 'window.location="manager_login_form.html";';
	echo '</script>';
}

include("toolbar.php");

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
.myTable { background-color:#e4ebeb;border-collapse:collapse; }
.myTable th { background-color:#a8b9c2;color:black; }
.myTable td, .myTable th { cellpadding:10px; border:1px solid #99CCCC;}
</style>
<script type="text/javascript">

function check(elm)
{
	var j=0;
	for(var j=0;j<elm.length;j++)
	{
		if((elm[j].type == "text") && (elm[j].value.length==0) && (elm[j].name.search("description") == -1) )
		{
			alert("Λείπουν στοιχεία!");
			return false;
		}
		
		if ((elm[j].name.search("price") != -1) && (!isNumber ((elm[j].value) ) ))
		{
			return false;
		}
	}
	
	return true;
}

function isNumber (o) {
  return ! isNaN (o-0) && o !== null && o !== "" && o !== false;
}

function delete_item(tid)
{
	// pairnei to title tou item pou prepei na diagraftei
	
	var a = tid.split("_");
	var nm = a[1];
	
	var xmlhttp;

	if (window.XMLHttpRequest)
	{	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{	// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			window.location.reload();
			//alert(xmlhttp.responseText);
		}
	}
	//apostoli tou title tou item pou prepei na diagraftei sto arxeio delete_products_from_menu.php
	var url= "delete_products_from_menu.php?u=" + nm;
	xmlhttp.open("GET",url,true);
	xmlhttp.send();

}

</script>
</head>
<body>
<br>&nbsp;<br>
<p>Για προσθήκη καινούριου προϊόντος πατήστε <a href='add_new_product_form.php'>&nbsp; εδώ &nbsp;</a></p></br>
<div style="width:60%" >
<fieldset><legend> &nbsp; &nbsp; Λίστα Προϊόντων &nbsp; &nbsp; </legend>
<br>&nbsp;<br>

<table class="myTable" width="80%">
<tr>
<th>Τίτλος</th>
<th>Περιγραφή</th>
<th>Τιμή</th>
<th>Κατηγορία</th>
<th>Αλλαγή</th>
<th>Διαγραφή</th>
</tr>

<?php
$con = mysql_connect("localhost","root","");

if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$result = mysql_query("SELECT * FROM product") or die(mysql_error());
$rows = mysql_num_rows($result);

$i=0;	
$forma = "<form name = \"myform\" enctype=\"multipart/form-data\"  action=\"change_products.php\" method=\"post\" onsubmit=\"return check(this.elements);\" >";

while($row = mysql_fetch_array( $result )) 
{	
	$title = $row['title'];
	$description = $row['description'];
	$price = $row['price'];
	$category = $row['in_category'];
	
	$res = mysql_query("SELECT * FROM category") or die(mysql_error());
	$cat_menu = mysql_num_rows($res);

	echo $forma;

	$tid="t_".$title;
	//echo $tid . "</ br>";

	$repeat = "
	<tr>
	<td>
	<label>$title <label />
	<input type=\"hidden\" name=\"title\"  value=\"$title\" />
	</td>
	<td>
	<input type=\"text\" name=\"description\" value=\"$description\" size=\"25\" />
	</td>
	<td>
	<input type=\"text\" name=\"price\" value=\"$price\" size=\"3\" />
	</td>
	<td>";
	echo $repeat;
	echo "<select name=\"mydropdown\" > <option value=\"$category\">$category</option>";

	while($cat_menu = mysql_fetch_array( $res )) {
		$cat = $cat_menu['title'];

		$repeat2 = "
		<option value=\"$cat\">$cat</option>
		";
		echo $repeat2;
	}

	echo "</select></td>";

	$repeat3 = "<td>
	<input type=\"submit\" name=\"submit\" value=\"submit!\" align=\"center\" />
	</td>
	<td>
	<button type=\"button\" name =\"$tid\" onclick=\"delete_item(this.name);\">Delete</button>
	</td>
	</tr>

	</form>

	";
	echo $repeat3;
	$i++;
}

mysql_close($con);
?>

<div id="myDiv"></div>
</table>
<br>&nbsp;<br>
</body>
</html>