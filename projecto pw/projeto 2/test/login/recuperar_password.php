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
			<h1 class="titulo">Recuperar Palavra-Passe</h1>
			
			<form method="post" action="verif_recup_pass.php">
				<table class="tabela">	
					<tr>
						<td class="password">E-mail:</td> 
						<td><input type="text" name="email" class="frm" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="60" required></td>
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