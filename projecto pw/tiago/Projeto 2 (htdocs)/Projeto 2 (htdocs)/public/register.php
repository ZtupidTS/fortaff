<?php
	require_once '../includes/utils.php';
	require_once rootPath('includes/sijo/html_header.php', 1);
	require_once rootPath('includes/sijo/master_header.php', 1);
	require_once '../includes/mail/utils.phpmailer.php';
	require_once '../includes/mail/template.php';
?>
<?php
	$erro = false;
	
	//Guarda o novo utilizador submetido
	if (isset($_POST["save"])) {
	
		$fields = array();	
		$fields['id_visitante'] = -1;
		$fields['nome'] = dbString($_POST['nome']);
		$fields['status'] = dbString($_POST['status']);
		$fields['password'] = dbString($_POST['password']);
		$fields['nif'] = dbString($_POST['nif']);
		$fields['morada'] = dbString($_POST['morada']);
		$fields['telemovel'] = dbString($_POST['telemovel']);
		$fields['email'] = dbString($_POST['email']);
		$fields['sexo'] = dbString($_POST['sexo']);
		
		visitanteInsert($fields);
		
		$body = templateNewUser($fields['id_visitante'], $_POST['email'], $_POST['password'], $_POST['nome']);
		$obj = createMailJO($_POST['email'], "Novo utilizador", $body);
		
		if ($obj->SendAndClose()) {
			header("location: index.php");
			exit();
		} else {
			visitanteDelete($fields['id_visitante']);
			$erro = true;
		}
	}

	if ($erro) {
?>
	<div class="errornmsg">Não foi possível criar o utilizador.</div>
<?php
	}
?>
<h1 class="header_h1">Novo Utilizador</h1>
<form name="user" action="register.php" method="post">
	
	<table>
		<tr>
			<td>Nome:</td>
			<td>
				<input type="hidden" name="id_visitante" value="-1" />
				<input type="hidden" name="status" value="N" />
				<input type="text" name="nome" />
			</td>
		</tr>
		<tr>
			<td>Sexo:</td>
			<td>
				<label for="rbtMasculino">Masculino</label>
				<input id="rbtMasculino" type="radio" name="sexo" value="M" />
				<label for="rbtFeminino">Feminino</label>
				<input id="rbtFeminino" type="radio" name="sexo" value="F" />
			</td>
		</tr>
		<tr>
			<td>Morada:</td>
			<td>
				<input type="text" name="morada" />
			</td>
		</tr>
		<tr>
			<td>Email:</td>
			<td>
				<input type="text" name="email" />
			</td>
		</tr>
		
		<tr>
			<td>Telemóvel:</td>
			<td>
				<input type="text" name="telemovel" />
			</td>
		</tr>
		<tr>
			<td>NIF:</td>
			<td>
				<input type="text" name="nif" />
			</td>
		</tr>
		<tr>
			<td>Password:</td>
			<td>
				<input type="password" name="password" />
			</td>
		</tr>
	</table>
	<input type="submit" name="save" value="Submeter" />
</form>
<?php
	require_once rootPath('includes/sijo/master_footer.php', 1);
?>