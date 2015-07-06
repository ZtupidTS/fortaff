<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$nome_modalidade = control_post($_POST['nome_modalidade']);
$tipo = control_post($_POST['tipo']);


if($_POST['nome_modalidade'] == "" )
{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Tem de preencher o campo do nome da modalidade';
	header('Location: acrescentar_modalidade_co.php');
}else{
	mysql_query("INSERT INTO modalidade (nome_modalidade, tipo, estado_valido) VALUES ('$nome_modalidade', '$tipo', 'V')");
	if (mysql_affected_rows() > 0)
	{
		$_SESSION["mensagem"] = 'Inserção da modalidade com sucesso';
		mysql_close($conexao);
		header('Location: acrescentar_modalidade_co.php');
	}else{
		$_SESSION["mensagem"] = 'Inserção da modalidade sem sucesso';
		mysql_close($conexao);
		header('Location: acrescentar_modalidade_co.php');
	}	
}?>
