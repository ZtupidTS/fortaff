<?php 
session_start();
include '../includes/test_intruso_co.php'; 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="../css/estilo_co.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico" >
	</head>
	
	<body>
		<div id="estrutura">
			<!-- cabeçalho -->
			<?php include '../includes/cabecalho.php'; ?>	
			
			<!-- menu -->
			<?php include '../includes/menu_escolha_co.php';?>
			
			<!-- corpo -->
			<div id="conteudo_acrescentar">
				<form method="post" action="verif_acre_modalidade_co.php">
					<p> Insira os dados da modalidade que pretende acrescentar: </p>
					<table>
						<tr>
							<td>Modalidade:</td> 
							<td><input type="text" name="nome_modalidade"  maxlength="30" required class="form"></td>
						</tr>
						<tr>
							<td>Tipo:</td> 
							<td>
							<select name="tipo">
							<option value="C">Coletiva</option>
							<option value="I">Individual</option>			
							</select>
							</td>
						</tr>
					</table>
					<input class="botao" type="submit" name="validar" value="Validar" >
					<input class="botao" type="reset" name="limpar" value="Limpar Campos" >
					<input class="botao" type="button" value="Voltar às Modalidades" onclick="window.location.href='modalidade_co.php'" >
				</form>
			</div>
						
			<!-- em baixo -->
			<?php include '../includes/rodape.php'; ?>	
			
			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
		</div>
	</body>
</html>