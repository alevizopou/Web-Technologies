<?php
session_start();
unset($_SESSION['username']);

header("Location: manager_login_form.html");

?>