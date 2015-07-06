<?php
session_start();

$_SERVER['DOCUMENT_ROOT'] = "C:/xampp/htdocs/profumi_dev/";

include $_SERVER['DOCUMENT_ROOT'].'includes/database/sqlite.php';
include $_SERVER['DOCUMENT_ROOT'].'includes/database/dblogin.php';
include $_SERVER['DOCUMENT_ROOT'].'includes/database/dbsms.php';

include $_SERVER['DOCUMENT_ROOT'].'includes/conf.php';
include $_SERVER['DOCUMENT_ROOT'].'fonction/function.php';

?>

