<?php 
session_start(); 
include '../includes/test_intruso_rd.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="../css/estilo_rd.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico">
	</head>
	<body>
		<div class="estrutura">
			<!-- cabeçalho -->
			<?php include '../includes/cabecalho_rd.php';?>
						
			
			<?php include '../includes/bandeira.php'; ?>
				
			<!-- corpo -->
			<div class="estrutabela">
			<form method="post" action="verificacao_acre_equipa_rd.php">
				<table>
					<p> Escolha uma modalidade: </p>
					<tr>
						<td>Modalidade:</td> 
						<td>
							<?php include '../includes/select_modalidade.php'; ?>
						</td>
					</tr>
					<tr>
						<td>Tipo:</td> 
						<td>
							<input type="radio" name="sexo" value="M" id="M" checked/><label for="M"><img src="../images/sexo/sexo_masculino.jpg" /></label>
							<input type="radio" name="sexo" value="F" id="F" /><label for="F"><img src="../images/sexo/sexo_feminino.jpg" /></label>
						</td>
					</tr>
				</table>
				<input type="submit" name="validar" value="Validar" class="botao">
				<input type="button" value="Voltar as Equipas" onclick="window.location.href='area_gestao_rd.php'" class="botao">
			</form>
			</div>	
			
			<!-- em baixo -->
			<?php include '../includes/rodape_rd.php'; ?>	
		
			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
			
		</div>	
	</body>
</html>