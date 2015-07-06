<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php';
mysql_query("UPDATE modalidade SET tipo='$_POST[tipo]' WHERE cod_modalidade='$_POST[cod_modalidade]'"); 
if(mysql_affected_rows() > 0)
{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Modalidade alterada com sucesso';
	header('Location: altera_modalidade_co.php');
}else{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Modalidade não alterada';
	header('Location: altera_modalidade_co.php');
}
?>
