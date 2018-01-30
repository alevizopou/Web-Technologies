<?php

$waiter_username = $_GET['u'];

$link = mysql_connect("localhost","root","");

if (!$link)
{
	die('Could not connect: ' . mysql_error());
}

mysql_set_charset('utf8',$link);  
mysql_select_db("my_db", $link);
mysql_query("SET NAMES 'utf8'", $link);

mysql_query("DELETE FROM waiter WHERE username='$waiter_username'")or die(mysql_error());
mysql_close($link);

?>