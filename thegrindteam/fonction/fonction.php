<?php
#controle des données a insérer dans la DB
function control_post($post)
{
	$nova_string = mysql_real_escape_string($post);
	return $nova_string;	
}

function recupera_url_atual()
{
	$url = $_SERVER['REQUEST_URI'];
	$url_array = explode("/", $url);
	#print_r($url2);
	for($i=0;$i<sizeof($url_array);$i++)
	{
		#echo $i;
		if(!strpos($url_array[$i], '.') === false)
		{
			return $url_array[$i];
			break;
		}
	}
}
?>