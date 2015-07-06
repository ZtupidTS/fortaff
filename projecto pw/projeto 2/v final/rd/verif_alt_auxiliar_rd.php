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
	$_SESSION["mensagem"] = 'Tem de preencher todos os campo';
	header('Location: alt_auxiliar_rd.php');
}else{
	$data_nasc = $_POST['ano'].'-'.$_POST['mes'].'-'.$_POST['dia'];
	mysql_query("UPDATE elemento_equipa SET old_nome = nome, old_data_nasc = data_nasc, old_sexo = sexo, nome = '$nome', data_nasc = '$data_nasc', sexo = '$_POST[sexo]' WHERE cod_elemento_equipa = '$_POST[cod_elemento_equipa]'");
	$query1 = mysql_affected_rows();
	mysql_query("UPDATE auxiliar SET old_funcao = funcao, old_habilit = habilit_literarias, funcao = '$funcao', habilit_literarias = '$habilit_literarias' WHERE cod_elemento_equipa = '$_POST[cod_elemento_equipa]'");
	$query2 = mysql_affected_rows();
	$query3 = mysql_query("UPDATE elemento_in_equipa SET estado_valido = 'M' WHERE cod_equipa = '$_SESSION[cod_equipa]' and cod_elemento_equipa = '$_POST[cod_elemento_equipa]'");
	if (($query1 + $query2 + $query3) > 0)
	{
		$_SESSION["mensagem"] = 'Alteraчуo do auxiliar com sucesso';
		mysql_close($conexao);
		header('Location: alt_auxiliar_rd.php');
	}else{
		$_SESSION["mensagem"] = 'Alteraчуo do auxiliar sem sucesso';
		mysql_close($conexao);
		header('Location: alt_auxiliar_rd.php');
	}
}	
?>