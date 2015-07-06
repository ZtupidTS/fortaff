<?php
if(isset($_GET['css']) && isset($_GET['url']))
{
	setcookie('css', 'css/estilo_'.$_GET['css'].'.css', time() + 365*24*3600, null, null, false, true);
}
header('Location: '.$_GET['url']);
?>