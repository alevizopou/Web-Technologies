<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<?php
session_start();
$username = $_SESSION['username'];

	$title = $_POST["title"];
	
	/* syndesi me tin vasi gia apothikeysi tou waiter */
	$con = mysql_connect("localhost","root","");
	if (!$con)
	{
	die('Could not connect: ' . mysql_error());
	}
	mysql_set_charset('utf8',$con);  
	mysql_select_db("my_db", $con);
	mysql_query("SET NAMES 'utf8'", $con);
	
	$sql = "INSERT INTO category (title) VALUES ('$title')";
	
	if (!mysql_query($sql,$con))
	{
		error("Υπήρξε κάποιο σφάλμα!");
	} else success();
	
	function error($message){
		echo '<script>';
			echo 'alert("'.$message.'");';
			echo 'window.location="add_category.php";';
		echo '</script>';
	}
	
	function success(){
		echo '<script>';
			echo 'alert("Επιτυχής καταχώρηση νέας κατηγορίας!");';
			echo 'window.location="categories.php";';
		echo '</script>';
	}
	
	mysql_close($con);

?>