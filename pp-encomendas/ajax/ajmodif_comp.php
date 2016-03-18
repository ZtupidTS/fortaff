<?php
include '../includes/allpageaj.php';

$id = control_post($_GET['id']);
$newtext = control_post($_GET['newtext']);
$tipo = control_post($_GET['tipo']);

//tipo:
//cob: cobertura
//rec: recheio
//mas: massa

switch ($tipo) {
    case "cob":
        //vou inserir na DB
	$fields = array();
	$fields['pp_cobertura_id'] = dbInteger($id);
	$fields['pp_cobertura_designacao'] = dbString($newtext);	
	coberturaUpdate($fields);
	unset($fields);
        break;
    case "rec":
        //vou inserir na DB
	$fields = array();
	$fields['pp_recheio_id'] = dbInteger($id);
	$fields['pp_recheio_designacao'] = dbString($newtext);	
	recheioUpdate($fields);
	unset($fields);
        break;
    case "mas":
        //vou inserir na DB
	$fields = array();
	$fields['pp_massa_id'] = dbInteger($id);
	$fields['pp_massa_designacao'] = dbString($newtext);	
	massaUpdate($fields);
	unset($fields);
        break;
}

echo 'ok';

closeDataBase();
?>