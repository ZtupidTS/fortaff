<?php 
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php';

$repeticao_equipa = mysql_query("SELECT * FROM equipa WHERE cod_delegacao='$_POST[cod_delegacao]' and cod_modalidade = '$_POST[cod_modalidade]' and sexo = '$_POST[sexo]'");
if(mysql_num_rows($repeticao_equipa))
{
	$_SESSION["mensagem"] = 'Jс existe uma equipa com essa modalidade';
	mysql_close($conexao);
	header('Location: alt_eq_rd.php');
}else{
	mysql_query("UPDATE equipa SET ref_cod_modalidade = cod_modalidade, cod_modalidade = '$_POST[cod_modalidade]', estado_valido = 'M' WHERE cod_equipa = '$_POST[cod_equipa]'");
	if (mysql_affected_rows() > 0)
	{
		$_SESSION["mensagem"] = 'Alteraчуo da modalidade da equipa com sucesso.';
		mysql_close($conexao);
		header('Location: alt_eq_rd.php');
	}else{
		$_SESSION["mensagem"] = 'Alteraчуo da modalidade da equipa sem sucesso';
		mysql_close($conexao);
		header('Location: alt_eq_rd.php');
	}
}
?>