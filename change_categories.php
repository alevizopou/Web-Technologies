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

$onoma = $_POST['onoma'];
$id = $_POST['id'];

$result = "UPDATE category SET title='$onoma' WHERE category_id='$id'";

if (!mysql_query($result,$con))
{
	error("Υπήρξε κάποιο σφάλμα!");
} else success();

function error($message){
	echo '<script>';
		echo 'alert("'.$message.'");';
		echo 'window.location="categories.php";';
	echo '</script>';
}

function success(){
	echo '<script>';
		echo 'alert("Η αλλαγή πραγματοποιήθηκε!");';
		echo 'window.location="categories.php";';
	echo '</script>';
}

mysql_close($con);

?>

</html>