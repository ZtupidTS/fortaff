<?php
include '../includes/allpageaj.php';

$fields = array();
$fields['us_id'] = $_POST['id_user'];
$fields['us_enable'] = 0;
usersUpdate($fields);
unset($fields);


echo 'ok';

closeDataBase();
?>