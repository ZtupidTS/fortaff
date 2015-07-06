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
			<h1 class="titulo">Alterar Palavra-Passe</h1>
			
			<form method="post" action="verif_alt_pass.php">
				<table class="tabela">	
					<tr>
						<td class="password">Nome de Utilizador:</td> 
						<td><input type="text" name="login" class="frm" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="30" required></td>
					</tr>
					<tr>
						<td class="password">Antiga Palavra-Passe:</td> 
						<td><input type="password" name="old_password" class="frm" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="60" required></td>
					</tr>
					<tr>
						<td class="password">Nova Palavra-Passe:</td> 
						<td><input type="password" name="password" class="frm" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="30" required></td>
					</tr>
					<tr>
						<td class="password">Confirmar Palavra-Passe:</td> 
						<td><input type="password" name="password2" class="frm" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="30" required></td>
					</tr>
				</table>
				<input type="submit" name="Submeter" value="Submeter" class="botao">
				<input type="button" class="botao" value="Voltar ao Iniciar Sessão" onclick="window.location.href='area_reservada.php'">
			</form>
		</div>
		
		<!-- em baixo -->		
		<?php include '../includes/rodape.php';?>
		
		<!-- mensagem popup -->		
		<?php include '../includes/mensagem_popup.php';?>
				
		</div>
	</body>
</html>