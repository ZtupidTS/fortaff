<?php
	session_start();
	include '../includes/database/jo_db.php';
?>
<?php
	if (isset($_GET['id_modalidade'])) {
		$m = modalidadeGet($_GET['id_modalidade']);
		echo $m['tipo'];
	}
?>
<?php
	closeDataBase();
?>