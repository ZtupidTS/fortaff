<?php
include '../includes/allpageaj.php';

$fields = array();
$fields['id'] = dbInteger($_POST['id_gr']);
$fields['art_valorcamento'] = dbFloat($_POST['valor']);
grepUpdate($fields);
unset($fields);

insertmodifgr($_POST['id_gr'], "Inserção do valor do orçamento");
echo 'ok';

closeDataBase();
?>