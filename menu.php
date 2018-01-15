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
</head>
<body>

<div style="width:30%" >
<br>&nbsp;<br>
<fieldset><legend> &nbsp; &nbsp; Menu &nbsp; &nbsp; </legend>
<p>Κατάλογος με τις  <a href='categories.php'>&nbsp; κατηγορίες &nbsp;</a></br>

<p>Κατάλογος με τα  <a href='products.php'>&nbsp; προιόντα &nbsp;</a>

<p>Κατάλογος με τα  <a href='extra.php'>&nbsp; extras &nbsp;</a>

</div> 
</body>
</html>