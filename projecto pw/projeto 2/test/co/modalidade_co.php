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
		function Elimina(nome,cod)
		{
			if(confirm('Deseja Eliminar '+nome+'?'))
			{
				window.location.href = "verif_elimina_modalidade_co.php?cod_modalidade="+cod;
			}
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
			<?php
			include '../includes/ligacao.php';
			$dados_linhas = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS linhas_total FROM modalidade WHERE estado_valido != 'X'"));
			include '../includes/linhas_tabelas.php';
			$db_modalidade = mysql_query("SELECT * FROM modalidade ORDER BY nome_modalidade LIMIT $primeira_entrada,$linhas_por_pagina");
			?>
			<table id="tabela">
				<tr>
					<th>Modalidade</th>
					<th>Categoria</th>
					<th colspan="2">Opções</th>									
				</tr>
				<?php
				$class = 'linha_impar';
				while($dados = mysql_fetch_array($db_modalidade))
				{
					if($dados['estado_valido'] != 'X')
					{
						?>
						<tr class="<?php echo $class;?>">
							<form method="post" action="altera_modalidade_co.php">
								<td style="visibility:hidden; display:none"><input type="text" name="cod_modalidade" value="<?php echo $dados['cod_modalidade']; ?>"></td>
								<td style="visibility:hidden; display:none"><input type="text" name="tipo" value="<?php echo $dados['tipo']; ?>"></td>
								<td><?php echo $dados['nome_modalidade']; ?></td>
								<td>
								<?php
								$nome_modalidade = mysql_query("SELECT * FROM informacao_diversas WHERE id = '$dados[tipo]'");
								$tipo_modalidade = mysql_fetch_array($nome_modalidade);
								echo $tipo_modalidade['informacao']; 
								?>
								</td>
								<!-- alterar -->
								<td><button button class="butão_opções" type="submit"><img src="../images/altera.png" name="Alterar" alt="Alterar" title="Alterar"></button></td>
							</form>
							<!-- remover -->
							<td><button class="butão_opções" type="button" onclick="Elimina('<?= $dados['nome_modalidade'];?>','<?= $dados['cod_modalidade'];?>')"><img src="../images/eliminar.png" name="eliminar" alt="Eliminar" title="Eliminar"/></button></td>
						</tr>
						<?php
						$class = ($class == 'linha_par') ? 'linha_impar' : 'linha_par';
					}
				}// fim do ciclo para escrever os dados na tabela
				mysql_close($conexao);
				?>
			</table>
			<?php include '../includes/pagina_tabela.php';?>
			<!-- os botões -->
			<form class="butão_acrescentar" action="acrescentar_modalidade_co.php">
				<button class="butão_opções"><img src="../images/add.png" name="Acrescentar" alt="Acrescentar" title="Acrescentar"/>Acrescentar</button>
			</form>	
			
			<!-- em baixo -->
			<?php include '../includes/rodape.php';?>
			
			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
			
		</div>
	</body>
</html>




