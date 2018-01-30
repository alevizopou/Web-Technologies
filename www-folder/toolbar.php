<?php
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
<title> order-system </title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<center> <h2> Ceid Café </h2> 
<h4> Περιβάλλον διαχείρισης </h4>
</center>
<p></p>
<center>
<table>
<tr>
<td> <a href="first.php"> &nbsp; Αρχική &nbsp; </a> </td>
<td> <a href="waiters.php"> &nbsp; Προσωπικό &nbsp; </a> </td>
<td> <a href="menu.php"> &nbsp; Menu &nbsp; </a> </td>
<td> <a href="orders.php"> &nbsp; Παραγγελίες &nbsp; </a> </td>
<td> <a href="logout_manager.php"> &nbsp; Αποσύνδεση &nbsp; </a> </td>
</tr>
</table>
<p></p>

</html>