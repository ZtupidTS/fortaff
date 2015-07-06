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
			window.location.href = "equipas_co.php";
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
			<form method="post" action="equipas_co.php">
				<select name="pais">
					<?php
					include '../includes/ligacao.php';
					$pais = mysql_query("SELECT distinct nome_pais, cod_delegacao FROM equipa_with_delegacao ORDER BY nome_pais ");
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
				$dados_linhas = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS linhas_total FROM equipa WHERE cod_delegacao = '$_POST[pais]' and estado_valido != 'X'"));
				include '../includes/linhas_tabelas.php';
				$db_equipa = mysql_query("SELECT * FROM equipa_with_delegacao WHERE estado_valido != 'X' and cod_delegacao = '$_POST[pais]' ORDER BY nome_pais LIMIT $primeira_entrada,$linhas_por_pagina");
			}else{
				$dados_linhas = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS linhas_total FROM equipa WHERE estado_valido != 'X'"));
				include '../includes/linhas_tabelas.php';
				$db_equipa = mysql_query("SELECT * FROM equipa_with_delegacao WHERE estado_valido != 'X' ORDER BY nome_pais LIMIT $primeira_entrada,$linhas_por_pagina");
			}
			?>
			<table id="tabela">
					<tr>
						<th>Nº</th>
						<th>Modalidade</th>
						<th>Categoria</th>
						<th>Delegação</th>
						<th>Nº Total de Elementos</th>
						<th>Estado</th>
					</tr>
					<?php
					$class = 'linha_impar';
					while($dados = mysql_fetch_array($db_equipa))
					{
					?>
					<tr class="<?php echo $class;?>">
						<td><?php echo $dados['cod_equipa']; ?></td>
						<td><?php echo $dados['nome_modalidade']; ?></td>
						<td><?php include '../includes/sexo_imagem.php';?></td>
						<td class="delegação_nome">
							<img src="../images/Bandeiras/<?= $dados['cod_delegacao'];?>.png" class="bandeiras"/>
							<?php echo $dados['nome_pais']; ?>
							</td>
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
					
						<!-- imagem valido ou pendente -->
						<td><?php include '../includes/image_val_pen.php';?></td>
						<?php
						#para aceitar ou rejeitar as alterações do rd
						if($dados['estado_valido'] != 'X' && $dados['estado_valido'] != 'V')
						{?>
							<td class="opções_tabela">
								<form method="post" action="val_equipa_co.php">
									<input style="visibility:hidden; display:none" type="text" name="cod_equipa" value="<?php echo $dados['cod_equipa']; ?>">
									<input style="visibility:hidden; display:none" type="text" name="cod_modalidade" value="<?php echo $dados['cod_modalidade']; ?>">
									<button class="butão_opções"><img src="../images/pouce_ok.png" name="Aceitar" alt="Aceitar" title="Aceitar"></button>
								</form>
							</td>
							<td class="opções_tabela">
								<form method="post" action="no_val_equipa_co.php">
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
			?>
			</table>
			<?php include '../includes/pagina_tabela.php';?>
		</div>
		<!-- em baixo -->
		<?php include '../includes/rodape.php';?>
		
	</body>
</html>