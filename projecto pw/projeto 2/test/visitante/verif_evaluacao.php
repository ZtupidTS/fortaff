<?php
session_start();
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$estrela = control_post($_GET['estrela']);
$cod_evento = control_post($_GET['cod']);

mysql_query("INSERT INTO classificacao_evento (cod_evento, classificacao, id_vis) VALUES ('$cod_evento', '$estrela', '$_SESSION[id_vis]')");
$_SESSION['mensagem'] = 'Obrigado pela evaluaчуo';

header("Location: registo_vis.php");
?>