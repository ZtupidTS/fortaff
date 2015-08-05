<?php
include '../includes/allpageaj.php';

$id = control_post($_GET['idenc']);

//vou inserir na DB
$fields = array();
$fields['pp_enc_id'] = dbInteger($id);
$fields['pp_enc_enable'] = dbInteger(0);
encomendasUpdate($fields);
unset($fields);

insertmodifencomenda($id, "Encomenda eliminada");

echo 'ok';

closeDataBase();
?>