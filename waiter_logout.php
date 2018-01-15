<?php
session_start();
unset($_SESSION['username']);

header("Location: waiter_login_form.php");

?>