<?php 
session_start(); 
include '../includes/test_intruso_rd.php';
unset($_SESSION['elemento_a_alterar']);
unset($_SESSION['nome']);
unset($_SESSION['peso']);				
unset($_SESSION['altura']);				
unset($_SESSION['grupo_sanguineo']);				
unset($_SESSION['sexo']);
unset($_SESSION['dia']);
unset($_SESSION['mes']);
unset($_SESSION['ano']);

include '../includes/ligacao.php';
include '../includes/limit30.php';
#para o css feminino ou masculino
if(isset($_POST['sexo']))
{
	$_SESSION['sexo_css'] = $_POST['sexo'];
}
include '../includes/css_rd.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jogos Olimpicos 2012</title>
		<link href="<?= $css;?>" rel="stylesheet" type="text/css">
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/ico.ico">
		<script language="javascript">
		function Elimina(nome, cod)
		{
			if(confirm('Deseja Eliminar o atleta "'+nome+'"?'))
			{
				window.location.href = "verif_el_aux_atl_rd.php?cod_elemento_equipa="+cod;
			}
		}
		<?php include '../js/limit30.js';?>
		<?php include '../js/limit30_sempopup.js';?>
		<?php include '../js/dias_que_faltam.js';?>
		</script>
	</head>
	<!-- mensagem para por o popup a aparecer só uma vez -->
	<?php
	if(!(isset($_SESSION['mensagem_limit30'])))
	{?>
		<body onLoad="Limita30('<?= $data_devolvida;?>');">
		<?php
		if($data_devolvida < 30)
		{
			$_SESSION['mensagem_limit30'] = "";
		}else{
			unset($_SESSION['mensagem_limit30']);
			#meter o tempo que falta até o fim das alterações
			echo '<script>DiasFaltam();</script>';
		}
	}else{?>
		<body onLoad="Limita30SemPopup('<?= $data_devolvida;?>');">
		<?php
	}?>
		<div class="estrutura">
			<!-- cabeçalho -->
			<?php include '../includes/cabecalho_rd.php'; ?>

			<!-- menu a direita -->
			<?php include '../includes/bandeira.php'; ?>
			
			<!-- corpo -->
			<div class="estrutabela">
				<h1 class="titulo_rd">Atletas</h1>
				<?php 
				#include '../includes/limit30_sempopup.php';
				if(isset($_POST['cod_equipa']))
				{
					$_SESSION["cod_equipa"] = $_POST['cod_equipa'];
					$_SESSION["sexo_atleta"] = $_POST['sexo'];
				}#Recebe o cod_equipa pelo POST e coloca-a numa variável de sessão
				#include '../includes/ligacao.php';
				?>
				<table class="tabela">
					<tr>
						<th>Nome</th>
						<th>Data Nascimento</th>
						<th>Sexo</th>
						<th>Peso (Kg)</th>
						<th>Altura (cm)</th>
						<th>Grupo Sanguineo</th>
						<th>Estado</th>
						<th name="limit30" id="limit30">Alterar</th>
						<th name="limit30" id="limit30">Eliminar</th>
					</tr>
					<?php
					$db_elemento = mysql_query("SELECT * FROM elemento_in_equipa where cod_equipa ='$_SESSION[cod_equipa]' and estado_valido != 'X'");
					while($dados2 = mysql_fetch_array($db_elemento))
					{
						$db_atleta = mysql_query("SELECT * FROM dados_atletas WHERE cod_elemento_equipa = '$dados2[cod_elemento_equipa]' and cod_equipa ='$_SESSION[cod_equipa]' and estado_valido != 'X'");
						#verifica se é um atleta
						if(mysql_num_rows($db_atleta) > 0)
						{
						$dados = mysql_fetch_array($db_atleta);
						?>
						<tr>
							<td><?php echo $dados['nome']; ?></td>
							<td>
							<?php 
							require_once '../funcao/funcao_formulario.php';
							echo inverte_data($dados['data_nasc'])
							?>
							</td>
							<td><?php echo $dados['sexo']; ?></td>
							<td><?php echo $dados['peso']; ?></td>
							<td><?php echo $dados['altura']; ?></td>
							<td><?php echo $dados['grupo_sanguineo']; ?></td>
							<td><?php include '../includes/image_val_pen.php';?></td>
							<!-- alterar atleta -->
							<form method="post" action="alt_atleta_rd.php">
								<td style="visibility:hidden; display:none"><input type="text" name="cod_elemento_equipa" value="<?php echo $dados['cod_elemento_equipa']; ?>"></td>
								<td name="limit30" id="limit30"><button class="botão_opções" name="limit30" id="limit30" type="submit"><img src="../images/altera.png" name="Altera" alt="Altera" title="Altera"/></button></td>
							</form>	
							<!-- eliminar atleta -->
							<td name="limit30" id="limit30"><button class="botão_opções" name="limit30" id="limit30" type="button" onclick="Elimina('<?= $dados['nome'];?>', '<?= $dados['cod_elemento_equipa'];?>')"><img src="../images/eliminar.png" name="eliminar" alt="Eliminar" title="Eliminar"/></button></td>
						</tr>
						<?php
						}
					}// fim do ciclo para escrever os dados na tabela
					mysql_close($conexao);
					?>
				</table>
				
				<!-- os botões -->
				<input name="limit30" id="limit30" type="button" value="Acrescentar Atleta" onclick="window.location.href='acrescentar_atleta_rd.php'" class="botao">
				<input type="button" value="Actualizar" onclick="window.location.href='atletas_rd.php'" class="botao">		
				<input type="button" value="Inserir e visualizar atletas nas provas" onclick="window.location.href='ins_atleta_prova_rd.php'" class="botao">	
				<input type="button" value="Voltar" onclick="window.location.href='area_gestao_rd.php'" class="botao">
			</div>	
					
			<!-- o tempo que falta -->
			<?php include '../includes/limit30_sempopup.php'; ?>
			
			<!-- rodape -->
			<?php include '../includes/rodape_rd.php';?>
			
			<!-- include para a mensagem popup -->
			<?php include '../includes/mensagem_popup.php';?>
			
		</div>		
	</body>	
</html>	