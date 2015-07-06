<?php
function recupera_url()
{
	$path_part = pathinfo($_SERVER['HTTP_REFERER']);
	return $path_part['basename'];
}
?>