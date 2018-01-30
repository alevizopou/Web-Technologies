<?php

$title = $_GET['u'];

$con = mysql_connect("localhost","root","");

if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

mysql_query("DELETE FROM product WHERE title='$title'")or die(mysql_error());
mysql_close($con);

?>