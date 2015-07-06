<?php
	require_once '../includes/utils.php';
	include_once rootPath('includes/gijo/html_header.php', 1);
	include_once rootPath('includes/gijo/master_header.php', 1);
?>
<h1 class="header_h1"> Login - RD </h1>
Um utilizador com o perfil RD (Respons�vel Delega��o), depois de autenticado consegue:
<ul>
	<li>
		Visualizar, Adicionar, Actualizar e Remover<sup>(1)</sup>:
		<ul>
			<li>Delega��o<sup>(2)</sup>;</li>
			<li>Equipas<sup>(2)</sup>;</li>
			<li>Atletas/Auxiliares<sup>(2)</sup>;</li>
		</ul>
	</li>
	<li>
		Increver atletas em provas<sup>(3)</sup>;
	</li>
</ul>
<sup>(1)</sup> Qualquer altera��o feita pelo utilizador RD fica pendete at� aprova��o do CO (Comit� Olimpico).<br/>
<sup>(2)</sup> S� pode fazer altera��es at� 30 dia antes do inicio dos Jogos Ol�mpicos.<br/>
<sup>(3)</sup> S� pode fazer altera��es at� 10 dia antes do inicio da Prova.<br/>
<br/>
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
<br/>
<?php
	if (!$user_authenticated) {
?>

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