<?php
$password = md5(uniqid(time(), true));  // uniqid() gera id �nico junto com as fun��es md5(); e time(); 
$password = substr($password, 0, 10);  // substr()�  para limitar o comprimento da string de 0 at� 10.
?>
