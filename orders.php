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
.myTable td, .myTable th { cellpadding:20px; border:2px solid #99CCCC;}
</style>

<script type="text/javascript">
//elegxos an to input text tis anazitisis einai empty	
function check_search(elm)
{
	var flag = 0;
	
	for (i=0; i<elm.length; i++)
	{
		if((elm[i].type=="text" || elm[i].type=="date") && elm[i].value.length==0)
		{
				flag ++;
		}
	}
	
	if(flag == 4)
	{
		alert("Συμπληρώστε ένα πεδίο.");
		return false;
	}

	for (i=0; i<elm.length; i++)
	{
			if ((elm[i].name.search("date") != -1) && (elm[i].value.length != 0))
			{
				var boo = checkdate(elm[i]);
				if(boo == false){
					return false;
				}
			}
			
			if ((elm[i].name.search("price") != -1) && (!isNumber(elm[i].value)) )
			{
				return false;
			}
	}
	
	return true;
}

function isNumber (o) {
  return ! isNaN (o-0) && o !== null && o !== " " && o !== false;
}
	
</script>

</head>

<body>
<div style="width:30%" >
<br>&nbsp;<br>
<fieldset id = "search">
<br>&nbsp;<br>
<legend> &nbsp; &nbsp; Αναζήτηση &nbsp; &nbsp; </legend>
<form action="get_res_from_search.php?" method="post" onsubmit="return check_search(this.elements);">
<table class="myTable">
<tr>
<em>Κάνετε αναζήτηση με έστω έναν από τους παρακάτω τρόπους.</em>
<br>&nbsp;<br>
</tr>
<tr>
<td>
<label >Ημερομηνία: </label>
</td>
<td>
<input type="date" id="date" name ="date" />
</td>
</tr>
<tr>
<td>
<label >Username σερβιτόρου: </label>
</td>
<td>
<input type="text" id="waiter_name" name ="waiter_name"  />
</td>
</tr>
<tr>
<td>
<label >Τιμή: </label>
</td>
<td>
<input type="text" id="price" name ="price"  />
</td>
</tr>
<tr>
<td>
<label >Προιόν: </label>
</td>
<td>
<input type="text" id="product" name ="product"  />
</td>
</tr>
</table>

<p><input id="button" type="submit" value="Αναζήτηση" align="center" /> </p>

</form>
</fieldset>
</body>
</html>