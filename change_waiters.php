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

$ffilename ="";

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
	$uploadedfile = $_FILES["filename"]["tmp_name"];
	/* edw ginetai to upload tis fotografiasston fakelo pics */
	move_uploaded_file($uploadedfile, "images/$ffilename");
}

$firstname = $_POST["onoma"];
$lastname = $_POST["epwnymo"];
$waiter_username = $_POST["username"];
$waiter_password = $_POST["password"];

if ($ffilename=="")
{
$result = "UPDATE waiter SET password='$waiter_password', firstname='$firstname', lastname='$lastname' WHERE username='$waiter_username'";
} else{
$result = "UPDATE waiter SET password='$waiter_password', firstname='$firstname', lastname='$lastname', pic_url='./images/$ffilename' WHERE username='$waiter_username'";
}

if (!mysql_query($result,$con))
{
	error("Υπήρξε κάποιο σφάλμα!");
} else success();

function error($message){
	echo '<script>';
	echo 'alert("'.$message.'");';
		echo 'window.location="waiters.php";';
	echo '</script>';
}

function success(){
	echo '<script>';
		echo 'alert("Επιτυχής τροποποίηση στοιχείων προσωπικού!");';
		echo 'window.location="waiters.php";';
	echo '</script>';
}

mysql_close($con);

?>

</html>