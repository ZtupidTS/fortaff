<?php
include '../includes/allpageaj.php';

$fields = array();
$fields['id'] = $_POST['id_gr'];
$fields['gr_enable'] = 0;
grepUpdate($fields);
unset($fields);

insertmodifgr($_POST['id_gr'], "Guia eliminada ao pedido do funcionario: " . $_POST['func']);

echo 'ok';

closeDataBase();
?>