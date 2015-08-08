<?php
include '../includes/allpageaj.php';

//id_gr='+id_gr+"&rep_mail=
//echo enviamail($_POST['rep_mail'], $_POST['id_gr']);
$fields = array();

$fields['id'] = $_POST['id_gr'];
$fields['date_torep'] = dbString(date('Y-m-d H:i:s', time() - 3600));

grepUpdate($fields);

unset($fields);

insertmodifgr($_POST['id_gr'], "Artigo Levantado pelo reparador");

echo 'ok';

closeDataBase();
?>