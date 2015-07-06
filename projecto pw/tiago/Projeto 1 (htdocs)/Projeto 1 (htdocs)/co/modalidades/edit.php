<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
?>
<script type="text/javascript">
	function validationForm() 
	{
		if (document.modalidade.nome.value == "") {
			blinkValidator('validatorNome', 150, 5);
			return false;
		}
		return true
	}	
</script>
<?php
	include_once rootPath('includes/master_header.php', 1);
	require_once rootPath('co/check_login.php', 1);
?>
<?php
	$update = isset($_POST['id_modalidade']);
	$mod = null;
	$id_modalidade = "-1";
	$nome = "";
	$tipo = "S";
	
	if ($update) {
		$mod = modalidadeGet($_POST['id_modalidade']);
		$id_modalidade = $mod['id_modalidade'];
		$nome = $mod['nome'];
		$tipo = $mod['tipo'];
	}
	
	$isNew = ($id_modalidade == '-1');
?>
<h1 class="header_h1">Modalidades</h1>
<form name="modalidade" action="edit_db.php" method="post">
	<table>
		<tr>
			<td>
				<label for="id">ID:</label>
			</td>
			<td>
				<input type="text" class="textfield" value="<?= $id_modalidade ?>" disabled="disabled" />
				<input type="hidden" name="id_modalidade" value="<?= $id_modalidade ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="name">Nome:</label>
			</td>
			<td>
				<input type="text" name="nome" id="name" value="<?= $nome ?>" />
				<span id="validatorNome" class="validatorField" title="O nome é de preenchimento obrigatório!">*</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="type">Tipo:</label>
			</td>
			<td>
				<select id="slt_Tipo" name="tipo">
					<option value="S">Singular</option>
					<option value="C">Colectivo</option>
				</select>
				<script type="text/javascript">
					selectSelectedValue(document.getElementById("slt_Tipo"), "<?= $tipo ?>");
				</script>
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