<?php
	require_once '../includes/utils.php';
	require_once rootPath('includes/sijo/html_header.php', 1);
	require_once rootPath('includes/sijo/master_header.php', 1);
	require_once rootPath('myacount/check_login.php', 1);
?>
<?php
	//Guarda o novo utilizador submetido
	if (isset($_POST["save"])) {
	
		$fields = array();	
		$fields['id_visitante'] = dbInteger($_POST['id_visitante']);
		$fields['nome'] = dbString($_POST['nome']);
		$fields['status'] = dbString($_POST['status']);
		$fields['password'] = dbString($_POST['password']);
		$fields['nif'] = dbString($_POST['nif']);
		$fields['morada'] = dbString($_POST['morada']);
		$fields['telemovel'] = dbString($_POST['telemovel']);
		$fields['email'] = dbString($_POST['email']);
		$fields['sexo'] = dbString($_POST['sexo']);
		
		visitanteUpdate($fields);
		$_SESSION['loginVsNeedUpdate'] = true;
		
		//TODO: Enviar email para o utilizador para confirmação de conta
		header("location: ../index.php");
		exit();
	}
	
?>
<h1 class="header_h1">A minha conta</h1>
<form name="user" action="" method="post">
	<table>
		<tr>
			<td>Nome:</td>
			<td>
				<input type="hidden" name="id_visitante" value="<?= $current_user['id_visitante'] ?>" />
				<input type="hidden" name="status" value="N" />
				<input type="text" name="nome" value="<?= $current_user['nome'] ?>" />
			</td>
		</tr>
		<tr>
			<td>Sexo:</td>
			<td>
				<label for="rbtMasculino">Masculino</label>
				<input id="rbtMasculino" type="radio" name="sexo" value="M" />
				<label for="rbtFeminino">Feminino</label>
				<input id="rbtFeminino" type="radio" name="sexo" value="F" />
				<script type="text/javascript">
					setCheckedValue(document.user.sexo, "<?= $current_user['sexo'] ?>");
				</script>
			</td>
		</tr>
		<tr>
			<td>Morada:</td>
			<td>
				<input type="text" name="morada" value="<?= $current_user['morada'] ?>" />
			</td>
		</tr>
		<tr>
			<td>Email:</td>
			<td>
				<input type="text" name="email" value="<?= $current_user['email'] ?>" />
			</td>
		</tr>
		<tr>
			<td>Telemóvel:</td>
			<td>
				<input type="text" name="telemovel" value="<?= $current_user['telemovel'] ?>" />
			</td>
		</tr>
		<tr>
			<td>NIF:</td>
			<td>
				<input type="text" name="nif" value="<?= $current_user['nif'] ?>" />
			</td>
		</tr>
		<tr>
			<td>Password:</td>
			<td>
				<input id="iptpassword" type="password" name="password" value="<?= $current_user['password'] ?>" />
				<input type="checkbox" value="false" onchange="inputPassword('iptpassword');">Ver caracteres</input>
			</td>
		</tr>
	</table>
	<input type="submit" name="save" value="Submeter" />
</form>
<?php
	require_once rootPath('includes/sijo/master_footer.php', 1);
?>