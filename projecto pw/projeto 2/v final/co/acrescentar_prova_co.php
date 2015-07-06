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
		<script language="javascript">
		<?php 
		include '../js/so_preco.js';
		include '../js/lugares_total.js';
		include '../js/mensagempreco.js';
		?>	
		</script>	
	</head>
	
	<body>
		<div id="estrutura">
			<!-- cabeçalho -->
			<?php include '../includes/cabecalho.php'; ?>	
			
			<!-- menu -->
			<?php include '../includes/menu_escolha_co.php';?>
			
			<!-- corpo -->
			<div id="conteudo_acrescentar">
				<form method="post" action="verif_acre_prova_co.php">
					<p> Insira os dados da prova que pretende acrescentar: </p>
					<table>
							<tr>
								<td>Modalidade:</td> 
								<td>
								<?php include '../includes/select_modalidade.php'; ?>
								</td>
							</tr>
							<tr>
								<td>Local:</td>
								<td><input type="text" name="local" size="20" maxlength="30" value="<?= $_SESSION['prova_local'];?>" required class="form"></td>
							</tr>
							<tr>
							<td>Sexo:</td> 
								<td>
									<input type="radio" name="sexo" value="M" id="M" checked/><label for="M"><img src="../images/sexo/sexo_masculino.jpg" /></label>
									<input type="radio" name="sexo" value="F" id="F" /><label for="F"><img src="../images/sexo/sexo_feminino.jpg" /></label>
								</td>
							</tr>
							<tr>
								<td>Data:</td> 
								<td>
									<?php include '../includes/dia.php';?>
									<?php include '../includes/mes.php';?>
									<select name="ano"><option value="2012">2012</option>
								</td>
							</tr>
							<tr>
								<td>Hora de Início:</td> 
								<td>
									<?php 
									$_SESSION['hora'] = 'hora_inicio';
									include '../includes/hora.php';?> :
									<?php 
									$_SESSION['minutos'] = 'minutos_inicio';
									include '../includes/minutos.php';?>
								</td>
							</tr>
							<tr>
								<td>Duração:</td> 
								<td>
									<?php
									$_SESSION['hora'] = 'duracao_hora';
									include '../includes/hora.php';?> :
									<?php
									$_SESSION['minutos'] = 'duracao_minutos';
									include '../includes/minutos.php';?>
								</td>
							</tr>
							<tr>
								<td>Juíz:</td> 
								<td><input type="text" name="nome_juiz" size="20" maxlength="30" value="<?= $_SESSION['prova_nome_juiz'];?>" required class="form"></td>
							</tr>
							<!-- include da tabela preço e lugares total-->
							<?php 
							include '../includes/preco.php';
							include '../includes/lugares_total.php';
							?>

							</tr>
					</table>
					<!-- os botões -->
					<input class="botao" type="submit" name="validar" value="Validar">
					<input class="botao" type="reset" name="limpar" value="Limpar Campos">
					<input class="botao" type="button" value="Voltar às Provas" onclick="window.location.href='provas_co.php'">
				</form>
				
			</div>
					
			<!-- em baixo -->
			<?php include '../includes/rodape.php'; ?>	
			
			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
			
			<!-- popup para o erro do preço -->
			<?php
			if(($_SESSION['erro_preco']))
			{
				echo '<script>MensagemPreco();</script>';
			}
			?>
			
		</div>
	</body>
</html>