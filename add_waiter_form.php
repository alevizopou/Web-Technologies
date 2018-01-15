<?php
session_start();
include("toolbar.php");

/* Έλεγχος για απαγορευμένη πρόσβαση στη σελίδα */
if(!isset($_SESSION['username'])){
	echo '<script>';
		echo 'alert("Δεν έχετε δικαίωμα πρόσβασης σε αυτή τη σελίδα!");';
		echo 'window.location="manager_login_form.html";';
	echo '</script>';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
.myTable { background-color:#e4ebeb;border-collapse:collapse; }
.myTable th { background-color:#a8b9c2;color:black; }
.myTable td, .myTable th { cellpadding:20px; border:2px solid #99CCCC;}
</style>

<script type="text/javascript">
function checkscript(elm)
{
	for (i=0; i<elm.length; i++)
	{
		var elm_name = elm[i].name;
		 
		if(elm_name.search("firstname") != -1)
		{
			if(elm[i].value.length==0)
			{
				alert("Δώστε το μικρό όνομα.");
				return false;
			}
		}
			
		if(elm_name.search("lastname") != -1)
		{
			if(elm[i].value.length==0)
			{
				alert("Δώστε το επώνυμο.");
				return false;
			}
		}
				
		if(elm_name.search("waiter_username") != -1)
		{
			if(elm[i].value.length==0)
			{
				alert("Δώστε το username.");
				return false;
			}
		}
		
		if(elm_name.search("waiter_password") != -1)
		{
			if(elm[i].value.length==0)
			{
				alert("Δώστε το password.");
				return false;
			}
		}			
	    
		if(elm_name.search("filename") != -1)
		{	
			if(elm[i].value.length==0)
			{
				alert("Δώστε το url της εικόνας για να γίνει upload.");
				return false;
			}
				
			if(!isImage(elm[i].value))
			{
				alert("Tο αρχείο δεν είναι εικόνα");
				return false;
			}	
		}	
	}
	
return true;

}// end checkscript

function isImage(filename) {
    var ext = getExtension(filename);
    switch (ext.toLowerCase()) {
    case 'jpg':
    case 'gif':
    case 'bmp':
    case 'png':
	case 'jpeg':
        //etc
        return true;
    }
    return false;
}

function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}

</script>
</head>

<body>
<div style="width:30%">
<form name="myform" enctype="multipart/form-data" action="add_waiter_action.php" method="post" onsubmit="return checkscript(this.elements);">
<br>&nbsp;<br>
<fieldset><legend> &nbsp;&nbsp; Προσθήκη Προσωπικού &nbsp;&nbsp; </legend>
<table class="myTable" style="width:20%">
<?php

$repeat = "<tr>
		<td> Όνομα:&nbsp;</td>
		<td><input type=\"text\" name=\"firstname\" size=\"30\"/></td>
	</tr>
	<br />
	<tr>
		<td> Επώνυμο:&nbsp;</td>
		<td><input type=\"text\" name=\"lastname\" size=\"30\"/></td>
	</tr>
	<br />
	<tr>
		<td> Username:&nbsp;</td>
		<td><input type=\"text\" name=\"waiter_username\" size=\"30\"/></td>
	</tr>
	<br />
	<tr>
		<td> Password:&nbsp;</td>
		<td><input type=\"password\" name=\"waiter_password\" size=\"30\"/></td>
	</tr>
	<tr>
		<td> Εικόνα:&nbsp;</td>
		<td><input type=\"file\" name=\"filename\" size=\"30\" align=\"center\"/></td>
	</tr>
<br />

";
echo $repeat;

?>
</table>

<p><input id="button" type="submit" value="Submit" /> </p>
</fieldset>
</form>
</div>
</body>
</html>
