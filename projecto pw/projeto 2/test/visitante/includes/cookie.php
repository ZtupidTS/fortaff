<?php
#criaчуo do cookie caso nуo existe e ativamos o hhtponly com o ultimo true
if(!isset($_COOKIE['css']))
{
	setcookie('css', 'css/estilo_azul.css', time() + 365*24*3600, null, null, false, true);
	//setcookie('css', 'css/estilo_azul.css');
}
?>