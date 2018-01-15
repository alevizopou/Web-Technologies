<?php
	/* Έλεγχος για απαγορευμένη πρόσβαση στη σελίδα */
	if (!isset($_SESSION["username"]))
	{
		echo '<script>';
			echo 'alert("Δεν έχετε πρόσβαση σε αυτή τη σελίδα!\nΠρέπει πρώτα να συνδεθείτε!");';
			echo 'window.location="waiter_login_form.php";';
		echo '</script>';
	}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title> order-system </title>
<link rel="stylesheet" href="menu_style.css">
 <style>
	
fieldset {
    border: 0;
	background-color:#f2fbfb
}

</style>
</head>
<body>
<center> <h2> Ceid Café </h2> </center>
<h4> Περιβάλλον Παραγγελιών </h4>
<p></p>
<center>

<div id="wrapper">
<fieldset id="field" >
<table>
<tr>
<td> <a href="new_order.php"> &nbsp; Νέα παραγγελία &nbsp; </a> </td>
</tr>

<tr>
<td> <a href="change_order.php"> &nbsp; Αλλαγή παραγγελίας &nbsp; </a> </td>
</tr>
<tr>
<td> <a href="waiter_logout.php"> &nbsp; Αποσύνδεση &nbsp; </a> </td>
</tr>

</table>
</fieldset>
</div>

<p></p>

</html>