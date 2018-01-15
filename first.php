<?php 

session_start();

/* Έλεγχος για απαγορευμένη πρόσβαση στη σελίδα */
if (!isset($_SESSION["username"]))
{
	echo '<script>';
		echo 'alert("Δεν έχετε πρόσβαση σε αυτή τη σελίδα!\nΠρέπει πρώτα να συνδεθείτε!");';
		echo 'window.location="manager_login_form.html";';
	echo '</script>';
}

include("toolbar.php");

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="refresh" content="15" >
<script type="text/javascript">

function load_orders() {

var xmlhttpp;

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttpp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
	xmlhttpp=new ActiveXObject("Microsoft.XMLHTTP");
}

// set up
xmlhttpp.onreadystatechange=function()
{
	if (xmlhttpp.readyState==4 && xmlhttpp.status==200)
    {
		var a = new Array();
		var newLink = new Array();
		var id = "no";
		var s = xmlhttpp.responseText;
		//alert(s);
		
		//diaspasi tou string pou pairnoume ws apantisi apo to arxeio most_wanted.php
		var wanted = s.split(",");
		//dimiourgia eikonwn
		for ( i=0; i<wanted.length; i++)
		{
			var space = document.createTextNode('     ');
			document.getElementById("field").appendChild(space);
			var text1 = document.createTextNode("Ημερομηνία: ");
			document.getElementById("field").appendChild(text1);
			var text2 = document.createTextNode(wanted[i]);
			document.getElementById("field").appendChild(text2);
			document.getElementById("field").appendChild(space);
			
			i++;
			
			var text1 = document.createTextNode("Σερβιτόρος: ");
			document.getElementById("field").appendChild(text1);
			var text2 = document.createTextNode(wanted[i]);
			document.getElementById("field").appendChild(text2);
			var next = document.createTextNode("\r\n");	
			document.getElementById("field").appendChild(next);
			
			i++;
			var text1 = document.createTextNode("Προιόντα: ");
			document.getElementById("field").appendChild(text1);
			var next = document.createTextNode("\r\n");	
			document.getElementById("field").appendChild(next);
			//pairnoume ton arithmo twn items tis paraggelias
			var num = wanted[i];
			
			i++;
			var count = 0;
			do{
			var text2 = document.createTextNode(wanted[i]);
			document.getElementById("field").appendChild(text2);
			var next = document.createTextNode("\r\n");	
			document.getElementById("field").appendChild(next);
			count++;
			i++;
			}while(count<num);
			
			var text1 = document.createTextNode("Τιμή: ");
			document.getElementById("field").appendChild(text1);
			var text2 = document.createTextNode(wanted[i]);
			document.getElementById("field").appendChild(text2);
			
			
			mydiv = document.getElementById("field");
			mydiv.innerHTML += "<br>";
			//document.getElementById("field").appendChild(next);		
		}
    }
}

	var url= "latest_orders.php";
	
	xmlhttpp.open("GET",url,true);
	xmlhttpp.send();
}
	
function check2(elm)
{
	for (i=0;i<elm.length;i++)
	{
		if(elm[i].type=="text")
		{
			if(elm[i].value.length==0)
			{
				alert("Συμπληρώστε το πεδίο.");
				return false;		
			}
			if(!isNumber(elm[i].value) )
			{
				alert("Εισάγετε έγκυρη τιμή");
				return false;		
			}
			if(elm[i].value<=0)
			{
				alert("Εισάγετε έγκυρη τιμή");
				return false;		
			}
		}
	}
}

function isNumber (o) 
{
	return ! isNaN (o-0) && o !== null && o !== "" && o !== false;
}

</script>
 <style>
fieldset {
    border: 0;
	background-color:#99CC66
}
</style>
</head>

<body onload="load_orders()">

<br/> 
<div id="orders_div" > <br/> <br/> 
<fieldset id="field" >
<p><i>Οι 5 πιο πρόσφατες παραγγελίες:</i></p>
</fieldset>

<br/> <br/> 

<p>Συνολικός Τζίρος </p>
<form name = "myform" enctype="multipart/form-data" action="tziros.php" method="post">
<select name="ana" >
  <option value="day">Ανά ημέρα</option>
  <option value="week">Ανά εβδομάδα</option>
  <option value="month">Ανά μήνα</option>
</select> 
<br/> 
<p>Εισάγετε ημερομηνία <input type="date" name="date" >
<input type="submit" name="submit" value="Υπολογισμός" /></p>
</form>
<br/> <br/> 
<form name = "myform2" enctype="multipart/form-data" action="most_wanted.php" method="post" onsubmit="return check2(this.elements);">
<p>Δείτε τα <input type="text" name="most" size="5"> (εισάγετε αριθμό) προιόντα με τις περισσότερες πωλήσεις.  
<input type="submit" name="submit" value="enter" /></p>
</form>
<br/> <br/> 
<form name = "myform3" enctype="multipart/form-data" action="less_wanted.php" method="post" onsubmit="return check2(this.elements);">
<p>Δείτε τα <input type="text" name="less" size="5"> (εισάγετε αριθμό) προιόντα με τις λιγότερες πωλήσεις.  
<input type="submit" name="submit" value="enter" /></p>
</form>

</div>

</body>
</html>