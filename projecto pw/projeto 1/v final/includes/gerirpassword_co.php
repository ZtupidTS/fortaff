<?php
$password = md5(uniqid(time(), true));  // uniqid() gera id único junto com as funções md5(); e time(); 
$password = substr($password, 0, 10);  // substr()é  para limitar o comprimento da string de 0 até 10.
?>
