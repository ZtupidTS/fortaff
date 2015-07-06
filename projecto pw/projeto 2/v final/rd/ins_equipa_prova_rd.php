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
		<link rel="shortcut icon" href="../images/ico.ico" >
		<script type="text/javascript">
		function Acrescenta(codequipa,codprova)
		{
			if(confirm('Deseja inscrever a equipa nº '+codequipa+' na prova nº '+codprova+' ?'))
			{
				window.location.href = "verif_acr_eq_prova_rd.php?cod_equipa="+codequipa+"&cod_prova="+codprova;
			}
		}
		function Elimina(codequipa,codprova)
		{
			if(confirm('Deseja retirar a equipa nº '+codequipa+' da prova nº '+codprova+' ?'))
			{
				window.location.href = "verif_el_eq_prova_rd.php?cod_equipa="+codequipa+"&cod_prova="+codprova;
			}
		}
		</script>
	</head>
	
		<body>
			<div class="estrutura">
				<!-- cabeçalho -->
				<?php include '../includes/cabecalho_rd.php';?>
				
				<!-- menu a direita -->
				<?php include '../includes/bandeira.php';?>	

				<!-- corpo -->
				<div class="estrutabela">
					
					<!-- só dá depois de a equipa ser validada pelo co -->
					<p class="altera_titulo">Inscrever Equipas Numa Prova :</p>	
					<?php
					include '../includes/ligacao.php';
					$db = mysql_query("SELECT * FROM associar_eq_prova WHERE cod_delegacao = '$_SESSION[cod_delegacao_utilizador]'");
					?>
					<table class="tabela">
						<tr>
							<th>Nº Equipa</th>
							<th>Nome Modalidade</th>
							<th>Categoria</th>
							<th>Inscrever</th>
						</tr>
						<?php
						$entrou_no_ciclo = false;
						while($dados = mysql_fetch_array($db))
						{
							include '../includes/limit10.php';
							#aqui vejo se a data da prova daquela equipa é superior a 10, caso seja vai para a tabela
							if($data_devolvida_limit10 > 10)
							{?>
								<tr>
									<td><?php echo $dados['cod_equipa']; ?></td>
									<td><?php echo $dados['nome_modalidade']; ?></td>
									<td><?php include '../includes/sexo_imagem.php';?></td>
									<!-- ascrescentar equipa na prova -->
									<td><button class="botão_opções" type="button" onclick="Acrescenta('<?= $dados['cod_equipa'];?>','<?= $dados['cod_prova'];?>')"><img src="../images/add.png" name="Acrescentar" alt="Acrescentar" title="Acrescentar"/></button></td>
								</tr>
								<?php
								$entrou_no_ciclo = true;
							}
						}// fim do ciclo para escrever os dados na tabela
						if(!($entrou_no_ciclo))
						{?>
							<td rowspan="3" colspan="4">De momento não existem equipas inscritas ou o prazo de inscrições já expirou.</td><?php
						}
						#mysql_close($conexao);
						?>
					</table>
					<p class="altera_titulo">Equipa Inscritas :</p>	
					<?php
					include '../includes/ligacao.php';
					$db = mysql_query("SELECT * FROM eq_acrescentado_a_prova WHERE cod_delegacao = '$_SESSION[cod_delegacao_utilizador]'");
					?>
					<table class="tabela">
						<tr>
							<th>Nº Equipa</th>
							<th>Nome Modalidade</th>
							<th>Categoria</th>
							<th>Retirar da Prova</th>
						</tr>
						<?php
						$entrou_no_ciclo = false;
						while($dados = mysql_fetch_array($db))
						{
							$entrou_no_ciclo = true;
							?>
							<tr>
								<td><?php echo $dados['cod_equipa']; ?></td>
								<td><?php echo $dados['nome_modalidade']; ?></td>
								<td><?php include '../includes/sexo_imagem.php';?></td>
								<!-- eliminar equipa da prova -->
								<?php
								include '../includes/limit10.php';
								if($data_devolvida_limit10 > 10)
								{?>
									<td><button class="botão_opções" type="button" onclick="Elimina('<?= $dados['cod_equipa'];?>','<?= $dados['cod_prova'];?>')"><img src="../images/eliminar.png" name="Retirar da Prova" alt="Retirar da Prova" title="Retirar da Prova"/></button></td>
								<?php
								}else{?>
									<td></td>
									<?php
								}?>
							</tr>
							<?php
						}// fim do ciclo para escrever os dados na tabela
						if(!($entrou_no_ciclo))
						{?>
							<td rowspan="3" colspan="4">De momento não existem equipas inscritas ou o prazo de inscrições já expirou.</td><?php
						}
						#mysql_close($conexao);
						?>
					</table>
					<!-- os botões -->
					<input type="button" value="Actualizar" onclick="window.location.href='ins_equipa_prova_rd.php'" class="botao">	
					<input type="button" value="Voltar as equipas" onclick="window.location.href='area_gestao_rd.php'" class="botao">	
				</div>	
				
				<!-- em baixo --> 
				<?php include '../includes/rodape_rd.php';?>
				
				<!-- include para a mensagem popup -->
				<?php include '../includes/mensagem_popup.php';?>
				
			</div>	
		</body>
</html>