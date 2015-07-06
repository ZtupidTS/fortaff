<?php 
session_start(); 
unset($_SESSION['delegacao_a_alterar']);
include '../includes/test_intruso_co.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="../css/estilo_co.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico" >
		<script type="text/javascript">
		function Elimina(nome_pais,cod)
		{
			if(confirm('Deseja Eliminar '+nome_pais+'?'))
			{
				window.location.href = "verificacao_elimina_delegacao_co.php?cod_delegacao="+cod;
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
			$dados_linhas = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS linhas_total FROM delegacao WHERE estado_valido != 'X'"));
			include '../includes/linhas_tabelas.php';
			$db_delegacao = mysql_query("SELECT * FROM delegacao WHERE cod_delegacao != 'co' ORDER BY nome_pais LIMIT $primeira_entrada,$linhas_por_pagina");
			if(mysql_num_rows($db_delegacao) < 1)
			{
				mysql_close($conexao);
			}else{
				?>
				<table id="tabela">
					<tr>
						<th>País</th>
						<th>Responsável</th>
						<th>Login</th>
						<th>Email</th>
						<th>Estado</th>			
						<th colspan="2">Opções</th>									
					</tr>
					<?php
					$class = 'linha_impar';
					while($dados = mysql_fetch_array($db_delegacao))
					{
						if($dados['estado_valido'] != 'X')
						{
							?>
							<tr class="<?php echo $class;?>">
							<form method="post" action="altera_delegacao_co.php">
								<td style="visibility:hidden; display:none"><input type="text" name="cod_delegacao" value="<?php echo $dados['cod_delegacao']; ?>">
								<td class="delegação_nome">
									<img src="../images/Bandeiras/<?= $dados['cod_delegacao'];?>.png" class="bandeiras"/>
									<?php echo $dados['nome_pais']; ?>
								</td>
								<td><?php echo $dados['nome_responsavel']; ?></td>
								<td><?php echo $dados['login']; ?></td>
								<td><?php echo $dados['email']; ?></td>
								
								<!-- imagem valido ou pendente -->
								<td><?php include '../includes/image_val_pen.php';?></td>
								
								<!-- alterar e eliminar -->
								<td><button class="butão_opções" type="submit"><img src="../images/altera.png" name="Alterar" alt="Alterar" title="Alterar"></button></td>
								<td><button class="butão_opções" type="button" onclick="Elimina('<?= $dados['nome_pais'];?>','<?= $dados['cod_delegacao'];?>')"><img src="../images/eliminar.png" name="eliminar" alt="Eliminar" title="Eliminar"/></button></td>
							</form>
							</tr>
							<?php
							$class = ($class == 'linha_par') ? 'linha_impar' : 'linha_par';
						}
					}// fim do ciclo para escrever os dados na tabela
					mysql_close($conexao);
				}?>
					
				</table>
				<?php include '../includes/pagina_tabela.php';?>
				<!-- acrescentar delegação -->
				<form class="butão_acrescentar" action="acrescentar_delegacao_co.php">
					<button class="butão_opções"><img src="../images/add.png" name="Acrescentar" alt="Acrescentar" title="Acrescentar"/>Acrescentar</button>
				</form>				
		
			<!-- em baixo -->
			<?php include '../includes/rodape.php';?>
			
			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
		</div>
	</body>
</html>




