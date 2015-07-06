<?php
session_start();
require_once '../../funcao/dia_actual.php';
$dia_actual = dia_actual();	

include '../../includes/ligacao.php';
mysql_query("UPDATE visitante SET ult_acesso = '$dia_actual' WHERE nome = '$_SESSION[nome_vis]' and email = '$_SESSION[email_vis]'");
mysql_close($conexao);
session_unset();
session_destroy();
session_start();

header('Location: ../visitante.php');
?>