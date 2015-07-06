<?php
session_start();
require_once '../funcao/dia_actual.php';
$dia_actual = dia_actual();	
include 'ligacao.php';
mysql_query("UPDATE delegacao SET ultimo_acesso = '$dia_actual' WHERE login = '$_SESSION[login_utilizador]' and estado_valido != 'X'");
mysql_close($conexao);
session_unset();
session_destroy();
session_start();
$_SESSION["login_false"] = false;
header('Location: ../login/area_reservada.php');
?>