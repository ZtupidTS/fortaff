<?php
include '../includes/allpageaj.php';

$fields = array();
$fields['rep_id'] = $_POST['id_rep'];
echo $_POST['id_rep'];
$fields['rep_enable'] = 0;
reparadorUpdate($fields);
unset($fields);

$fields = array();
$fields['rep_id'] = $_POST['id_rep'];
$fields['us_id'] = $_SESSION['iduser'];
$fields['modif_date'] = dbString(date('Y-m-d H:i:s', time() - 3600));
$fields['modif_text'] = dbString("Reparador eliminado");
modifrepInsert($fields);
unset($fields);	

echo 'ok';

closeDataBase();
?>