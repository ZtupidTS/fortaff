<?php
include '../includes/allpageaj.php';

$id = control_post($_GET['idenc']);

$data = encomendasGetById($_GET['idenc']);

//vou inserir na DB
$fields = array();
$fields['pp_enc_id'] = dbInteger($id);
$fields['pp_enc_enable'] = dbInteger(1);
encomendasUpdate($fields);
unset($fields);

insertmodifencomenda($id, "Encomenda recuperada");

echo 'ok';


closeDataBase();
?>