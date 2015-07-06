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
		<script language="javascript">
		<?php include '../js/mensagem_popup.js';?>
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
				<?php 
				include '../includes/ligacao.php';
				#caso veio da pagina anterior ou da validação pega no post ou na variavel de sessão
				if(isset($_POST['cod_elemento_equipa']))
				{
					$escolha_elemento = mysql_query("SELECT * FROM dados_atletas WHERE cod_elemento_equipa = '$_POST[cod_elemento_equipa]'");
					$dados = mysql_fetch_array($escolha_elemento);
					$_SESSION['elemento_a_alterar'] = $dados['cod_elemento_equipa'];
				}else{
					$escolha_elemento = mysql_query("SELECT * FROM dados_atletas WHERE cod_elemento_equipa = '$_SESSION[elemento_a_alterar]'");
					$dados = mysql_fetch_array($escolha_elemento);
				}
				
				$_SESSION['nome'] = $dados['nome'];
				$_SESSION['peso'] = $dados['peso'];				
				$_SESSION['altura'] = $dados['altura'];				
				$_SESSION['grupo_sanguineo'] = $dados['grupo_sanguineo'];				
				$_SESSION['sexo'] = $dados['sexo'];
				require_once '../funcao/funcao_formulario.php';
				$data_nasc = dividir_data($dados['data_nasc']);
				$_SESSION['dia'] = $data_nasc[2];
				$_SESSION['mes'] = $data_nasc[1];
				$_SESSION['ano'] = $data_nasc[0];
				
				?>			
				<form method="post" action="verif_alt_atleta_rd.php">
					<table>
						<td style="visibility:hidden; display:none"><input type="text" name="cod_elemento_equipa" value="<?php echo $dados["cod_elemento_equipa"]; ?>"></td>
						<p class="altera_titulo">Alterar Atleta :</p>
						<tr>
							<td>Nome:</td> 
							<td><input type="text" name="nome" size="30" onblur="this.className='frm'" onfocus="this.className='frm-on'" value="<?= $dados['nome'];?>"maxlength="30" required></td>
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