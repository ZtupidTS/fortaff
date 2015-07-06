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
		function Classificacao()
		{
			var css = document.getElementsByName('classif');
			for(var i=0;i<css.length;i++)
			{
				css[i].style.visibility="visible";
				css[i].style.display="";
			}
			var css = document.getElementsByName('classif2');
			for(var i=0;i<css.length;i++)
			{
				css[i].style.visibility="hidden";
				css[i].style.display="none";
			}
		}
		function Classificacao2()
		{
			var css = document.getElementsByName('classif');
			for(var i=0;i<css.length;i++)
			{
				css[i].style.visibility="hidden";
				css[i].style.display="none";
			}
			var css = document.getElementsByName('classif2');
			for(var i=0;i<css.length;i++)
			{
				css[i].style.visibility="visible";
				css[i].style.display="";
			}
		}
		<?php include '../js/lugares_total.js';?>
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
			if(isset($_SESSION['class_cod_prova']))
			{
				$db_prova = mysql_query("SELECT * FROM tipo_prova WHERE cod_prova = '$_SESSION[class_cod_prova]'");
				$dados = mysql_fetch_array($db_prova);
			}else{
				$db_prova = mysql_query("SELECT * FROM tipo_prova WHERE cod_prova = '$_POST[cod_prova]'");
				$_SESSION['class_cod_prova'] = $_POST['cod_prova'];
				$dados = mysql_fetch_array($db_prova);
			}
			?>
			
			<div id="prova">
			Prova nº<?= $dados['cod_prova']; ?><br>
			<?php 
			echo $dados['nome_modalidade']; 
			include '../includes/sexo_imagem.php';
			?>
			</div>
			
			<table id="tabela">
				<tr>
					<th>Nº do classificado</th>
					<th>Descrição</th>
					<th>Classificação</th>
					<th name="classif" id="classif" style="visibility:hidden; display:none">Inserir<br>Classificação</th>
				</tr>
				<?php
				$class = 'linha_impar';
				$dados_linhas = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS linhas_total FROM delegacao WHERE estado_valido != 'X'"));
				include '../includes/linhas_tabelas.php';
				$class_prova = mysql_query("SELECT * FROM classificacao_prova WHERE cod_prova = '$_SESSION[class_cod_prova]' and estado_valido_classificado != 'X' ORDER BY IFNULL(classificacao,999999) ASC LIMIT $primeira_entrada,$linhas_por_pagina");
				if(mysql_num_rows($class_prova) < 1)
				{?>
					<td colspan="4">Não existem inscrições na prova</td>
					<?php
				}else{
					while($dados_classificacao = mysql_fetch_array($class_prova))
					{?>
						<tr class="<?php echo $class;?>">
							<form method="post" action="verif_alt_classificacao_co.php">
								<td style="visibility:hidden; display:none"><input type="text" name="cod_prova" value="<?php echo $dados_classificacao['cod_prova']; ?>"></td>
								<td style="visibility:hidden; display:none"><input type="text" name="cod_do_classificado[]" value="<?php echo $dados_classificacao['cod_do_classificado']; ?>"></td>
								<td><?php echo $dados_classificacao['cod_do_classificado'];?></td>
								<td>
								<?php
								if($dados['tipo'] == 'C')
								{
									$nome_equipa = mysql_query("SELECT * FROM equipa_with_delegacao WHERE cod_equipa = '$dados_classificacao[cod_do_classificado]'");
									$dados_nome = mysql_fetch_array($nome_equipa);?>
									<img src="../images/Bandeiras/<?= $dados_nome['cod_delegacao'];?>.png" class="bandeiras"/><?php echo $dados_nome['nome_pais'];
								}else{
									$nome_atleta = mysql_query("SELECT * FROM associar_el_delegacao WHERE cod_elemento_equipa = '$dados_classificacao[cod_do_classificado]'");
									$dados_nome = mysql_fetch_array($nome_atleta);?>
									<img src="../images/Bandeiras/<?= $dados_nome['cod_delegacao'];?>.png" class="bandeiras"/><?php echo $dados_nome['nome'];
								}?>
								</td>
								<td>
								<?php
								if(is_null($dados_classificacao['classificacao']))
								{
									echo '--';
								}else{
									echo $dados_classificacao['classificacao'];
								}?>
								</td>
								<td name="classif" id="classif" style="visibility:hidden; display:none">
								<input size="2" type="text" name="classificacao[]" value="<?= $dados_classificacao['classificacao'];?>" maxlength="5" onkeyup="this.value = LugaresTotal(this.value)">
								</td>
						</tr>
						<?php
						$class = ($class == 'linha_par') ? 'linha_impar' : 'linha_par';
					}
				}
				mysql_close($conexao);
				?>
					
			</table>
			<?php include '../includes/pagina_tabela.php';?>
			<!-- por as colunas a aparecer -->
			<div id="class_prova">
			<button class="botao" name="classif2" type="button" onclick="Classificacao()">Inserir Classificações</button>
			<button class="botao" name="classif" id="classif" onclick="Classificacao2()" style="visibility:hidden; display:none" type="submit">Submeter</button>
			</div>
			</form>
			

			<!-- em baixo -->
			<?php include '../includes/rodape.php';?>
			
			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
			
		</div>	
	</body>
</html>




