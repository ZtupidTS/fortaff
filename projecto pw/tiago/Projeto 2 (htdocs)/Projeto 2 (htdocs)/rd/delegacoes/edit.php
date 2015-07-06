<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);

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
</script>
<?php
	include_once rootPath('includes/gijo/master_header.php', 1);
	require_once rootPath('rd/check_login.php', 1);
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
	$isToRemove = ($status == 'D');
	$isToInsert = ($status == 'I')
	
?>

<html>
	<h1 class="header_h1">Delegações</h1>
</html>

<p>
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
			</tr>
<!--País  -->
			<tr>
				<td>
					<label>País:</label>
				</td>
				<td>
					<?php
					if (!$update){
						?>
						<select name="id_pais">
						<?php
							$tabela_paises = paisSemDelegacao(); //tabela países sem delegação
							while ($row = mysql_fetch_array($tabela_paises)) {
							?>
							<option value="<?= $row["id_pais"]?>"> <?= $row["nome"]?></option>
							<?php
							}
						?>
						</select>
						<?php
						}else{
					?>	
							<img type="image" src="/pw606/img/countries/16/<?= $id_pais?>.png"/>
							<?= $pais_nome ?>
							<input type="hidden" name="id_pais" value="<?= $id_pais ?>" />
						<?php
						}
					?>


				</td>
			</tr>
<!--Responsável-->
			<tr>
				<td>
					<label>Responsável:</label>
				</td>
				<td>
					<input type="text" name="nome_responsavel" value="<?= $nome_responsavel ?>" />
					<span id="validatorResponsavel" class="validatorField" title="O nome do responsável é de preenchimento obrigatório!">*</span>
				</td>
			</tr>
<!--User-->
			<tr>
				<td>
					<label>Utilizador: </label>
				</td>
				<td>
					<input type="text" value="<?= $login ?>" disabled="disabled"/>
					<input type="hidden" name="user" value="<?= $login ?>"/>
					<span id="validatorUser" class="validatorField" title="O nome do utilizador é de preenchimento obrigatório!">*</span>
				</td>
			</tr>
<!--Password-->
			<tr>
				<td>
					<label>Palavra chave: </label>
				</td>
				<td>
					<input id="ipt_password" type="password" name="password" value="<?= $password ?>"/>
					<span id="validatorPassword" class="validatorField" title="A palavra chave é de preenchimento obrigatório!">*</span>
					<input type="checkbox" value="false" onchange="inputPassword('ipt_password');">Ver caracteres</input>
				</td>
			</tr>

		</table>
		<input type="submit" name="submeter" value="Guardar" onclick="return validationForm();" />
<?php
	if (!$isToRemove) {
?>
		<input type="submit" name="submeter" value="Remover" />
<?php
	}
?>
		<input type="submit" name="submeter" value="Cancelar" />
	</form>
</p>


<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>