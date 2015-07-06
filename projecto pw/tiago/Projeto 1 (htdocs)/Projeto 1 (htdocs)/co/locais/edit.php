<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
?>
<script type="text/javascript">
	function validationForm() 
	{
		submit = true;
		
		if (document.local.nome.value == "") {
			blinkValidator('validatorNome', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorNome');
		}
		
		if (document.local.descricao.value == "") {
			blinkValidator('validatorDescricao', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorDescricao');
		}
		
		if (!stringIsInteger(document.local.num_lugares.value)) {
			blinkValidator('validatorLotacao', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorLotacao');
		}

		return submit;
	}
</script>
<?php
	include_once rootPath('includes/master_header.php', 1);
?>
<?php
	$update = isset($_POST['id_local']);
	$local = null;
	$id_local = "-1";
	$nome = "";
	$descricao = "";
	$num_lugares = "";
	
	if ($update) {
		$local = localGet($_POST['id_local']);
		$id_local = $local['id_local'];
		$nome = $local['nome'];
		$descricao = $local['descricao'];
		$num_lugares = $local['num_lugares'];
	}
	
	$isNew = ($id_local == '-1');
	
?>
<h1 class="header_h1">Locais</h1>
<form name="local" action="edit_db.php" method="post">
	<table>
		<tr>
			<td>
				<label for="id">ID:</label>
			</td>
			<td>
				<input type="text" id="id" value="<?= $id_local ?>" disabled="disabled" />
				<input type="hidden" name="id_local" value="<?= $id_local ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label>Nome:</label>
			</td>
			<td>
				<input type="text" name="nome" value="<?= $nome ?>" />
				<span id="validatorNome" class="validatorField" title="O nome é de preenchimento obrigatório!">*</span>
			</td>
		</tr>
		<tr>
			<td>
				<label>Descrição:</label>
			</td>
			<td>
				<textarea name="descricao" rows="7" cols="80" ><?= $descricao ?></textarea>
				<span id="validatorDescricao" class="validatorField" title="A descricao é de preenchimento obrigatório!">*</span>
			</td>
		</tr>
		<tr>
			<td>
				<label>Lotação:</label>
			</td>
			<td>
				<input type="text" name="num_lugares" value="<?= $num_lugares ?>"/>
				<span id="validatorLotacao" class="validatorField" title="A lotação tem de ser um valor numérico!">*</span>
			</td>
		</tr>
	</table>

	<input type="submit" name="save" value="Guardar" onclick="return validationForm();" />
<?php
	if (!$isNew) {
?>
	<input type="submit" name="delete" value="Remover" />
<?php
	}
?>
	<input type="submit" name="cancel" value="Cancelar" />
</form>
<?php
	include_once rootPath('includes/master_footer.php', 1);
?>