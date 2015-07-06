<?php

$fp = fopen('js/arraypontos.js', 'w+');
fwrite($fp, 'var pontos = ['."\n");
$db = mysql_query("SELECT * FROM prova WHERE estado_valido = 'V'");
while($dados = mysql_fetch_array($db))
{
	$db2 = mysql_query("SELECT * FROM modalidade WHERE cod_modalidade = '$dados[cod_modalidade]'");
	$modal = mysql_fetch_array($db2);
	fwrite($fp, '{lat:'.$dados['lat'].',lng:'.$dados['lng'].",title:'Prova ".$modal['nome_modalidade']." as ".$dados['hora_inicio']." dia ".$dados['data']."'},"."\n");
}
$db = mysql_query("SELECT * FROM evento WHERE estado_valido = 'V'");
while($dados = mysql_fetch_array($db))
{
	fwrite($fp, '{lat:'.$dados['lat'].',lng:'.$dados['lng'].",title:'".$dados['designacao']." ".$dados['descricao']." as ".$dados['hora_inicio']." dia ".$dados['data']."'},"."\n");
}
fwrite($fp, '];');
fclose($fp);
?>