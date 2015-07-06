<?php
function recupera_url()
{
	$path_part = pathinfo($_SERVER['HTTP_REFERER']);
	return $path_part['basename'];
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