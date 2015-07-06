<?php
	require_once '../../includes/utils.php';
	require_once rootPath('includes/sijo/html_header.php', 1);
	require_once rootPath('includes/sijo/master_header.php', 1);
	require_once rootPath('myacount/check_login.php', 1);
?>
<?php
	//Salva a sugestão submetida
	if (isset($_POST["save"])) {
	
		$fields = array();	
		$fields['id_sugestao'] = -1;
		$fields['id_visitante'] = dbInteger($_POST['id_visitante']);
		$fields['tipo'] = dbString($_POST['tipo']);
		$fields['data'] = dbDateTime(new DateTime());
		$fields['descricao'] = dbString($_POST['descricao']);
		
		sugestaoInsert($fields);
?>
		<div class="informationmsg">Obrigado pelo seu contributo!</div>
<?php
	}
?>
<h1 class="header_h1">Sugestões</h1>
<form name="sugestao" action="index.php" method="post">
	<input type="hidden" name="id_visitante" value="<?= $current_user['id_visitante'] ?>" />
	<select id="sltTipo" name="tipo">
		<option value="S" >Sugestão</option>
		<option value="C" >Comentário</option>
		<option value="R" >Reclamação</option>
	</select><br/>
	<textarea name="descricao" rows="7" cols="80" maxlength="1000" ></textarea><br/>
	<input type="submit" name="save" value="Submeter" />
</form>
<?php
	require_once rootPath('includes/sijo/master_footer.php', 1);
?>