<?php include 'includes/cabecalho.php';?>
	
	<!-- corpo -->	
	<div class="titulo"> Eventos </div>
		<?php
		$db = mysql_query("SELECT * FROM evento WHERE estado_valido = 'V'");
		?>
		<table id="results">
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
				<!-- esse campo só pode aparecer aos registados -->
				<?php
				if(isset($_SESSION['id_vis']))
				{?>
					<th>Reservar/Comprar</th>
					<?php
				}?>
			</tr>
			<?php
			$class = 'linha_impar';
			while($dados = mysql_fetch_array($db))
			{
				?>
				<tr class="<?php echo $class;?>">
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
							?>
							<br>
							<?php
							echo 'Votos: '.$dados_class_media['votos'];
						}
						?>
					</td>
					<!-- comprar -->
					<form method="POST" action="comprar_reservar.php">
						<?php
						if(isset($_SESSION['id_vis']))
						{
							if($dados_lug_vazio['lugar_vazios'] > 0)
							{
								$db_compra_qtd = mysql_query("SELECT * FROM reserva_compra WHERE id_vis = '$_SESSION[id_vis]' and tipo = 'PR' and cod_sessao = '$dados[cod_evento]'");
								if(mysql_num_rows($db_compra_qtd) > 0)
								{
									$dados_qtd_comprado = mysql_fetch_array($db_compra_qtd);
									if($dados_qtd_comprado['quant'] < 4)
									{
										?>
										<td style="visibility:hidden; display:none"><input type="text" name="cod" value="<?php echo $dados['cod_evento']; ?>"></td>
										<td style="visibility:hidden; display:none"><input type="text" name="qtd_comprada" value="<?= $dados_qtd_comprado['quant'];?>"></td>
										<td><button class="butão_opções" type="submit"><img src="../images/vis/comprar.png" alt="Comprar/Reservar" title="Comprar/Reservar"/></button></td>
										<?php										
									}else{?>
										<td><button class="butão_opções" type="button"><img src="../images/vis/nao_comprar.png" alt="Comprar/Reservar" title="Comprar/Reservar"/></button></td>
										<?php									
									}
								}else{
									?>
									<td style="visibility:hidden; display:none"><input type="text" name="cod" value="<?php echo $dados['cod_evento']; ?>"></td>
									<td><button class="butão_opções" type="submit"><img src="../images/vis/comprar.png" alt="Comprar/Reservar" title="Comprar/Reservar"/></button></td>
									<?php
								}
							}else{?>
								<td><button class="butão_opções" type="button"><img src="../images/vis/nao_comprar.png" alt="Comprar/Reservar" title="Comprar/Reservar"/></button></td>
								<?php
							}
						}?>
					</form>
				</tr>
				<?php
				$class = ($class == 'linha_par') ? 'linha_impar' : 'linha_par';
			}
			?>
		</table>
		
		<?php include 'includes/paginacao_tabela.php';?>
		
		<!-- em baixo -->
		<?php include 'includes/rodape.php';?>
</html>