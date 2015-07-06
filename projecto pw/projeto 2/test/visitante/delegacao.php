<?php include 'includes/cabecalho.php';?>

	<!-- corpo -->
			<div class="titulo"> Delegações </div>
			<?php
			$db = mysql_query("SELECT * FROM delegacao WHERE cod_delegacao != 'co' and estado_valido = 'V' ORDER BY nome_pais");
			?>
			<table id="results">
				<tr>
					<th>País</th>
					<th>Nome Responsável</th>
					<th>Contacto</th>									
				</tr>
				<?php
				$class = 'linha_impar';
				while($dados = mysql_fetch_array($db))
				{
					?>
					<tr class="<?php echo $class;?>">
						<td class="delegação_nome">
							<img src="../images/Bandeiras/<?= $dados['cod_delegacao'];?>.png" class="bandeiras"/>
							<?php echo $dados['nome_pais']; ?>
						</td>
						<td><?php echo $dados['nome_responsavel']; ?></td>
						<td><?php echo $dados['email']; ?></td>
					</tr>
					<?php
					$class = ($class == 'linha_par') ? 'linha_impar' : 'linha_par';
				}
				
				?>
			</table>
			<?php include 'includes/paginacao_tabela.php';?>
			<!-- em baixo -->
			<?php include 'includes/rodape.php';?>
