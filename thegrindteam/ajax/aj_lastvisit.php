<?php
session_start();
require_once '../fonction/fonction.php';
$url_actual = recupera_url_atual();
if(isset($_SESSION['name']) && $_SESSION['name'] != "")
{
    $visibilitymenu = "block";
}else{
    if($url_actual != "index.php")
    {
        header('Location: index.php');
    }
    $visibilitymenu = "hidden";
}

include '../includes/connectDB.php';

mysql_query("UPDATE tgt_users SET lastvisit = now() WHERE id = ".$_SESSION['id_users']);
mysql_close($conexao);    

?>

