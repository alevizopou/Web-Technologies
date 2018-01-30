<?php session_start(); 

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
<meta name="viewport" content="width=device-width" />
<title> order-system </title>
<link rel="stylesheet" type="text/css"  href="newcss.css" />
</head>
<body>
<center> 
<h2> Ceid Café </h2>
<h4> Περιβάλλον Παραγγελιών </h4>

<nav id="access" role="navigation">
<div id="wrapper">
<ul>
<?php
	if (!isset($_SESSION['username']))
	{
		echo '<li><a href="waiter_login_form.php">Login</a> </li> ';
	}
	else
	{
		echo '<li><a href="choose_category.php"> &nbsp; Νέα Παραγγελία &nbsp; </a></li>';
		echo '<li><a href="change_order.php"> &nbsp; Αλλαγή παραγγελίας &nbsp; </a></li>';
		echo '<li><a href="waiter_logout.php"> &nbsp; Αποσύνδεση &nbsp; </a></li>';
	}
?>
</ul>
</div>
</nav>
</center>
</body>
</html>