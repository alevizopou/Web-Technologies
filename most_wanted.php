<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<style>
fieldset {
    border: 0;
	background-color:#99CC66
}
</style>
</head>
<body>
<?php
session_start();
include("toolbar.php");

$num = $_POST['most'];

$con = mysql_connect("localhost","root","");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$count=0;
$result = mysql_query("SELECT * FROM product ORDER BY popularity DESC ") or die(mysql_error());

echo("<br></br>");
echo("<fieldset><p><i>Τα προϊόντα με τις περισσότερες πωλήσεις είναι τα εξής:</br></i></p>");

while ($db_field = mysql_fetch_assoc($result)) 
{	
	if($count>=$num)
	{
		exit;
	}
	echo $db_field['title'] . "<br>";
	$count++;
}
echo("</fieldset>");

mysql_close($con);
?>

</body>
</html>