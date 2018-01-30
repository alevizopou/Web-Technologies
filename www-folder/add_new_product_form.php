<?php
session_start();
include("toolbar.php");
echo "<br />";

$username = $_SESSION["username"];
// kwdikas gia elegxo twn dikaiwmatwn prosvasis se ayti tin selida
error_reporting(0);

if($_SESSION['username'] !="manager") 
{
	echo("Δεν έχετε δικαίωμα πρόσβασης σε αυτό το αρχείο.");

	exit;
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css"  href="style.css" />
<style type="text/css">
.myTable { background-color:#e4ebeb;border-collapse:collapse; }
.myTable th { background-color:#a8b9c2;color:black; }
.myTable td, .myTable th { cellpadding:20px; border:2px solid #99CCCC;}
</style>

<script type="text/javascript">
function checkscript(elm)
{
	var counter = 7;
	for (i=0; i<counter; i++)
	{
		if((elm[i].type=="text") )
		{
			var elm_name = elm[i].name;
		 
			if(elm_name.search("title") != -1)
			{
				if(elm[i].value.length==0)
				{
					alert("Δώστε τον τίτλο.");
					return false;
				}
			}
			
			if(elm_name.search("price") != -1)
			{
				if(elm[i].value.length==0)
				{
					alert("Δώστε την τιμή");
					return false;
				}
				
				if (!isNumber ((elm[i].value) ))
				{
					return false;
				}
			}
	    }//type=text/file
	}
	
return true;

}// end checkscript

function isNumber (o) {
  return ! isNaN (o-0) && o !== null && o !== "" && o !== false;
}

</script>

</head>
<body>
<div style="width:30%">
<form  name = "myform" enctype="multipart/form-data"  action="add_new_product_action.php" method="post" onsubmit="return checkscript(this.elements);"  >
<br>&nbsp;<br>
<fieldset><legend> &nbsp;&nbsp; Προσθήκη νέου προϊόντος &nbsp;&nbsp; </legend>
<table class="myTable" style="width:20%">
<?php

$con = mysql_connect("localhost","root","");
if (!$con)
	die('Could not connect: ' . mysql_error());
	
mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$res = mysql_query("SELECT * FROM category") or die(mysql_error());
$cat_menu = mysql_num_rows($res);
	
$repeat = "<tr>
<td>
<label >Τίτλος:</label>
</td>
<td>
<input type=\"text\" name=\"title\" size=\"25\"/>
</td>
<tr />
<tr>
<td>
<label >Περιγραφή (προαιρετικό):</label>
</td>
<td>
<input type=\"text\" name=\"description\" size=\"25\" />
</td>
</tr>
<br />
<tr>
<td>
<label >Τιμή:</label>
</td>
<td>
<input type=\"text\" name=\"price\" size=\"25\" />
</td>
</tr>
<br />
<tr>
<td>
<label>Κατηγορία:</label>
</td>
<td>";
echo $repeat;

echo "<select name=\"category\" > <option value=\"$category\">$category</option>";

while($cat_menu = mysql_fetch_array( $res )) {
	$cat = $cat_menu['title'];

	$repeat2 = "
	<option value=\"$cat\">$cat</option>
	";
	echo $repeat2;
}

echo "</select></td>";

mysql_close($con);

?>
</table>
<p><input id="button" type="submit" value="Submit" align="center" /> </p>
</form>
</div>
</body>
</html>
