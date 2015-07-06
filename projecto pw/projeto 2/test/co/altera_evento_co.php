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
				<?php 
				include '../includes/ligacao.php';
				if(isset($_POST['cod_evento']))
				{
					$escolha_evento = mysql_query("SELECT * FROM evento WHERE cod_evento='$_POST[cod_evento]'");
					$dados = mysql_fetch_array($escolha_evento);
					$_SESSION['evento_a_alterar'] = $dados['cod_evento'];
				}else{
					$escolha_evento = mysql_query("SELECT * FROM evento WHERE cod_evento='$_SESSION[evento_a_alterar]'");
					$dados = mysql_fetch_array($escolha_evento);
				}
				?>
				<form method="post" action="verif_alt_evento_co.php">
					<p>Alterar Evento:</p>
					<table>
						<tr>
							<td>Codigo do evento:</td> 
							<td style="visibility:hidden; display:none"><input type="text" name="cod_evento" value="<?php echo $dados['cod_evento']; ?>"></td>
							<td><?php echo $dados['cod_evento']; ?></td>
						</tr>
						<tr>
							<td>Designação:</td> 
							<td><input name="designacao" type="text" value="<?= $dados['designacao'];?>" maxlength="30" required class="form"></td>
						</tr>
						<tr>
							<td>Descrição:</td> 
							<td><input name="descricao" type="text" value="<?= $dados['descricao'];?>" maxlength="30" required class="form"></td>
						</tr>
						<tr>
							<td>Data:</td> 
							<td>
							<?php 
							require_once '../funcao/funcao_formulario.php';
							$data_array = dividir_data($dados['data']);
							$_SESSION['dia'] = $data_array[2];
							$_SESSION['mes'] = $data_array[1];
							include '../includes/dia.php';
							include '../includes/mes.php';
							?>
							<select name="ano"><option value="2012">2012</option>
							</td>
						</tr>
						<tr>
							<td>Hora:</td> 
							<td>
							<?php 
							require_once '../funcao/funcao_formulario.php';
							$data_array = dividir_hora($dados['hora_inicio']);
							$_SESSION['hora'] = 'hora_inicio';
							$_SESSION['alt_hora'] = $data_array[0];
							$_SESSION['minutos'] = 'minutos_inicio';
							$_SESSION['alt_minutos'] = $data_array[1];
							include '../includes/hora.php';
							include '../includes/minutos.php';
							?>
							</td>
						</tr>
						<tr>
							<td>Duração Estimada:</td> 
							<td>
							<?php 
							require_once '../funcao/funcao_formulario.php';
							$data_array = dividir_hora($dados['duracao']);
							$_SESSION['hora'] = 'duracao_hora';
							$_SESSION['alt_hora'] = $data_array[0];
							$_SESSION['minutos'] = 'duracao_minutos';
							$_SESSION['alt_minutos'] = $data_array[1];
							include '../includes/hora.php';
							include '../includes/minutos.php';
							?>
							</td>
						</tr>
						<!-- inicializo a minha variavel para o include da tabela preço e lugares total -->
						<?php
						$_SESSION['preco'] = $dados['preco']; 
						include '../includes/preco.php';
						$_SESSION['lugares_total'] = $dados['lugares_total'];
						include '../includes/lugares_total.php';
						?>	
					</table>
					<!-- os botões -->
					<input class="botao" name="Enviar" type="submit" value="Alterar">
					<input class="botao" type="reset" name="Limpar" value="Limpar Campos">
					<input class="botao" type="button" value="Voltar aos Eventos" onclick="window.location.href='eventos_co.php'">
				</form>
			</div>
			<!-- em baixo -->
			<?php include '../includes/rodape.php';?>
			
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