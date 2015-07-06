<?php
session_start();
// session_unset();
// session_start();
unset($_SESSION['login']);
header("location: /pw606/co/index.php");
?>