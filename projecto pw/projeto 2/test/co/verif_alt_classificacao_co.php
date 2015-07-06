<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php';

$cod_do_classificado = $_POST['cod_do_classificado'];
$classificacao = $_POST['classificacao'];

for($i=0;$i<count($cod_do_classificado);$i++)
{
	if($classificacao[$i] == '')
	{
		mysql_query("UPDATE classificacao_prova SET classificacao = NULL WHERE cod_prova = '$_SESSION[class_cod_prova]' and cod_do_classificado = '$cod_do_classificado[$i]' and estado_valido_classificado = 'V'");
	}else{
		mysql_query("UPDATE classificacao_prova SET classificacao = '$classificacao[$i]' WHERE cod_prova = '$_SESSION[class_cod_prova]' and cod_do_classificado = '$cod_do_classificado[$i]' and estado_valido_classificado = 'V'");
	}
}
mysql_close($conexao);
header('Location: class_prova_co.php');
?>