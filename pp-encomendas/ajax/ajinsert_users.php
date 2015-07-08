<?php
include '../includes/allpageaj.php';

$login = control_post($_GET['login']);
$password = control_post($_GET['password']);

//vou inserir na DB
$fields = array();
$fields['pp_us_name'] = dbString($login);
$fields['pp_us_password'] = dbString($password);
usersInsert($fields);
unset($fields);

echo 'ok';

closeDataBase();
?>