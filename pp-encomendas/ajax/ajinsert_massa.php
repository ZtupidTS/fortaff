<?php
include '../includes/allpageaj.php';

$massa = control_post($_GET['massa']);

//vou inserir na DB
$fields = array();
$fields['pp_massa_designacao'] = dbString($massa);
massaInsert($fields);
unset($fields);

echo 'ok';

closeDataBase();
?>