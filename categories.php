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
.myTable td, .myTable th { cellpadding:10px; border:2px solid #99CCCC;}
</style>

<script type="text/javascript">

function check(elm)
{
	var j=0;
	for(var j=0;j<elm.length;j++)
	{
		if((elm[j].type == "text") && (elm[j].value.length==0) )
		{
			alert("Λείπουν στοιχεία!");
			
			return false;
		}
	}
	
	return true;

}

function delete_category(tid)
{
	// pairnei to id tis katigorias pou prepei na diagraftei
	var a = tid.split("_");
	var nm = a[1];
	
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
		//alert(xmlhttp.responseText);
    }
	}
	//apostoli tou id tou category pou prepei na diagraftei sto arxeio delete_category.php
	var url= "delete_category.php?u=" + nm;
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
}

</script>

</head>
<body>
<br>&nbsp;<br>
<p>Για δημιουργία καινούριας κατηγορίας πατήστε <a href='add_category.php'>&nbsp; εδώ &nbsp;</a></p></br>
<div style="width:30%" >
<fieldset><legend> &nbsp; &nbsp; Υπάρχουσες Κατηγορίες &nbsp; &nbsp; </legend>
<br>&nbsp;<br>

<table class="myTable" width="80%">
<tr>
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
	
	$result = mysql_query("SELECT * FROM category") or die(mysql_error());
	$rows = mysql_num_rows($result);
	$i = 0;	
	$forma = "<form name = \"myform\" enctype=\"multipart/form-data\" action=\"change_categories.php\" method=\"post\" onsubmit=\"return check(this.elements);\" >";

while($row = mysql_fetch_array( $result )) 
{
	$onoma = $row['title'];
	$id = $row['category_id'];

	echo $forma;

	$tid="t_".$id;

	$repeat = "
	<tr>
	<td>
	<input type=\"hidden\" name=\"id\"  value=\"$id\" />
	<input type=\"text\" name=\"onoma\"  value=\"$onoma\" />
	</td>
	<td>
	<input type=\"submit\" name=\"submit\" value=\"submit!\" align=\"center\" />
	</td>
	<td>
	<button type=\"button\" name =$tid onclick=\"delete_category(this.name);\">Delete</button>
	</td>
	</tr>

	</form>

	";

	$i++;
	echo $repeat;
}

mysql_close($con);
?>

<div id="myDiv"></div>
</table>
<br>&nbsp;<br>

</body>
</html>