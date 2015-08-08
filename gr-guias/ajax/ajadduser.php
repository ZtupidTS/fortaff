<?php
include '../includes/allpageaj.php';

$fields = array();
$fields['us_name'] = dbString($_POST['user']);
$fields['us_enable'] = 1;
loginInsert($fields);
unset($fields);

echo 'ok';

closeDataBase();
?>