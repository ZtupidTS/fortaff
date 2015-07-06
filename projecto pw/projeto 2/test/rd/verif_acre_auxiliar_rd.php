<?php 
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$nome = control_post($_POST['nome']);
$habilit_literarias = control_post($_POST['habilit_literarias']);
$funcao = control_post($_POST['funcao']);

if($_POST['nome'] == "" || $_POST['funcao'] == "" || $_POST['habilit_literarias'] == "")
{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Tem de preencher todos os campos';
	header('Location: acrescentar_auxiliar_rd.php');
}else{
	$data_nasc = $_POST['ano'].'-'.$_POST['mes'].'-'.$_POST['dia'];
	mysql_query("INSERT INTO elemento_equipa (nome, data_nasc, sexo) VALUES ('$nome', '$data_nasc', '$_POST[sexo]')");
	$ultimo_id = mysql_fetch_array(mysql_query("SELECT last_insert_id() FROM elemento_equipa"));
	mysql_query("INSERT INTO auxiliar (cod_elemento_equipa, funcao, habilit_literarias) VALUES ('$ultimo_id[0]', '$funcao', '$habilit_literarias')");
	mysql_query("INSERT INTO elemento_in_equipa (cod_equipa, cod_elemento_equipa, estado_valido) VALUES ('$_SESSION[cod_equipa]', '$ultimo_id[0]', 'A')");
	if (mysql_affected_rows() > 0)
	{
		$_SESSION["mensagem"] = 'Inserção do auxiliar com sucesso';
		mysql_close($conexao);
		header('Location: acrescentar_auxiliar_rd.php');
	}else{
		$_SESSION["mensagem"] = 'Inserção do auxiliar sem sucesso';
		mysql_close($conexao);
		header('Location: acrescentar_auxiliar_rd.php');
	}
}
?>
