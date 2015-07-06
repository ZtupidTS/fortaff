<?php 
session_start();
include '../includes/test_intruso_co.php';
include '../includes/ligacao.php'; 
mysql_query("UPDATE evento SET estado_valido = 'X' WHERE cod_evento = '$_GET[cod_evento]'");
mysql_close($conexao);
$_SESSION["mensagem"] = 'Evento eliminado com sucesso';
# recuperei o url da pagina anterior para o meter no javascript e assim não repetir codigo desnecessario
#require_once '../funcao/recupera_url.php';
#$url = recupera_url();
header('Location: eventos_co.php');
?>