<?php 
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php';
include '../includes/css_rd.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="<?= $css;?>" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico">
	</head>
	
	<body>
		<div class="estrutura">
				
			<!-- cabeçalho -->
			<?php include '../includes/cabecalho_rd.php'; ?>
			
			<!-- menu a direita -->
			<?php include '../includes/bandeira.php'; ?>

			
			<!-- corpo -->
			<div class="estrutabela">
				<form method="post" action="verif_acre_atleta_rd.php">
					<p class="altera_titulo"> Insira os dados do atleta que pretende acrescentar: </p>
					<table>
						<tr>
							<td>Nome:</td> 
							<td><input type="text" name="nome" size="30" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="30" required></td>
						</tr>
						<?php include '../includes/descricao_atleta.php' ?>
						<tr>
							<td>Sexo:</td> 
							<td><?php include '../includes/sexo_escolhido.php';?></td>
						</tr>
						<tr>
							<td colspan="2" align="center"><br>
								<input type="submit" name="validar" value="Validar" class="botao">
								<input type="reset" name="limpar" value="Limpar campos" class="botao">
								<input type="button" value="Voltar aos Atletas" onclick="window.location.href='atletas_rd.php'" class="botao">
							</td>
						</tr>
					</table>
				</form>
				<br>
				
				<p class="altera_titulo">Acrescentar atletas pertencentes a outras equipas:</p>
				<table class="tabela">
					<tr>
						<th>Nome</th>
						<th>Data Nascimento</th>
						<th>Sexo</th>
						<th>Peso</th>
						<th>Altura</th>
						<th>Grupo Sanguineo</th>
						<th>Acrescentar</th>
					</tr>
						
					<?php
					require_once '../query/elemento_existentes_delegacao.php';
					$valor_retornado = elemento_existentes_delegacao($_SESSION['cod_delegacao_utilizador'], $_SESSION['cod_equipa']);
					$entrou_no_ciclo = false;
					if(mysql_num_rows($valor_retornado) > 0)
					{?>
						<?php
						while($dados2 = mysql_fetch_array($valor_retornado))
						{
							$dados_elemento = mysql_query("SELECT * FROM dados_atletas WHERE cod_elemento_equipa = '$dados2[cod_elemento_equipa]'");
							#verifica se é um atleta
							if(mysql_num_rows($dados_elemento) > 0)
							{
								$entrou_no_ciclo = true;
								$dados = mysql_fetch_array($dados_elemento);
								?>
								<tr>
									<td><?php echo $dados['nome']; ?></td>
									<td><?php echo $dados['data_nasc']; ?></td>
									<td><?php echo $dados['sexo']; ?></td>
									<td><?php echo $dados['peso'];?> Kg</td>
									<td><?php echo $dados['altura']; ?> cm</td>
									<td><?php echo $dados['grupo_sanguineo']; ?></td>
									<!-- ascrescentar atleta -->
									<form method="post" action="acre_atle_aux_exist.php">
									<td style="visibility:hidden; display:none"><input type="text" name="cod_elemento_equipa" value="<?php echo $dados['cod_elemento_equipa']; ?>"></td>
									<td><button class="botão_opções" type="submit"><img src="../images/add.png" name="Acrescentar" alt="Acrescentar" title="Acrescentar"/></button></td>
									</form>
								</tr>
								<?php
							}
						}
					}
					if(!($entrou_no_ciclo))
					{?>
						<td rowspan="3" colspan="7">De momento não existem atletas de outras equipas para acrescentar</td><?php
					}?>
				</table>
			</div>
			
			<!-- em baixo -->
			<?php 
			mysql_close($conexao);
			include '../includes/rodape_rd.php'; 
			?>	
		
			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
			
		</div>	
	</body>
</html>