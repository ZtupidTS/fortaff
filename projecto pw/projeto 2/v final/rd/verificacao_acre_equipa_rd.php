<?php 
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php';

$verifica_se_existe = mysql_query("SELECT * FROM equipa WHERE cod_modalidade ='$_POST[cod_modalidade]' and cod_delegacao='$_SESSION[cod_delegacao_utilizador]' and sexo = '$_POST[sexo]' and estado_valido != 'X'");
if(mysql_num_rows($verifica_se_existe) > 0)
{
	mysql_close($conexao);
	$_SESSION["mensagem"] = 'Delegação já existente com essa modalidade';
	header('Location: acrescentar_equipa_rd.php');
}else{
	$final_insert = mysql_query ("INSERT INTO  equipa (cod_modalidade, cod_delegacao, estado_valido, sexo) VALUES ('$_POST[cod_modalidade]', '$_SESSION[cod_delegacao_utilizador]', 'A', '$_POST[sexo]')");
	if(mysql_affected_rows() > 0)
	{
		mysql_close($conexao);
		$_SESSION["mensagem"] = 'Equipa inserida com êxito';
		header('Location: acrescentar_equipa_rd.php');
	}else{
		mysql_close($conexao);
		$_SESSION["mensagem"] = 'Equipa não inserida';
		header('Location: acrescentar_equipa_rd.php');
	}//verifica se a inserção foi feita
}?>
