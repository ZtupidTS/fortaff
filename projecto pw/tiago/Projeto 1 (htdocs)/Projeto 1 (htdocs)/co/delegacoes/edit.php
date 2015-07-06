<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/html_header.php', 1);
?>
<script type="text/javascript">
	function validationForm() 
	{
		submit = true;
		
		if (document.delegacao.nome_responsavel.value == "") {
			blinkValidator('validatorResponsavel', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorResponsavel');
		}
		
		if (document.delegacao.user.value == "") {
			blinkValidator('validatorUser', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorUser');
		}
		
		if (document.delegacao.password.value == "") {
			blinkValidator('validatorPassword', 150, 5);
			submit = false;
		} else {
			hideValidator('validatorPassword');
		}

		return submit;
	}
	
	function updateCountryFlag()
	{
		$('imgDelegacao').src = '/pw606/img/countries/16/' + $('ipt_delegacao').value + '.png';
	}
						
</script>
<?php
	include_once rootPath('includes/master_header.php', 1);
?>

<?php
	$update = isset($_POST['id_delegacao']);
	$delegacao = null;
	$id_delegacao = "-1";
	$id_pais ="";
	$nome_responsavel = "";
	$status = "V";
	$status_descricao = estadoGetDescricao($status);
	$login ="";
	$password="";
	
	if ($update) {
		$delegacao = delegacaoGet($_POST['id_delegacao']);
		$id_delegacao = $delegacao['id_delegacao'];
		$id_pais = $delegacao['id_pais'];
		$pais_nome = $delegacao['pais_nome'];
		$nome_responsavel = $delegacao['nome_responsavel'];
		$status = $delegacao['status'];
		$status_descricao = $delegacao['status_descricao'];
		$login = $delegacao['login'];
		$password= $delegacao['password'];		
	}
	
	$isPendente = in_array($status, array('D', 'I', 'U'));
	$isRejected = ($status == 'R');
	$isNew = ($id_delegacao == '-1');
	$isValid = ($status == 'V');
?>
<h1 class="header_h1">Delegações</h1>
<form name="delegacao" action="edit_db.php" method="post">
	<table>
		<tr>
			<td>
				<label for="id">ID:</label>
			</td>
			<td>
				<input type="text" id="id" value="<?= $id_delegacao ?>" disabled="disabled" />
				<input type="hidden" name="id_delegacao" value="<?= $id_delegacao ?>" />
			</td>
		</tr>	
		<tr>
			<td>
				<label for="id">Estado:</label>
			</td>
			<td>
				<input type="hidden" name="status" value="<?= $status ?>" />
				<img type="image" src="/pw606/img/status/<?= $status ?>.png"/>
				<?= $status_descricao ?>
			</td>
			<td>
<?php
	if ($isPendente or $isRejected) {
?>
				<input type="submit" name="submeter" value="Aceitar"/>
<?php
		if (!$isRejected) { 
?>
				<input type="submit" name="submeter" value="Rejeitar"/>
<?php
		}
	}
?>
			</td>
		</tr>
		<tr>
			<td>
				<label>País:</label>
			</td>
			<td>
<?php
	if (!$update){
?>
				<img id="imgDelegacao" src="" />
				<select id="ipt_delegacao" name="id_pais" onchange="updateCountryFlag();" >
<?php
		$tabela_paises = paisSemDelegacao(); //tabela países sem delegação
		while ($row = mysql_fetch_array($tabela_paises)) {
?>
					<option value="<?= $row["id_pais"]?>"> <?= $row["nome"]?></option>
<?php
		}
?>
				</select>
				<script type="text/javascript">
					updateCountryFlag();
				</script>
<?php
	} else {
?>	
				<img type="image" src="/pw606/img/countries/16/<?= $id_pais?>.png"/>
				<?= $pais_nome ?>
				<input type="hidden" name="id_pais" value="<?= $id_pais ?>" />
<?php
	}
?>
			</td>
		</tr>
		<tr>
			<td>
				<label>Responsável:</label>
			</td>
			<td>
				<input type="text" name="nome_responsavel" value="<?= $nome_responsavel ?>" />
				<span id="validatorResponsavel" class="validatorField" title="O nome do responsável é de preenchimento obrigatório!">*</span>
			</td>
		</tr>
		<tr>
			<td>
				<label>Utilizador: </label>
			</td>
			<td>
				<input type="text" name="user" value="<?= $login ?>"/>
				<span id="validatorUser" class="validatorField" title="O nome do utilizador é de preenchimento obrigatório!">*</span>
			</td>
		</tr>
		<tr>
			<td>
				<label>Palavra chave: </label>
			</td>
			<td>
				<input id="ipt_password" type="password" name="password" value="<?= $password ?>"/>
				<span id="validatorPassword" class="validatorField" title="A palavra chave é de preenchimento obrigatório!">*</span>
			</td>
			<td>
				<input type="checkbox" value="false" onchange="inputPassword('ipt_password');">Ver caracteres</input>
			</td>
		</tr>
	</table>
<?php
	if ($isValid) {
?>
	<input type="submit" name="submeter" value="Guardar" onclick="return validationForm();" />
<?php
		if (!$isNew) {
?>
	<input type="submit" name="submeter" value="Remover" />
<?php
		}
	}
?>
	<input type="submit" name="submeter" value="Cancelar" />
</form>
<?php
	include_once rootPath('includes/master_footer.php', 1);
?>