<?php

session_start();
include("toolbar.php");

$username = $_SESSION['username'];

/* Έλεγχος για απαγορευμένη πρόσβαση στη σελίδα */
if($_SESSION['username'] !="manager") 
{
	echo '<script>';
		echo 'alert("Δεν έχετε δικαίωμα πρόσβασης σε αυτή τη σελίδα!");';
		echo 'window.location="manager_login_form.html";';
	echo '</script>';
}

$dir = "./images/"; 
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />

<style type="text/css">
.myTable { margin:0px auto; background-color:#e4ebeb;border-collapse:collapse; }
.myTable th { background-color:#a8b9c2;color:black; }
.myTable td, .myTable th { cellpadding:10px; border:1px solid #99CCCC;}
.smaller img{width:40%;}
</style>

<script type="text/javascript">

function check(elm)
{
	var j=0;
	for(var j=0;j<elm.length;j++)
	{
		if((elm[j].type == "text") && (elm[j].value.length==0) )
		{
			alert("Λείπουν στοιχεία!");
			return false;
		}
	}
	
	return true;
}

function delete_waiter(tid)
{
	// pairnei to username tou waiter pou prepei na diagraftei
	var a = tid.split("_");
	var nm = a[1];
	
	var xmlhttp;
	
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		window.location.reload();
		//alert(xmlhttp.responseText);
    }
	}
	//apostoli tou username tou waiter pou prepei na diagraftei sto arxeio delete_waiter.php
	var url= "delete_waiter.php?u=" + nm;
	xmlhttp.open("GET",url,true);
	xmlhttp.send();

}

</script>
</head>
<body>
<br>&nbsp;<br>
<p>Για προσθήκη προσωπικού πατήστε <a href='add_waiter_form.php'>&nbsp; εδώ &nbsp;</a></p></br>
<div style="width:90%" >
<fieldset><legend> &nbsp; &nbsp; Προσωπικό &nbsp; &nbsp; </legend>
<br>&nbsp;<br>
<table class="myTable" width="60%">
<tr>
<th>Όνομα</th>
<th>Επώνυμο</th>
<th>Username</th>
<th>Password</th>
<th>Εικόνα</th>
<th>Αλλαγή</th>
<th>Διαγραφή</th>
</tr>

<?php
$link = mysql_connect("localhost","root","");
	
if (!$link)
{
	die('Could not connect: ' . mysql_error());
}
	
mysql_set_charset('utf8',$link);  
mysql_select_db("my_db", $link);
mysql_query("SET NAMES 'utf8'", $link);
	
$result = mysql_query("SELECT * FROM waiter") or die(mysql_error());
$rows = mysql_num_rows($result);
$i=0;	
$forma = "<form name = \"myform\" enctype=\"multipart/form-data\"  action=\"change_waiters.php\" method=\"post\" onsubmit=\"return check(this.elements);\" >";

while($row = mysql_fetch_array( $result )) 
{	
	$onoma = $row['firstname'];
	$epwnymo = $row['lastname'];
	$waiter_username = $row['username'];
	$waiter_password = $row['password'];
	$url = $row['pic_url'];

	echo $forma;

	$tid="t_".$waiter_username;

	$repeat = "
	<tr>
	<td><input type=\"text\" name=\"onoma\"  value=\"$onoma\" />
	</td>
	<td><input type=\"text\" name=\"epwnymo\"  value=\"$epwnymo\" />
	</td>
	<td><label>$waiter_username <label />
	<input type=\"hidden\" name=\"username\" value=\"$waiter_username\" />
	</td>
	<td><input type=\"password\" name=\"password\" value=\"$waiter_password\" />
	</td>
	<td><div class=\"smaller img\"><img src=\"$url\" /></div>
	<input type=\"file\" name=\"filename\" />
	</td>
	<td>
	<input type=\"submit\" name=\"submit\" value=\"submit!\" align=\"center\" />
	</td>
	<td><button type=\"button\" name =$tid onclick=\"delete_waiter(this.name);\">Delete</button>
	</td>
	</tr>

	</form>

	";

	$i++;
	echo $repeat;
}

mysql_close($link);
?>

<div id="myDiv"></div>
</table>
<br>&nbsp;<br>
</body>
</html>