<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<?php
session_start();

/* Έλεγχος για απαγορευμένη πρόσβαση στη σελίδα */
if(!isset($_SESSION['username'])){
	echo '<script>';
		echo 'alert("Δεν έχετε δικαίωμα πρόσβασης σε αυτή τη σελίδα!");';
		echo 'window.location="manager_login_form.html";';
	echo '</script>';
}

$username = $_SESSION['username'];

$allowed = array('image/jpg','image/JPG','image/jpeg','image/pjpeg','image/png','image/x-png','image/PNG','image/X-PNG');

if (in_array($_FILES["filename"]["type"],$allowed))
{
	if ($_FILES["filename"]["error"] > 0)
    {
		echo "Error: " . $_FILES["filename"]["error"] . "<br />";
    }
	
	$filename = $_FILES["filename"]["name"];
	/* gia ypostiriksi ellinikwn sto onoma arxeiou */
	$ffilename = iconv('UTF-8', 'CP737', $filename);
}

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$waiter_username = $_POST["waiter_username"];
$waiter_password = $_POST["waiter_password"];

$uploadedfile = $_FILES["filename"]["tmp_name"];
/* edw ginetai to upload tis fotografias ston fakelo images */
move_uploaded_file($uploadedfile, "images/$ffilename");

/* syndesi me tin vasi gia apothikeysi tou waiter */
$con = mysql_connect("localhost","root","");
if (!$con)
{
die('Could not connect: ' . mysql_error());
}

mysql_set_charset('utf8',$con);  
mysql_select_db("my_db", $con);
mysql_query("SET NAMES 'utf8'", $con);

$sql = "INSERT INTO waiter (username, password, firstname, lastname, pic_url)
VALUES ('$waiter_username','$waiter_password','$firstname','$lastname','images/$ffilename')";

if (!mysql_query($sql,$con))
{
	error("Υπήρξε κάποιο σφάλμα!");
} else success();

function error($message){
	echo '<script>';
	echo 'alert("'.$message.'");';
		echo 'window.location="add_waiter_form.php";';
	echo '</script>';
}

function success(){
	echo '<script>';
		echo 'alert("Επιτυχής προσθήκη προσωπικού!");';
		echo 'window.location="waiters.php";';
	echo '</script>';
}

mysql_close($con);

?>