<?php
session_start();
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" type="text/css"  href="login_style.css" />
</head>
<body>

<?php
mb_internal_encoding("UTF-8");

$db_server["host"] = "localhost"; //database server
$db_server["username"] = "root"; // DB username
$db_server["password"] = ""; // DB password
$db_server["database"] = "my_db";// database name

$con = mysql_connect($db_server["host"], $db_server["username"], $db_server["password"]);
mysql_set_charset('utf8',$con);  

mysql_select_db($db_server["database"], $con);

//gia ta ellinika (panta meta to select db)
mysql_query("SET NAMES 'utf8'", $con);

$username = $_POST["username"];
$password = $_POST["password"];

if(isset($username))
{
	if(!preg_match("/^[^0-9][A-zΑ-ω0-9_.-]/",$username))
	{
		echo '<script>';
			echo 'alert("To login απέτυχε. Μη αποδεκτό username!");';
			echo 'window.location="waiter_login_form.php";';
		echo '</script>';
	}
	else
	{
		$result = mysql_query("SELECT * FROM waiter WHERE username ='$username' and password='$password'")
		or die(mysql_error());
		if(!$result)
		{
			echo "Cannot run query ." . "<br />";
			exit;
		}
		
	$rows = mysql_num_rows($result);
	$row = mysql_fetch_assoc($result);
	
	if($rows==1)
	{
		//visitor's name and password combination are correct
		$_SESSION['username']=$username;
		echo '<script>';
				echo 'alert("Καλωσήρθατε! Έχετε συνδεθεί ως ',$_SESSION["username"], '");';
				echo 'window.location="mobile_menu.php";';
			echo '</script>';
	}
	else
	{
		//visitor's name and password are not correct
			mysql_close($link);
			echo '<script>';
				echo 'alert("To login απέτυχε. Έχετε δώσει λάθος username ή κωδικό!");';
				echo 'window.location="waiter_login_form.php";';
			echo '</script>';
	}

	}
}
else
{
 include("waiter_login_form.php");
}

?>
</body>
</html>