<?php
include '../includes/allpageaj.php';

$fields2 = array();
$fields2['gr_id'] = $_POST['id'];
$fields2['us_id'] = $_SESSION['iduser'];
$fields2['modif_date'] = dbString(date('Y-m-d H:i:s', time() - 3600));
$fields2['modif_text'] = dbString($_POST['why']);

modifgrInsert($fields2);
unset($fields2);

echo 'ok';
closeDataBase();
?>