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
			<?php include '../includes/cabecalho.php';?>
			
			<!-- menu -->
			<?php include '../includes/menu_escolha_co.php';?>
			
			<!-- corpo -->
			<div id="conteudo_acrescentar">
				<?php 		
				include '../includes/ligacao.php';
				if(isset($_POST['cod_prova']))
				{
					$escolha_prova = mysql_query("SELECT * FROM prova WHERE cod_prova='$_POST[cod_prova]'");
					$dados = mysql_fetch_array($escolha_prova);
					$_SESSION['prova_a_alterar'] = $dados['cod_prova'];
				}else{
					$escolha_prova = mysql_query("SELECT * FROM prova WHERE cod_prova='$_SESSION[prova_a_alterar]'");
					$dados = mysql_fetch_array($escolha_prova);
				}
				?>
				<form method="post" action="verif_alt_prova_co.php">
					<table>
						<p>Alterar Prova:</p>
						<tr>
							<td>Codigo da prova:</td> 
							<td style="visibility:hidden; display:none"><input type="text" name="cod_prova" value="<?php echo $dados['cod_prova']; ?>"></td>
							<td><?php echo $dados['cod_prova']; ?></td>
						</tr>
						<tr>
							<td>Tipo de modalidade:</td> 
							<td><?php include '../includes/select_modalidade.php'; ?></td>
						</tr>
						<tr>
							<td>Local:</td> 
							<td><input name="local" type="text" value="<?= $dados['local'];?>" maxlength="30" required class="form"></td>
						</tr>
						<tr>
							<td>Data:</td> 
							<td>
								<?php 
								require_once '../funcao/funcao_formulario.php';
								$data_array = dividir_data($dados['data']);
								$_SESSION['dia'] = $data_array[2];
								$_SESSION['mes'] = $data_array[1];
								$_SESSION['ano'] = $data_array[0];
								include '../includes/dia.php';
								include '../includes/mes.php';
								?>
								<select name="ano"><option value="2012">2012</option>
							</td>
						</tr>
						<tr>
							<td>Hora de inicio:</td> 
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
							<td>Duração:</td> 
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
						<tr>
							<td>Nome do Juíz:</td> 
							<td><input name="nome_juiz" type="text" value="<?= $dados['nome_juiz']; ?>" maxlength="30" required class="form"></td>
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
					<input class="botao" name="enviar" type="submit" value="Alterar" >
					<input class="botao" type="reset" name="limpar" value="Limpar Campos" >
					<input class="botao" type="button" value="Voltar às Provas" onclick="window.location.href='provas_co.php'" >
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