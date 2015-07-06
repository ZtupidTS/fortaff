<?php
 $xml = '<?xml version="1.0" encoding="UTF-8"?>';
 $xml .= '<rss version="2.0">'; 
 $xml .= '<channel>'; 
 $xml .= '<title>Ultimos 6 eventos</title>';
 $xml .= '<link>http://pw-jre.heliohost.org/</link>';
 $xml .= '<description>Ultimos 6 eventos que vão decorrer</description>';
 $xml .= '<copyright>PW-JRE 2012</copyright>';
 $xml .= '<language>pt</language>';
 // $xml .= '<image>';
 // $xml .= ' <title>Titre du flux</title>';
 // $xml .= ' <url>chemin absolu de l'image http://.... (pas plus de 88px de haut)</url>';
 // $xml .= ' <link>http://www.monsite.com</link>';
 // $xml .= '</image>';

include '../includes/ligacao.php';
require_once '../funcao/dia_actual.php';
$data = dia_actual();
$db = mysql_query("SELECT * FROM evento WHERE estado_valido = 'V' and data > '$data' ORDER BY data LIMIT 0,6");

while($dados = mysql_fetch_assoc($db))
{ 
	$xml .= '<item>';
	$xml .= '<title>'.$dados['designacao'].'</title>';
	$xml .= '<description>'.$dados['descricao'].' dia '.$dados['data'].' as '.$dados['hora_inicio'].'</description>';
	$xml .= '</item>'; 
}
$xml .= '</channel>';
$xml .= '</rss>';
  
$fp = fopen("fluxrss.xml", 'w+');
fputs($fp, $xml);
fclose($fp);
?>