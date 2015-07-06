<?php
	require_once '../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
?>
<h1 class="header_h1"> Login - CO </h1>
<br/>
Um utilizador com o perfil CO (Comit� Ol�mpico), depois de autenticado consegue:
<ul>
	<li>
		Visualizar, Adicionar, Actualizar e Remover:
		<ul>
			<li>Delega��es;</li>
			<li>Modalidades;</li>
			<li>Equipas/Elementos;</li>
			<li>Provas/Classifica��es;</li>
			<li>Eventos;</li>
		</ul>
	</li>
	<li>Validar (aceitar/rejeitar) qualquer informa��o alterada pelos utilizadores do perfil RD (Respons�vel Delega��o).</li>
</ul>
<?php
	if (isset($_SESSION['_POST']))
	{
		$post = $_SESSION['_POST'];
		$err = $post['err'];
		$user = $post['user'];
		if ($err == 1){
			echo "<div class=\"warningmsg\">Palavra chave incorrecta ou o utilizador '$user' n�o existe!</div>";
		}
		unset($_SESSION['_POST']);
	}
?>
<?php
	if (!$user_authenticated) {
?>
<br/>
<form action="authenticate.php" method="post">
	<fieldset>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td>Utilizador: </td>
				<td>
					<input type="text" name="user" />
				</td>
			</tr>
			<tr>
				<td>Palavra Chave:&nbsp;&nbsp;</td>
				<td>
					<input id="ipt_password" type="password" name="password" />
					<input type="checkbox" value="false" onchange="inputPassword('ipt_password');">Ver caracteres</input>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="submit" value="Login" />
				</td>
			</tr>
		</table>
	</fieldset>
</form>
<?php
	}
?>
<?php
	include_once rootPath('includes/gijo/master_footer.php', 1);
?>