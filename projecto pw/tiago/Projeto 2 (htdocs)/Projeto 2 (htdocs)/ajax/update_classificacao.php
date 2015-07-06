<?php
	session_start();
	include '../includes/database/jo_db.php';
?>
<?php
	if (isset($_GET['id_classificacao']) and isset($_GET['classificacao'])) {
		provaClassificacaoUpdateClassificacao($_GET['id_classificacao'], $_GET['classificacao']);
		echo "ok";
	}
?>
<?php
	closeDataBase();
?>