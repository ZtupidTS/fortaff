<?php
	session_start();
	include '../includes/database/jo_db.php';
?>
<?php
	if (isset($_GET['id_delegacao'])) {
		$d = delegacaoGet($_GET['id_delegacao']);
		echo $d['id_pais'];
	}
?>
<?php
	closeDataBase();
?>