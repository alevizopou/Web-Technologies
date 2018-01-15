<?php

session_start();
include("toolbar.php");
echo "<br />";

$username = $_SESSION["username"];

/* Έλεγχος για απαγορευμένη πρόσβαση στη σελίδα */
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
.myTable td, .myTable th { cellpadding:10px; border:2px solid #99CCCC; }
</style>

<script type="text/javascript">
function checkscript(elm)
{
	var counter = 4;
	for (i=0; i<counter; i++)
	{
		if((elm[i].type=="text")  )
		{
		  var elm_name = elm[i].name;
		 
		  if(elm_name.search("title") != -1)
			{
				if(elm[i].value.length==0)
				{
					alert("Εισάγετε το όνομα της κατηγορίας που θέλετε να δημιουργηθεί.");
					return false;
				}
			}
	    }//type=text/file
	}
	
return true;

}// end checkscript

</script>

</head>
<body>
<div style="width:30%">
<form  name = "myform" enctype="multipart/form-data"  action="add_category_action.php" method="post" onsubmit="return checkscript(this.elements);"  >
<br>&nbsp;<br>
<fieldset><legend> &nbsp;&nbsp; Προσθήκη νέας κατηγορίας &nbsp;&nbsp; </legend>
<table class="myTable" style="width:60%">
<?php

$repeat = "<tr>
<td>
<label>Όνομα νέας κατηγορίας:</label>
</td>
<td>
<input type=\"text\" name=\"title\" />
</td>
<tr />
<br />

";
echo $repeat;
?>

</table>
<p><input id="button" type="submit" value="Submit" align="center" /> </p>
</form>


