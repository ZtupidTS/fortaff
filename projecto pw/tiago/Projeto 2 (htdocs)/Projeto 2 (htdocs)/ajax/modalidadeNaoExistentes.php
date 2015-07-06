<?php
	session_start();
	include '../includes/utils.php';
	include '../includes/database/jo_db.php';
?>
<?php

	if (isset($_GET['id_delegacao'])) {
		
		$mods = modalidadeNaoExistente($_GET['id_delegacao']);
		$dados = array();
		
		while ($row = foreachRow($mods)) {
			$dados[] = array('id_modalidade' => $row['id_modalidade'], 'nome' => $row['nome']);
		}
		
		$resposta = ujson_encode($dados);
		echo $resposta;
	}
	
?>
<?php
	closeDataBase();
?>