<?php 
if(!isset($_POST['cod_prova']))
{
	header('Location: provas.php');
}
include 'includes/cabecalho.php';
?>
	
	<!-- corpo -->
		<?php 
		$db = mysql_query("SELECT * FROM tipo_prova WHERE cod_prova = '$_POST[cod_prova]'");
		$dados = mysql_fetch_array($db);
		?>
		<div id="prova">
			Prova nº<?= $dados['cod_prova']; ?><br>
			<?php 
			echo $dados['nome_modalidade']; 
			include '../includes/sexo_imagem.php';
			?>
		</div>
		
		<table id="results">
			<tr>
				<th>Nº do classificado</th>
				<th>Descrição</th>
				<th>Classificação</th>
				<th name="classif" id="classif" style="visibility:hidden; display:none">Inserir<br>Classificação</th>
			</tr>
			<?php
			$class = 'linha_impar';
			$db = mysql_query("SELECT * FROM classificacao_prova WHERE cod_prova = '$_POST[cod_prova]' and estado_valido_classificado != 'X' ORDER BY IFNULL(classificacao,999999) ASC");
			if(mysql_num_rows($db) < 1)
			{?>
				<td colspan="4">Não existem classificações na prova</td>
				<?php
			}else{
				while($dados_classificacao = mysql_fetch_array($db))
				{?>
					<tr class="<?php echo $class;?>">
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
					</tr>
					<?php
					$class = ($class == 'linha_par') ? 'linha_impar' : 'linha_par';
				}
			}
			?>
		</table>
		
		<?php include 'includes/paginacao_tabela.php';?>
		<a id="voltar" href="provas.php" title="Voltar">Voltar</a>
		
		<!-- em baixo -->
		<?php include 'includes/rodape.php';?>
</html>