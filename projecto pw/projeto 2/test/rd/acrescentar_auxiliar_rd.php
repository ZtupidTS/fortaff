<?php 
session_start();
include '../includes/test_intruso_rd.php';
include '../includes/ligacao.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="../css/estilo_rd.css" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico">
	</head>
	
	<body>
		<div class="estrutura">
			<!-- cabeçalho -->
			<?php include '../includes/cabecalho_rd.php';?>

			<!-- menu a direita -->
			<?php include '../includes/bandeira.php';?>	
			<!-- corpo -->
			<div class="estrutabela">
				<form method="post" action="verif_acre_auxiliar_rd.php">
					<table>
						<td style="visibility:hidden; display:none"><input type="text" name="cod_equipa" value="<?php echo $_SESSION["cod_equipa"]; ?>"></td> <!-- Recebe a variável sessão do cod_equipa -->
						<p class="altera_titulo">Inserir Auxiliar :</p>
							<tr>
								<td>Nome:</td> 
								<td><input type="text" name="nome" size="30" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="30" required></td>
							</tr>
							<?php include '../includes/descricao_auxiliar.php' ?>
							<tr>
								<td>Sexo:</td> 
								<td>
								<input type="radio" name="sexo" value="M" id="M" checked/><label for="M"><img src="../images/sexo/sexo_masculino.jpg" /></label>
								<input type="radio" name="sexo" value="F" id="F" /><label for="F"><img src="../images/sexo/sexo_feminino.jpg" /></label>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center"><br>
								<input type="submit" name="validar" value="Validar" class="botao">
								<input type="reset" name="limpar" value="Limpar campos" class="botao">
								<input type="button" value="Voltar aos Auxiliares" onclick="window.location.href='auxiliares_rd.php'" class="botao">
								</td>
							</tr>
					</table>
				</form>
				<br>
				
				<p class="altera_titulo">Acrescentar auxiliares pertencentes a outras equipas :</p>
				<table class="tabela">
					<tr>
						<th>Nome</th>
						<th>Data Nascimento</th>
						<th>Sexo</th>
						<th>Função</th>
						<th>Habilitações Literarias</th>
						<th>Acrescentar</th>
					</tr>
					
					<?php
					$auxiliar = mysql_query("SELECT distinct ei.cod_elemento_equipa FROM elemento_in_equipa ei, equipa eq WHERE ei.cod_equipa = eq.cod_equipa and eq.cod_delegacao = '$_SESSION[cod_delegacao_utilizador]' and ei.cod_elemento_equipa not in (SELECT cod_elemento_equipa FROM elemento_in_equipa WHERE cod_equipa = '$_SESSION[cod_equipa]' and estado_valido != 'X')");
					$entrou_no_ciclo = false;
					if(mysql_num_rows($auxiliar) > 0)
					{?>
						<?php
						while($dados2 = mysql_fetch_array($auxiliar))
						{
							$dados_elemento = mysql_query("SELECT * FROM dados_auxiliares WHERE cod_elemento_equipa = '$dados2[cod_elemento_equipa]'");
							#verifica se é um auxiliar
							if(mysql_num_rows($dados_elemento) > 0)
							{
								$entrou_no_ciclo = true;
								$dados = mysql_fetch_array($dados_elemento);
								?>
								<tr>
									<td><?php echo $dados['nome']; ?></td>
									<td><?php echo $dados['data_nasc']; ?></td>
									<td><?php echo $dados['sexo']; ?></td>
									<td><?php echo $dados['funcao'];?></td>
									<td><?php echo $dados['habilit_literarias']; ?></td>
									<!-- ascrescentar auxiliar -->
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
						<td rowspan="3" colspan="7">De momento não existem auxiliares inscritos ou o prazo de inscrições já expirou.</td><?php
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