<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<style>
fieldset {
    border: 0;
	background-color:#99CC66;
}
</style>
</head>
<body>
<?php
session_start();
include("toolbar.php");
$option = $_POST['ana'];
$date = $_POST['date'];
$con = mysql_connect("localhost","root","");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$response=0;
$pieces = explode("-", $date);
$the_day = $pieces[2];
$the_month = $pieces[1];

if($option == "day")
{
	$result = mysql_query("SELECT price FROM orders WHERE DAY(the_date)='$the_day'") or die(mysql_error());
	
	while ($db_field = mysql_fetch_assoc($result)) {
		
		$prices[] = $db_field['price'];
		$response = $response + $db_field['price'];
		
	}
	echo "<br>";
	echo "Για την ημέρα: " . $date . "<br>";
	echo "Τζίρος: " . $response . "<br>";
}

if($option == "month")
{
	$result = mysql_query("SELECT price FROM orders WHERE MONTH(the_date)='$the_month'") or die(mysql_error());
	while ($db_field = mysql_fetch_assoc($result)) {
		
		$response = $response + $db_field['price'];
		
	}
	echo "<br>";	
	echo "Για τον μήνα: " . $the_month . "<br>";
	echo "Τζίρος: " . $response . "<br>";
}

if($option == "week")
{
	$result = mysql_query("SELECT price FROM orders WHERE WEEK(the_date)=WEEK('$date')") or die(mysql_error());
	
	while ($db_field = mysql_fetch_assoc($result)) {
		$response = $response + $db_field['price'];
	}
	echo "<br>";
	echo "Για την εβδομάδα της ημερομηνίας: " . $date . "<br>";
	echo "Τζίρος: " . $response . "<br>";
}

mysql_close($con);
?>

</body>
</html>