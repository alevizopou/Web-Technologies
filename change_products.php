<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<?php
session_start();
$username = $_SESSION['username'];

$con = mysql_connect("localhost","root","");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$category = $_POST['mydropdown'];

$result = "UPDATE product SET description='$description', price='$price', in_category='$category' WHERE title='$title'";

if (!mysql_query($result,$con))
{
	error("Υπήρξε κάποιο σφάλμα!");
} else success();

function error($message){
	echo '<script>';
		echo 'alert("'.$message.'");';
		echo 'window.location="products.php";';
	echo '</script>';
}

function success(){
	echo '<script>';
		echo 'alert("Η αλλαγή πραγματοποιήθηκε!");';
		echo 'window.location="products.php";';
	echo '</script>';
}

mysql_close($con);

?>

</html>