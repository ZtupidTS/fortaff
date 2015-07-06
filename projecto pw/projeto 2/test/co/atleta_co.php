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
		<link rel="shortcut icon" href="../images/ico.ico">
		<script type="text/javascript">
		function Filtro()
		{
			window.location.href = "atleta_co.php";
		}
		</script>
	</head>
	
	<body>
		<div id="estrutura">
		
		<!-- cabeçalho -->
		<?php include '../includes/cabecalho.php';?>
		
		<!-- menu -->
		<?php include '../includes/menu_escolha_co.php';?>
		
		<!-- corpo -->
		<div id="conteudo">
		<div id="filtro">
			<form method="post" action="atleta_co.php">				
				<select name="pais">
					<?php
					include '../includes/ligacao.php';
					$pais = mysql_query("SELECT distinct nome_pais, cod_delegacao FROM dados_atletas WHERE estado_valido != 'X' ORDER BY nome_pais");
					while($dados_pais = mysql_fetch_array($pais))
					{?>
						<option value="<?= $dados_pais['cod_delegacao'];?>"><?= $dados_pais['nome_pais'];?></option>
						<?php
					}?>
				</select>
				<button type="submit">Filtrar</button>
				<button type="button" onclick="Filtro()">Ver Tudo</button>
			</form>
			</div>
			
			<?php
			if(isset($_POST['pais']))
			{
				$dados_linhas = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS linhas_total FROM dados_atletas WHERE cod_delegacao = '$_POST[pais]' and estado_valido != 'X'"));
				include '../includes/linhas_tabelas.php';
				$db_atleta = mysql_query("SELECT * FROM dados_atletas WHERE cod_delegacao = '$_POST[pais]' and estado_valido != 'X' ORDER BY cod_equipa LIMIT $primeira_entrada,$linhas_por_pagina");
			}else{
				$dados_linhas = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS linhas_total FROM dados_atletas WHERE estado_valido != 'X'"));
				include '../includes/linhas_tabelas.php';
				$db_atleta = mysql_query("SELECT * FROM dados_atletas WHERE estado_valido != 'X' ORDER BY cod_equipa LIMIT $primeira_entrada,$linhas_por_pagina");
			}	
			if(mysql_num_rows($db_atleta) < 1)
			{
				mysql_close($conexao);
			}else{
				?>
				<table id="tabela">
					<tr>
						<th>Nº da Equipa</th>
						<th>Nº do Atleta</th>
						<th>Nome</th>
						<th>Data de Nascimento</th>
						<th>Sexo</th>
						<th>Peso (Kg)</th>
						<th>Altura (cm)</th>
						<th>Grupo Sanguineo</th>
						<th>Delegação</th>
						<th>Estado</th>
					</tr>
					<?php
					$class = 'linha_impar';
					while($dados = mysql_fetch_array($db_atleta))
					{
						?>
						<tr class="<?php echo $class;?>">
							<td><?php echo $dados['cod_equipa']; ?></td>
							<td><?php echo $dados['cod_elemento_equipa']; ?></td>
							<td><?php echo $dados['nome']; ?></td>
							<td><?php echo $dados['data_nasc']; ?></td>
							<td><?php include '../includes/sexo_imagem.php';?></td>
							<td><?php echo $dados['peso']; ?></td>
							<td><?php echo $dados['altura']; ?></td>
							<td><?php echo $dados['grupo_sanguineo']; ?></td>
							<?php
							$db_delegacao = mysql_query ("SELECT * FROM delegacao WHERE cod_delegacao = '$dados[cod_delegacao]'");
							$dados_delegacao = mysql_fetch_array($db_delegacao);
							?>
							<td class="delegação_nome">
								<img src="../images/Bandeiras/<?= $dados_delegacao['cod_delegacao'];?>.png" class="bandeiras"/>
								<?php echo $dados_delegacao['nome_pais']; ?>
							</td>
							
							<!-- imagem valido ou pendente -->
							<td><?php include '../includes/image_val_pen.php';?></td>
							<?php
							#para aceitar ou rejeitar as alterações do rd
							if($dados['estado_valido'] != 'X' && $dados['estado_valido'] != 'V')
							{?>
								<td class="opções_tabela">
									<form method="post" action="val_aux_atl_co.php">
										<input style="visibility:hidden; display:none" type="text" name="cod_elemento_equipa" value="<?php echo $dados['cod_elemento_equipa']; ?>">
										<input style="visibility:hidden; display:none" type="text" name="cod_equipa" value="<?php echo $dados['cod_equipa']; ?>">
										<button class="butão_opções"><img src="../images/pouce_ok.png" name="Aceitar" alt="Aceitar" title="Aceitar"></button>
									</form>
									<form method="post" action="no_val_aux_atl_co.php">
										<input style="visibility:hidden; display:none" type="text" name="cod_elemento_equipa" value="<?php echo $dados['cod_elemento_equipa']; ?>">
										<input style="visibility:hidden; display:none" type="text" name="cod_equipa" value="<?php echo $dados['cod_equipa']; ?>">
										<button class="butão_opções"><img src="../images/pouce_nok.png" name="Rejeitar" alt="Rejeitar" title="Rejeitar"></button>
									</form>
								</td>
								<?php
							}?>
						</tr>
						<?php
						$class = ($class == 'linha_par') ? 'linha_impar' : 'linha_par';
					}// fim do ciclo para escrever os dados na tabela
					mysql_close($conexao);
			}
			?>
				</table>
				<?php include '../includes/pagina_tabela.php';?>
		</div>
		<!-- em baixo -->
		<?php include '../includes/rodape.php';?>
		</div>
	</body>
</html>




