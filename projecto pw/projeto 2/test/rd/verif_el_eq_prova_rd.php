<?php 
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php';

mysql_query("UPDATE classificacao_prova SET estado_valido_classificado = 'X' WHERE cod_prova = '$_GET[cod_prova]' and cod_do_classificado = '$_GET[cod_equipa]'");
mysql_close($conexao);
$_SESSION['mensagem'] = 'Equipa nº '.$_GET['cod_equipa'].' removido da prova nº '.$_GET['cod_prova'].' com sucesso';
header('Location: ins_equipa_prova_rd.php');
?>