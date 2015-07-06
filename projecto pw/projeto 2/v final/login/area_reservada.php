<?php 
session_start(); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="../css/global.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico">
	</head>
	
	<body>

		<!-- Estrutura -->
		<div class="estrutura">
		<!-- cabeçalho -->
		<?php include '../includes/cabecalho_login.php';?>		
		<!-- corpo -->
		<div class="conteudo">
			<h1 class="titulo">Bem-Vindo ao Sistema de Gestão de Informação dos Jogos Olímpicos</h1>
			<h2 class="titulo">Iniciar Sessão</h2>
			
			<form method="post" action="verificacao_login.php">
				<table class="tabela">	
					<tr>
						<td class="username">Nome de Utilizador:</td> 
						<td><input type="text" name="login" class="frm" onblur="this.className='frm'" onfocus="this.className='frm-on' maxlength="30" required"></td>
					</tr>
					<tr>
						<td class="password">Palavra-Passe:</td> 
						<td><input type="password" name="password" class="frm" onblur="this.className='frm'" onfocus="this.className='frm-on' maxlength="30" required"></td>

					</tr>
				</table>
				<input type="submit" name="entrar" value="Entrar" class="botao">
				<input type="reset" name="apagar" value="Cancelar"  class="botao"><br>
				<p class="link_password"><a href="recuperar_password.php">Recuperar Palavra-Passe</a>
				<a href="alterar_password.php">Alterar Palavra-Passe</a><br>
				<a href="../index.php">Página Principal</a><br>
				</p>
			</form>
		</div>
		
		<!-- em baixo -->		
		<?php include '../includes/rodape.php';?>
		
		<!-- mensagem popup -->		
		<?php include '../includes/mensagem_popup.php';?>
				
		</div>
	</body>
</html>