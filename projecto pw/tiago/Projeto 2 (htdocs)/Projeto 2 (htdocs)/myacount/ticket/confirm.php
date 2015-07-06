<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
?>
<?php

	$error = false;
	
	if (isset($_GET['code']) && isset($_GET['checksum'])) {
	
		if (md5("ACCEPT" . $_GET['code']) == $_GET['checksum']) {
			$b = bilheteGet($_GET['code']);
			if ($b['status'] == 'I') {
				bilheteUpdateStatus($_GET['code'], 'C');
			} else {
				$error = true;
			}
		} else if (md5("REJECT" . $_GET['code']) == $_GET['checksum']) {
				bilheteUpdateStatus($_GET['code'], 'X');
		} else {
			$error = true;
		}
	} else {
		$error = true;
	}
	
	if ($error) {
?>
	<div class="errormsg" >Não foi possivel confirmar o bilhete.</div>
<?php
	} else {
?>
	<div class="informationmsg" >Operação realizada com sucesso.</div>
<?php	
	}
?>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>