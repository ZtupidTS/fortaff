<?php
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php';

mysql_query("INSERT INTO elemento_in_equipa (cod_equipa, cod_elemento_equipa, estado_valido) VALUES ('$_SESSION[cod_equipa]', '$_POST[cod_elemento_equipa]', 'A')");
if (mysql_affected_rows() > 0)
{
	$_SESSION["mensagem"] = 'Elemento inserido na equipa';
	mysql_close($conexao);
	#header('Location: acrescentar_atleta_rd.php');
}else{
	$_SESSION["mensagem"] = 'Elemento não inserido na equipa';
	mysql_close($conexao);
	#header('Location: acrescentar_atleta_rd.php');
}
#recupera a url da pagina anterior e vou usar isso tambem para as query do mysql
$path_part = pathinfo($_SERVER['HTTP_REFERER']);
#se o url da pagina anterior contem atle a minha variavel fica com atleta senão com auxiliar
header('Location:  '.$path_part['basename']);
?>