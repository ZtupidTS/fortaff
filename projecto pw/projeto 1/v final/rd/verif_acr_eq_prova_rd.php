<?php 
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php';

mysql_query("INSERT INTO classificacao_prova (cod_prova, cod_do_classificado, estado_valido_prova, estado_valido_classificado) VALUES ('$_GET[cod_prova]', '$_GET[cod_equipa]', 'V', 'V')");
mysql_close($conexao);
$_SESSION['mensagem'] = 'Equipa nº '.$_GET['cod_equipa'].' inserida na prova nº '.$_GET['cod_prova'].' com sucesso';
header('Location: ins_equipa_prova_rd.php');
?>