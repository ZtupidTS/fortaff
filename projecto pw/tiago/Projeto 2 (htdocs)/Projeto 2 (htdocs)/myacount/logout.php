<?php
session_start();
unset($_SESSION['login_vs']);
header("location: /pw606/public/index.php");
?>