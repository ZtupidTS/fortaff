<?php
	require_once '../includes/utils.php';
	require_once rootPath('includes/sijo/html_header.php', 1);
	require_once rootPath('includes/sijo/master_header.php', 1);
?>
<?php
	$success = false;
	if (isset($_GET['code'])) {
		$success = visitanteSetActive($_GET['code']);
	}
	
	if ($success) {
?>
	<div class="informationmsg">Utilizador activado com sucesso.</div>
<?php
	} else {
?>
	<div class="warningmsg">Não foi possível activar o utilizador!</div>
<?php
	}
?>
<?php
	require_once rootPath('includes/sijo/master_footer.php', 1);
?>