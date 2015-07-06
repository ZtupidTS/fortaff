<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
	require_once rootPath('webservice/mobile.php', 1);
?>
<h1 class="header_h1">
	Relatório de Envio de SMS
</h1>
<?php
	$success = false;
	$success = sendMessage($_POST['telemovel'], $_POST['smstext']);
	
	if (false || $success) {
		$ret = "Mensagem envida com sucesso para o número: " . $_POST['telemovel'] . ".";
		$class = "informationmsg";
	} else {
		$ret = "Ocurreu um erro no envio da mensagem para o número: " . $_POST['telemovel'] . ".";
		$class = "errormsg";
	}
?>
<div class="<?= $class ?>"><?= $ret ?></div>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>