<?php 
session_start(); 
unset($_SESSION["hora"]);
unset($_SESSION["minutos"]);
$_SESSION['lugares_total'] = "";
$_SESSION['preco'] = "";
$_SESSION['designacao'] = "";
$_SESSION['descricao'] = "";
$_SESSION['erro_preco'] = false;
unset($_SESSION['dia']);
unset($_SESSION['mes']);
unset($_SESSION['ano']);
unset($_SESSION['alt_minutos']);
unset($_SESSION['alt_hora']);
unset($_SESSION['evento_a_alterar']);
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
			if(confirm('Deseja Eliminar o evento nº'+cod+'?'))
			{
				window.location.href = "verif_el_evento_co.php?cod_evento="+cod;
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
			<div id="conteudo">
				<?php
				include '../includes/ligacao.php';
				$dados_linhas = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS linhas_total FROM evento WHERE estado_valido != 'X'"));
				include '../includes/linhas_tabelas.php';
				$db_eventos = mysql_query("SELECT * FROM evento LIMIT $primeira_entrada,$linhas_por_pagina");
				?>
				<table id="tabela">
					<tr>
						<th>Nº</th>
						<th>Designação</th>
						<th>Descrição</th>
						<th>Data</th>
						<th>Hora de início</th>
						<th>Duração</th>
						<th>Preço</th>
						<th>Capacidade</th>
						<th>Disponíveis</th>
						<th>Classificação</th>
						<th colspan="2">Opções</th>									
					</tr>
					<?php
					$class = 'linha_impar';
					while($dados = mysql_fetch_array($db_eventos))
					{
						if($dados['estado_valido'] != 'X')
						{
						?>
						<tr class="<?php echo $class;?>">
							<form method="post" action="altera_evento_co.php">
								<td style="visibility:hidden; display:none"><input type="text" name="cod_evento" value="<?php echo $dados['cod_evento']; ?>"></td>
								<td><?= $dados['cod_evento']; ?></td>
								<td><?= $dados['designacao']; ?></td>
								<td><?= $dados['descricao']; ?></td>
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
								<td><?= $dados['preco'] . '€'; ?></td>
								<td><?= $dados['lugares_total']; ?></td>
								<td>
								<?php
								$db_lug_vazio = mysql_query("SELECT * FROM lugares_vazios_evento WHERE cod_evento = '$dados[cod_evento]'");
								$dados_lug_vazio = mysql_fetch_array($db_lug_vazio);
								echo $dados_lug_vazio['lugar_vazios']; ?>
								</td>
								<td>
								<?php
								#estrelas
								$class_media = mysql_query("SELECT * FROM classificacao_media_evento WHERE cod_evento = '$dados[cod_evento]'");
								$dados_class_media = mysql_fetch_array($class_media);
								$estrela = $dados_class_media['classif_media'];
								if(is_null($estrela))
								{
									echo '-----';
								}else{
									include '../includes/estrelas.php';								
								}
								?>
								</td>
								
								<!-- alterar -->
								<td><button button class="butão_opções" type="submit"><img src="../images/altera.png" name="Alterar" alt="Alterar" title="Alterar"></button></td>
							</form>
						
								<!-- remover -->
								<td><button button class="butão_opções" type="button" onclick="Elimina('<?= $dados['cod_evento'];?>')"><img src="../images/eliminar.png" name="eliminar" alt="Eliminar" title="Eliminar"/></button></td>
						</tr>
						<?php
						$class = ($class == 'linha_par') ? 'linha_impar' : 'linha_par';
						}
					}// fim do ciclo para escrever os dados na tabela
					mysql_close($conexao);
					?>
				</table>
				<?php include '../includes/pagina_tabela.php';?>
				<!-- acrescentar um evento -->
				<form class="butão_acrescentar" action="acrescentar_evento_co.php">
				<button class="butão_opções"><img src="../images/add.png" name="Acrescentar" alt="Acrescentar" title="Acrescentar"/>Acrescentar</button>
				</form>
			</div>
		
			<!-- em baixo -->
			<?php include '../includes/rodape.php';?>	

			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
			
		</div>
	</body>
</html>




