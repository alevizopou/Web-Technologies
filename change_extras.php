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

$name = $_POST['name'];
$price = $_POST['price'];
$product = $_POST['mydropdown'];

$res=mysql_query("SELECT * FROM product WHERE title='$product'") or die(mysql_error());
$ar = mysql_fetch_array( $res );
$category = $ar['in_category'];

$sql = "UPDATE property SET extraPrice='$price', into_category='$category', product='$product' WHERE name='$name'";

if (!mysql_query($sql,$con))
{
	error("Υπήρξε κάποιο σφάλμα!");
} else success();

function error($message){
	echo '<script>';
		echo 'alert("'.$message.'");';
		echo 'window.location="extra.php";';
	echo '</script>';
}

function success(){
	echo '<script>';
		echo 'alert("Επιτυχής τροποποίηση έξτρα προϊόντος/ιδιότητας!");';
		echo 'window.location="extra.php";';
	echo '</script>';
}

mysql_close($con);
?>

</html>