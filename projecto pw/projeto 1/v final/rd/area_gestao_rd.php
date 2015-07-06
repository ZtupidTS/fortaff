<?php
session_start();
include '../includes/test_intruso_rd.php';
unset($_SESSION['eq_rd_a_alterar']);
unset($_SESSION['mod_equipa']);
unset($_SESSION['sexo_css']);
#variável usada para o select no ano de nascimento
$today = getdate();
$_SESSION['ano_actual'] = $today['year'];

include '../includes/ligacao.php';
include '../includes/limit30.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="../css/estilo_rd.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico" >
		<script type="text/javascript">
		function Elimina(cod)
		{
			if(confirm('Deseja Eliminar a equipa nº'+cod+'?'))
			{
				window.location.href = "verif_el_equipa_rd.php?cod_equipa="+cod;
			}
		}
		<?php include '../js/limit30.js';?>
		<?php include '../js/limit30_sempopup.js';?>
		<?php include '../js/dias_que_faltam.js';?>
		</script>
	</head>
	<!-- mensagem para por o popup a aparecer só uma vez -->
	<?php
	if(!(isset($_SESSION['mensagem_limit30'])))
	{?>
		<body onLoad="Limita30('<?= $data_devolvida;?>');">
		<?php
		if($data_devolvida < 30)
		{
			$_SESSION['mensagem_limit30'] = "";
		}else{
			unset($_SESSION['mensagem_limit30']);
			#meter o tempo que falta até o fim das alterações
			echo '<script>DiasFaltam();</script>';
		}
	}else{?>
		<body onLoad="Limita30SemPopup('<?= $data_devolvida;?>');">
		<?php
	}?>
			<div class="estrutura">
				<!-- cabeçalho -->
				<?php include '../includes/cabecalho_rd.php';?>
				
				<!-- menu a direita -->
				<?php include '../includes/bandeira.php';?>	

				<!-- corpo -->
				<div class="estrutabela">
					
					<h1 class="titulo_rd">Equipas</h1>	
					<?php					
					include '../includes/ligacao.php';
					$dados_linhas = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS linhas_total FROM equipa_with_delegacao WHERE nome_pais='$_SESSION[nome_pais]' and estado_valido != 'X'"));
					include '../includes/linhas_tabelas.php';
					$db_equipa = mysql_query("SELECT * FROM equipa_with_delegacao where nome_pais='$_SESSION[nome_pais]' and estado_valido != 'X' LIMIT $primeira_entrada,$linhas_por_pagina");
					?>
					<table class="tabela">
						<tr>
							<th>Nº Equipa</th>
							<th>Tipo</th>
							<th>Modalidade</th>
							<th>Nº Total de Elementos</th>
							<th>Estado</th>
							<th>Atletas</th>
							<th>Auxiliares</th>
							<th name="limit30" id="limit30">Alterar</th>
							<th name="limit30" id="limit30">Eliminar</th>
						</tr>
						<?php
						while($dados = mysql_fetch_array($db_equipa))
						{?>
							<tr>
								<td><?php echo $dados['cod_equipa']; ?></td>
								<td><?php include '../includes/sexo_imagem.php';?></td>
								<td><?php echo $dados['nome_modalidade']; ?></td>
								<td><?php 
								$tot_elemento = mysql_query("SELECT total FROM total_elemento_equipa WHERE '$dados[cod_equipa]' = cod_equipa");
								if(mysql_num_rows($tot_elemento) == 0)
								{
									echo '0';
								}else{
									$dados2 = mysql_fetch_array($tot_elemento);
									echo $dados2['total'];
								}
								
								?></td>
								<td><?php include '../includes/image_val_pen.php';?></td>
								<!-- atletas -->
								<form method="post" action="atletas_rd.php">
									<td style="visibility:hidden; display:none"><input type="text" name="cod_equipa" value="<?php echo $dados['cod_equipa']; ?>"></td>
									<td style="visibility:hidden; display:none"><input type="text" name="cod_modalidade" value="<?php echo $dados['cod_modalidade']; ?>"></td>
									<td style="visibility:hidden; display:none"><input type="text" name="sexo" value="<?php echo $dados['sexo']; ?>"></td>
									<td><button class="botão_opções" type="submit"><img src="../images/atleta.jpg" name="Atletas" alt="Atletas" title="Atletas"/></button></td>
								</form>
								<!-- auxiliar -->
								<form method="post" action="auxiliares_rd.php">
									<td style="visibility:hidden; display:none"><input type="text" name="cod_equipa" value="<?php echo $dados['cod_equipa']; ?>"></td>
									<td><button class="botão_opções" type="submit"><img src="../images/auxiliar.jpg" name="Auxiliares" alt="Auxiliares" title="Auxiliares"/></button></td>
								</form>
								<!-- alterar equipa -->
								<form method="post" action="alt_eq_rd.php">
									<td style="visibility:hidden; display:none"><input type="text" name="cod_equipa" value="<?php echo $dados['cod_equipa']; ?>"></td>
									<td name="limit30" id="limit30"><button class="botão_opções" name="limit30" id="limit30" type="submit"><img src="../images/altera.png" name="Altera" alt="Altera" title="Altera"/></button></td>
								</form>	
								<!-- eliminar equipa -->
								<td name="limit30" id="limit30"><button class="botão_opções" name="limit30" id="limit30" type="button" onclick="Elimina('<?= $dados['cod_equipa'];?>')"><img src="../images/eliminar.png" name="eliminar" alt="Eliminar" title="Eliminar"/></button></td>
							</tr>
							<?php
						}// fim do ciclo para escrever os dados na tabela
						mysql_close($conexao);
						?>
					</table>
					<?php include '../includes/pagina_tabela.php';?>
					<!-- os botões -->
					<input type="button" value="Actualizar" onclick="window.location.href='area_gestao_rd.php'" class="botao">	
					<input name="limit30" id="limit30" type="button" value="Acrescentar Equipa" onclick="window.location.href='acrescentar_equipa_rd.php'" class="botao">	
					<input type="button" value="Inserir e visualizar equipas nas provas" onclick="window.location.href='ins_equipa_prova_rd.php'" class="botao">	
				</div>	
				
				<!-- o tempo que falta -->
				<?php include '../includes/limit30_sempopup.php'; ?>
				
				<!-- em baixo --> 
				<?php include '../includes/rodape_rd.php';?>
				
				<!-- include para a mensagem popup -->
				<?php include '../includes/mensagem_popup.php';?>
				
			</div>	
		</body>
</html>