<?php
session_start();
include("toolbar.php");
echo "<br />";

$username = $_SESSION["username"];

//* Έλεγχος για απαγορευμένη πρόσβαση στη σελίδα */
if (!isset($_SESSION["username"]))
{
	echo '<script>';
		echo 'alert("Δεν έχετε πρόσβαση σε αυτή τη σελίδα!\nΠρέπει πρώτα να συνδεθείτε!");';
		echo 'window.location="manager_login_form.html";';
	echo '</script>';
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
	var counter = 5;
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
			
			if ((elm[i].name.search("price") != -1) && (elm[i].value.length!=0) && (!isNumber(elm[i].value)) )
			{
				return false;
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
<form  name = "myform" enctype="multipart/form-data" action="add_new_extra_action.php" method="post" onsubmit="return checkscript(this.elements);"  >
<br>&nbsp;<br>
<fieldset><legend> &nbsp;&nbsp; Προσθήκη νέου έξτρα προϊόντος &nbsp;&nbsp; </legend>
<table class="myTable" style="width:30%">
<?php
$con = mysql_connect("localhost","root","");
if (!$con)
	die('Could not connect: ' . mysql_error());
	
mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$res = mysql_query("SELECT * FROM product") or die(mysql_error());
$item_menu = mysql_num_rows($res);
	
$repeat = "<tr>
<td>
<label >Τίτλος:</label>
</td>
<td>
<input type=\"text\" name=\"title\" />
</td>
<tr />
<br />
<tr>
<td>
<label >Τιμή:</label>
</td>
<td>
<input type=\"text\" name=\"price\"  />
</td>
</tr>
<br />
<tr>
<td>
<label>Προϊόν:</label>
</td>
<td>";
echo $repeat;

echo "<select name=\"product\" >  <option > </option>";
while($item_menu = mysql_fetch_array( $res )) { 
$it = $item_menu['title'];

$repeat2 = "
<option value=\"$it\">$it</option>
";
echo $repeat2;

}
echo "</select></td>";
mysql_close($con);

?>
</table>
<p><input id="button" type="submit" value="Submit" align="center" /> </p>
</form>

</body>
</html>
