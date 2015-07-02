<?php
include '../includes/allpageaj.php';

$cobertura = control_post($_GET['cobertura']);

//vou inserir na DB
$fields = array();
$fields['pp_cobertura_designacao'] = dbString($cobertura);
coberturaInsert($fields);
unset($fields);

echo 'ok';

closeDataBase();
?>