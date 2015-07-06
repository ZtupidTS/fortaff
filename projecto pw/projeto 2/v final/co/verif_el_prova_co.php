<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php'; 
mysql_query("UPDATE prova SET estado_valido = 'X' WHERE cod_prova = '$_GET[cod_prova]'");
mysql_query("UPDATE classificacao_prova SET estado_valido_prova = 'X' WHERE cod_prova = '$_GET[cod_prova]'");
mysql_close($conexao);
$_SESSION["mensagem"] = 'Prova eliminada com sucesso';
# recuperei o url da pagina anterior para o meter no javascript e assim não repetir codigo desnecessario
#require_once '../funcao/recupera_url.php';
#$url = recupera_url();	
header('Location: provas_co.php');
?>