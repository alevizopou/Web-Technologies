<?php
session_start();
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<?php
//mb_internal_encoding("UTF-8");
 
 if (!isset($username) ||!isset($password)){ 
 echo '<script>'; 
 echo 'alert("Δεν έχετε πρόσβαση σε αυτή τη σελίδα!");'; 
 echo 'window.location="manager_login_form.html";'; 
 echo '</script>'; 
 } 
 
 /* Τα δεδομένα της φόρμας σύνδεσης */ 
 $username=trim($_POST['username']); 
 $password=trim($_POST['password']); 
 
 /* Σύνδεση στην MySQL */ 
 include("DBcreate.php"); 
 
?> 
