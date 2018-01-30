<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<?php
session_start();
$username = $_SESSION['username'];

$title = $_POST["title"];
$description = $_POST["description"];
$price = $_POST["price"];
$category = $_POST["category"];

$con = mysql_connect("localhost","root","");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$sql = "INSERT INTO product (title, description, price, in_category) 
VALUES 
('$title','$description','$price','$category')";

if (!mysql_query($sql,$con))
{
	error("Υπήρξε κάποιο σφάλμα!");
} else success();

function error($message){
	echo '<script>';
		echo 'alert("'.$message.'");';
		echo 'window.location="add_new_product_form.php";';
	echo '</script>';
}

function success(){
	echo '<script>';
		echo 'alert("Επιτυχής προσθήκη νέου προϊόντος!");';
		echo 'window.location="products.php";';
	echo '</script>';
}

mysql_close($con);

?>