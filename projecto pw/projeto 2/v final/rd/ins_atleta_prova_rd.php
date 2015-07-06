<?php
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/css_rd.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="<?= $css;?>" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico" >
		<script type="text/javascript">
		function Acrescenta(codelemento,codprova)
		{
			if(confirm('Deseja acrescentar o atleta nº '+codelemento+' na prova nº '+codprova+' ?'))
			{
				window.location.href = "verif_acr_atl_prova_rd.php?cod_elemento_equipa="+codelemento+"&cod_prova="+codprova;
			}
		}
		function Elimina(codelemento,codprova)
		{
			if(confirm('Deseja retirar o atleta nº '+codelemento+' da prova nº '+codprova+' ?'))
			{
				window.location.href = "verif_el_atl_prova_rd.php?cod_elemento_equipa="+codelemento+"&cod_prova="+codprova;
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
						
					<p class="altera_titulo">Inscrever Atletas Numa Prova :</p>	
					<?php
					include '../includes/ligacao.php';
					$db = mysql_query("SELECT * FROM associar_atl_prova WHERE cod_equipa = '$_SESSION[cod_equipa]' and cod_delegacao = '$_SESSION[cod_delegacao_utilizador]'");
					?>
					<table class="tabela">
						<tr>
							<th>Nº Atleta</th>
							<th>Nome</th>
							<th>Acrescentar</th>
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
									<td><?php echo $dados['cod_elemento_equipa']; ?></td>
									<td><?php echo $dados['nome']; ?></td>
									<!-- ascrescentar equipa na prova -->
									<td><button class="botão_opções" type="button" onclick="Acrescenta('<?= $dados['cod_elemento_equipa'];?>','<?= $dados['cod_prova'];?>')"><img src="../images/add.png" name="Acrescentar" alt="Acrescentar" title="Acrescentar"/></button></td>
								</tr>
								<?php
								$entrou_no_ciclo = true;
							}
						}// fim do ciclo para escrever os dados na tabela
						if(!($entrou_no_ciclo))
						{?>
							<td rowspan="3" colspan="7">De momento não existem atletas inscritos ou o prazo de inscrições já expirou.</td><?php
						}
						#mysql_close($conexao);
						?>
					</table>
					<p class="altera_titulo">Atletas Inscritos :</p>	
					<?php
					include '../includes/ligacao.php';
					$db = mysql_query("SELECT * FROM atl_acrescentado_a_prova WHERE cod_equipa = '$_SESSION[cod_equipa]' and cod_delegacao = '$_SESSION[cod_delegacao_utilizador]'");
					?>
					<table class="tabela">
						<tr>
							<th>Nº Atleta</th>
							<th>Nome</th>
							<th>Retirar da Prova</th>
						</tr>
						<?php
						$entrou_no_ciclo = false;
						while($dados = mysql_fetch_array($db))
						{
							$entrou_no_ciclo = true;
							?>
							<tr>
								<td><?php echo $dados['cod_elemento_equipa']; ?></td>
								<td><?php echo $dados['nome']; ?></td>
								<!-- eliminar equipa da prova -->
								<?php
								include '../includes/limit10.php';
								if($data_devolvida_limit10 > 10)
								{?>
									<td><button class="botão_opções" type="button" onclick="Elimina('<?= $dados['cod_elemento_equipa'];?>','<?= $dados['cod_prova'];?>')"><img src="../images/eliminar.png" name="Retirar da Prova" alt="Retirar da Prova" title="Retirar da Prova"/></button></td>
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
							<td rowspan="3" colspan="7">De momento não existem atletas inscritos ou o prazo de inscrições já expirou.</td><?php
						}
						#mysql_close($conexao);
						?>
					</table>
					<input type="button" value="Actualizar" onclick="window.location.href='ins_atleta_prova_rd.php'" class="botao">	
					<input type="button" value="Voltar aos atletas" onclick="window.location.href='atletas_rd.php'" class="botao">	
				</div>	
				
				<!-- em baixo --> 
				<?php include '../includes/rodape_rd.php';?>
				
				<!-- include para a mensagem popup -->
				<?php include '../includes/mensagem_popup.php';?>
				
			</div>	
		</body>
</html>