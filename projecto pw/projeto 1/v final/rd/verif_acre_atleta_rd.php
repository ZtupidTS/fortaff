<?php 
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php';
require_once '../funcao/funcao_formulario.php';
$nome = control_post($_POST['nome']);

if($_POST['nome'] == "")
{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Tem de preencher o campo do nome do atleta';
	header('Location: acrescentar_atleta_rd.php');
}else{
	$data_nasc = $_POST['ano'].'-'.$_POST['mes'].'-'.$_POST['dia'];
	mysql_query("INSERT INTO elemento_equipa (nome, data_nasc, sexo) VALUES ('$nome', '$data_nasc', '$_POST[sexo]')");
	$ultimo_id = mysql_fetch_array(mysql_query("SELECT last_insert_id() FROM elemento_equipa"));
	mysql_query("INSERT INTO atleta (cod_elemento_equipa, peso, altura, grupo_sanguineo) VALUES ('$ultimo_id[0]', '$_POST[peso]', '$_POST[altura]', '$_POST[grupo_sanguineo]')");
	mysql_query("INSERT INTO elemento_in_equipa (cod_equipa, cod_elemento_equipa, estado_valido) VALUES ('$_SESSION[cod_equipa]', '$ultimo_id[0]', 'A')");
	if (mysql_affected_rows() > 0)
	{
		$_SESSION["mensagem"] = 'Inserчуo do atleta com sucesso';
		mysql_close($conexao);
		header('Location: acrescentar_atleta_rd.php');
	}else{
		$_SESSION["mensagem"] = 'Inserчуo do atleta sem sucesso';
		mysql_close($conexao);
		header('Location: acrescentar_atleta_rd.php');
	}	
}?>