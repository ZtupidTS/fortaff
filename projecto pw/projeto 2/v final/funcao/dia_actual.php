<?php
function dia_actual()
{
	$dia_atual = time();
	$dia = date("Y-m-d", $dia_atual);
	return $dia;
}
?>
