<?php
/* Έλεγχος για απαγορευμένη πρόσβαση στην σελίδα */
if (!isset($_SESSION["username"])){
{
	echo '<a href="manager_login_form.html">Login</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ';
}
?>
<html>
<head>
<title> order-system </title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<center> <h2> Ceid Cafe </h2> </center>
<p></p>
<center>
<table>
<tr>
<td> <a href="userpage.php"> &nbsp; Αρχική &nbsp; </a> </td>
<td> <a href="upload-form.php"> &nbsp; Προσωπικό &nbsp; </a> </td>
<td> <a href="delete-photo.php"> &nbsp; Προσθήκη Προσωπικού &nbsp; </a> </td>
<td> <a href="delete-photo.php"> &nbsp; Menu &nbsp; </a> </td>
<td> <a href="logout_manager.php"> &nbsp; Αποσύνδεση &nbsp; </a> </td>
</tr>
</table>
<p></p>
<div style="width:30%">
<form action="search.php" method="get">
<fieldset> <legend> &nbsp;&nbsp; Aναζήτηση Εικόνων &nbsp;&nbsp; </legend>
<table>
<tr>
<td> Ετικέτες &nbsp; </td>
<td> <input type="text" name="tags" size="30" /> </td>
</tr>
</table>
<p> <input id="button" type="submit" name="submit" value="Aναζήτηση" /> </p>
</fieldset>
</form>
</div>
</center>
</body>
</html>