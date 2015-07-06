<?php 
session_start(); 
unset($_SESSION["mensagem"]);
unset($_SESSION["hora"]);
unset($_SESSION["minutos"]);
$_SESSION['lugares_total'] = "";
$_SESSION['preco'] = "";
$_SESSION['prova_nome_juiz'] = "";
$_SESSION['prova_local'] = "";
$_SESSION['erro_preco'] = false;
unset($_SESSION['dia']);
unset($_SESSION['mes']);
unset($_SESSION['ano']);
unset($_SESSION['alt_minutos']);
unset($_SESSION['alt_hora']);
unset($_SESSION['prova_a_alterar']);
unset($_SESSION['class_cod_prova']);
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
		function Elimina(cod)
		{
			if(confirm('Deseja Eliminar a prova nº'+cod+'?'))
			{
				window.location.href = "verif_el_prova_co.php?cod_prova="+cod;
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
			$dados_linhas = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS linhas_total FROM prova WHERE estado_valido != 'X'"));
			include '../includes/linhas_tabelas.php';
			$db_prova = mysql_query("SELECT * FROM prova ORDER BY data LIMIT $primeira_entrada,$linhas_por_pagina");
			?>
			<table id="tabela">
				<tr>
					<th>Nº</th>
					<th>Modalidade</th>
					<th>Categoria</th>
					<th>Local</th>
					<th>Data</th>
					<th>Hora de inicio</th>
					<th>Duração</th>
					<th>Juíz</th>
					<th>Preço</th>
					<th>Capacidade</th>
					<th>Disponíveis</th>
					<th colspan="2">Opções</th>									
					<th>Classificação</th>
				</tr>
				<?php
				$class = 'linha_impar';
				while($dados = mysql_fetch_array($db_prova))
				{
					if($dados['estado_valido'] != 'X')
					{
						?>
						<tr class="<?php echo $class;?>">
							<form method="post" action="altera_prova_co.php">
								<td style="visibility:hidden; display:none"><input type="text" name="cod_prova" value="<?php echo $dados['cod_prova']; ?>"></td>
								<td><?= $dados['cod_prova']; ?></td>
								<td>
								<?php
								$db_modalidade = mysql_query("SELECT * FROM modalidade WHERE cod_modalidade = '$dados[cod_modalidade]'");
								$dados_modalidade = mysql_fetch_array($db_modalidade);
								echo $dados_modalidade['nome_modalidade']; ?></td>
								<td><?php include '../includes/sexo_imagem.php';?></td>
								<td><?= $dados['local']; ?></td>
								<td>
								<!-- insira a função para por a aparecer a data como queremos -->
								<?php
								require_once '../funcao/funcao_formulario.php';
								echo inverte_data($dados['data']);
								?>
								</td>
								<td>
								<!-- insira a função para por a aparecer a hora como queremos -->
								<?php
								require_once '../funcao/funcao_formulario.php';
								$hora = dividir_hora($dados['hora_inicio']);
								echo $hora[0].':'.$hora[1];
								?>
								</td>
								<td>
								<!-- insira a função para por a aparecer a hora como queremos -->
								<?php
								require_once '../funcao/funcao_formulario.php';
								$hora = dividir_hora($dados['duracao']);
								echo $hora[0].':'.$hora[1];
								?>
								</td>
								<td><?= $dados['nome_juiz']; ?></td>
								<td><?= $dados['preco'] . '€'; ?></td>
								<td><?= $dados['lugares_total']; ?></td>
								<td>		
								<?php
								$db_lug_vazio = mysql_query("SELECT * FROM lugares_vazios WHERE cod_prova = '$dados[cod_prova]'");
								$dados_lug_vazio = mysql_fetch_array($db_lug_vazio);
								echo $dados_lug_vazio['lugar_vazios']; ?>
								</td>
								<!-- alterar -->
								<td><button class="butão_opções" type="submit"><img src="../images/altera.png" name="Alterar" alt="Alterar" title="Alterar"></button></td>
							</form>
								<!-- remover -->
								<td><button button class="butão_opções" type="button" onclick="Elimina('<?= $dados['cod_prova'];?>')"><img src="../images/eliminar.png" name="eliminar" alt="Eliminar" title="Eliminar"/></button></td>
								<!-- classificação -->
								<form method="post" action="class_prova_co.php">
									<td style="visibility:hidden; display:none"><input type="text" name="cod_prova" value="<?php echo $dados['cod_prova']; ?>"></td>
									<td><button class="butão_opções" type="submit"><img src="../images/podium.png" name="Classificacao" alt="Classificacao" title="Classificacao"></button></td>
								</form>
						</tr>
						<?php
						$class = ($class == 'linha_par') ? 'linha_impar' : 'linha_par';
					}
				}// fim do ciclo para escrever os dados na tabela
				
				mysql_close($conexao);
				?>
			</table>
			<?php include '../includes/pagina_tabela.php';?>
			<!-- acrescentar uma prova -->
			<form class="butão_acrescentar" action="acrescentar_prova_co.php">
			<button class="butão_opções"><img src="../images/add.png" name="Acrescentar" alt="Acrescentar" title="Acrescentar"/>Acrescentar</button>
			</form>
			
			<!-- em baixo -->
			<?php include '../includes/rodape.php';?>
			
			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
			
		</div>	
	</body>
</html>




