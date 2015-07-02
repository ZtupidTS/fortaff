<?php
include '../includes/allpageaj.php';

$recheio = control_post($_GET['recheio']);

//vou inserir na DB
$fields = array();
$fields['pp_recheio_designacao'] = dbString($recheio);
recheioInsert($fields);
unset($fields);

echo 'ok';

closeDataBase();
?>