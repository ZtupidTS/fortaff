<?php
$autologin = true;
if(isset($_COOKIE['login_thegrindteam']))
{
	//setcookie('css', 'css/estilo_azul.css', time() + 365*24*3600, null, null, false, true);
	//setcookie('css', 'css/estilo_azul.css');
        list($login, $password) = explode('||', $_COOKIE['login_thegrindteam']);
        
}else{
    $login = "";
    $password = "";
    $autologin = false;
}
?>