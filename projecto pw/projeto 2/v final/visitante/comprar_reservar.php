<?php
include 'includes/cabecalho.php';

if(!(isset($_SESSION['id_vis'])))
{
	header('Location: visitante.php');
}
$path_part = pathinfo($_SERVER['HTTP_REFERER']);
#echo $path_part['basename'];
if(strpos($path_part['basename'], 'provas') === false)
{
	$pr_ou_ev = 'evento';	
}else{
	$pr_ou_ev = 'prova';	
}
$dados = mysql_fetch_array(mysql_query("SELECT * FROM $pr_ou_ev WHERE cod_".$pr_ou_ev." = '$_POST[cod]'"));

#aqui começa os ciclos para criar o meu array em javascript que vai ser uma varivael global

#recuperei os dados do produto que compra
$db_compra = mysql_fetch_array(mysql_query("SELECT * FROM ".$pr_ou_ev." WHERE cod_".$pr_ou_ev." = '$_POST[cod]'"));
#aqui recupero os produtos já comprados no mesmo dia
$db_pr = mysql_query("SELECT * FROM co_re_prova WHERE id_vis = '$_SESSION[id_vis]' and data = '$db_compra[data]'");
$db_ev = mysql_query("SELECT * FROM co_re_evento WHERE id_vis = '$_SESSION[id_vis]' and data = '$db_compra[data]'");

#variavel que vai me servir para parar com os ciclos
$_SESSION['fim'] = false;

$tempo_array = array();
$tempo_qtd = 0;

require_once '../funcao/funcao_diff_data.php';

if(mysql_num_rows($db_pr) > 0)
{
	while($dados_hora = mysql_fetch_array($db_pr))
	{
		if($db_compra['hora_inicio'] < $dados_hora['hora_inicio']) 
		{
			$hora_ini_mais_duracao_compra = adicionar_duas_horas($db_compra['hora_inicio'],$db_compra['duracao']);
			if($dados_hora['hora_inicio'] < $hora_ini_mais_duracao_compra[0])
			{
				$_SESSION['mensagem'] = 'Essa compra/reserva vai se realizar durante uma prova/evento já comprado';
				$_SESSION['fim'] = true;
				$tempo_array = array();
			}
			if($dados_hora['hora_inicio'] > $hora_ini_mais_duracao_compra[0] && !$_SESSION['fim'])
			{
				$hora_timestamp = convert_to_timestamp($dados_hora['hora_inicio']);
				$dif_tempo = $hora_timestamp - $hora_ini_mais_duracao_compra[1];
				$tempo_array[$tempo_qtd] = array("tempo" => $dif_tempo, "chegada_lat" => $dados_hora['lat'], "chegada_lng" => $dados_hora['lng'], "partida_lat" => $db_compra['lat'], "partida_lng" => $db_compra['lng']);
				$tempo_qtd++;
			}				
		}
		#aqui se a hora coincide com outra já comprado
		if($db_compra['hora_inicio'] == $dados_hora['hora_inicio'] && !$_SESSION['fim']) 
		{
			$_SESSION['mensagem'] = 'Essa compra/reserva tem a mesma hora de inicio de outra uma prova/evento já comprado';
			$_SESSION['fim'] = true;
			$tempo_array = array();
		}
		#aqui vejo se a hora da compra é superior a hora de inicio do ja comprado
		if($db_compra['hora_inicio'] > $dados_hora['hora_inicio'] && !$_SESSION['fim'])
		{
			$hora_ini_mais_duracao = adicionar_duas_horas($dados_hora['hora_inicio'],$dados_hora['duracao']);
			if($db_compra['hora_inicio'] < $hora_ini_mais_duracao[0])
			{
				#aqui quer dizer que o que quer comprar inicia durante a atuação de outra já comprada
				$_SESSION['mensagem'] = 'Essa compra/reserva vai se realizar durante uma prova/evento já comprado';
				$_SESSION['fim'] = true;
				$tempo_array = array();
			}
			if($db_compra['hora_inicio'] > $hora_ini_mais_duracao[0] && !$_SESSION['fim'])
			{
				$hora_compra_timestamp = convert_to_timestamp($db_compra['hora_inicio']);
				$dif_tempo = $hora_compra_timestamp - $hora_ini_mais_duracao[1];
				$tempo_array[$tempo_qtd] = array("tempo" => $dif_tempo, "partida_lat" => $dados_hora['lat'], "partida_lng" => $dados_hora['lng'], "chegada_lat" => $db_compra['lat'], "chegada_lng" => $db_compra['lng']);
				$tempo_qtd++;				
			}
		}
		if($_SESSION['fim']) break;
	}
}
if(mysql_num_rows($db_ev) > 0 && !$_SESSION['fim'])
{
	while($dados_hora = mysql_fetch_array($db_ev))
	{
		if($db_compra['hora_inicio'] < $dados_hora['hora_inicio']) 
		{
			$hora_ini_mais_duracao_compra = adicionar_duas_horas($db_compra['hora_inicio'],$db_compra['duracao']);
			if($dados_hora['hora_inicio'] < $hora_ini_mais_duracao_compra[0])
			{
				$_SESSION['mensagem'] = 'Essa compra/reserva vai se realizar durante uma prova/evento já comprado';
				$_SESSION['fim'] = true;
				$tempo_array = array();
			}
			if($dados_hora['hora_inicio'] > $hora_ini_mais_duracao_compra[0] && !$_SESSION['fim'])
			{
				$hora_timestamp = convert_to_timestamp($dados_hora['hora_inicio']);
				$dif_tempo = $hora_timestamp - $hora_ini_mais_duracao_compra[1];
				$tempo_array[$tempo_qtd] = array("tempo" => $dif_tempo, "chegada_lat" => $dados_hora['lat'], "chegada_lng" => $dados_hora['lng'], "partida_lat" => $db_compra['lat'], "partida_lng" => $db_compra['lng']);
				$tempo_qtd++;
			}				
		}
		#aqui se a hora coincide com outra já comprado
		if($db_compra['hora_inicio'] == $dados_hora['hora_inicio'] && !$_SESSION['fim']) 
		{
			$_SESSION['mensagem'] = 'Essa compra/reserva tem a mesma hora de inicio de outra uma prova/evento já comprado';
			$_SESSION['fim'] = true;
			$tempo_array = array();
		}
		#aqui vejo se a hora da compra é superior a hora de inicio do ja comprado
		if($db_compra['hora_inicio'] > $dados_hora['hora_inicio'] && !$_SESSION['fim'])
		{
			$hora_ini_mais_duracao = adicionar_duas_horas($dados_hora['hora_inicio'],$dados_hora['duracao']);
			if($db_compra['hora_inicio'] < $hora_ini_mais_duracao[0])
			{
				#aqui quer dizer que o que quer comprar inicia durante a atuação de outra já comprada
				$_SESSION['mensagem'] = 'Essa compra/reserva vai se realizar durante uma prova/evento já comprado';
				$_SESSION['fim'] = true;
				$tempo_array = array();
			}
			if($db_compra['hora_inicio'] > $hora_ini_mais_duracao[0] && !$_SESSION['fim'])
			{
				$hora_compra_timestamp = convert_to_timestamp($db_compra['hora_inicio']);
				$dif_tempo = $hora_compra_timestamp - $hora_ini_mais_duracao[1];
				$tempo_array[$tempo_qtd] = array("tempo" => $dif_tempo, "partida_lat" => $dados_hora['lat'], "partida_lng" => $dados_hora['lng'], "chegada_lat" => $db_compra['lat'], "chegada_lng" => $db_compra['lng']);
				$tempo_qtd++;				
			}
		}
		if($_SESSION['fim']) break;
	}
}
?>
	
	<!-- corpo -->
	<script type="text/javascript" language="javascript" src="js/calc_valor_cambio.js"></script>
	<script type="text/javascript" language="javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" language="javascript" src="js/pontostempo.js"></script>
	<script type="text/javascript" language="javascript" src="js/tempo2pontos.js"></script>
	<script type="text/javascript" language="javascript">
	function tipoCompra()
	{
		var selectedMode = $("tipo").value;
		if(selectedMode == 'compra')
		{
			var css = document.getElementsByName('comprar');
			for(var i=0;i<css.length;i++)
			{
				css[i].style.visibility="visible";
				css[i].style.display="";
			}
			var css = document.getElementsByName('reservar');
			for(var i=0;i<css.length;i++)
			{
				css[i].style.visibility="hidden";
				css[i].style.display="none";
			}
		}else{
			var css = document.getElementsByName('comprar');
			for(var i=0;i<css.length;i++)
			{
				css[i].style.visibility="hidden";
				css[i].style.display="none";
			}
			var css = document.getElementsByName('reservar');
			for(var i=0;i<css.length;i++)
			{
				css[i].style.visibility="visible";
				css[i].style.display="";
			}
		}
	}
	</script>
	
		<div class="titulo"> Compra ou Reserva de Bilhetes </div>
		<table id="results">
			<form method="POST" action="verif_co_re.php">
				<tr>
					<th colspan="2">
						<?php
							if($pr_ou_ev == 'prova')
							{
								$dados_mod = mysql_fetch_array(mysql_query("SELECT * FROM modalidade WHERE cod_modalidade = '$dados[cod_modalidade]'"));
								echo 'Prova : '.$dados_mod['nome_modalidade'];
								if($dados['sexo'] == 'M')
								{
									?><img src="../images/sexo/sexo_masculino.png" class="bandeiras"/><?php 
								}else{
									?><img src="../images/sexo/sexo_feminino.png" class="bandeiras"/><?php 
								}
								$item_name = $dados_mod['nome_modalidade'];
							}else{
								echo $dados['designacao'].': '.$dados['descricao'];
								$item_name = $dados['descricao'];
							}
						?>
					</th>
				</tr>
				<tr>
					<td style="visibility:hidden; display:none"><input type="text" name="cod" value="<?= $_POST['cod']; ?>"></td>
					<td style="visibility:hidden; display:none"><input type="text" name="pr_ou_ev" value="<?= $pr_ou_ev; ?>"></td>
					<td>Tipo</td>
					<td>
						<select name="tipo" id="tipo" onChange="tipoCompra()">
							<option value="reserva">Reserva</option>
							<option value="compra">Compra</option>
						</select>
					</td>				
				</tr>		
				<tr>
					<td>Quantidade</td>
					<td>
						<?php
						$lug_vaz = mysql_fetch_array(mysql_query("SELECT * FROM lugares_vazios_".$pr_ou_ev." WHERE cod_".$pr_ou_ev." = '$_POST[cod]'"));
						if ($lug_vaz['lugar_vazios'] >= 4)
						{
							if(isset($_POST['qtd_comprada']))
							{
								$valor_qtd = 4 - $_POST['qtd_comprada'];
								?>
								<select name="qtd" id="qtd" onchange="calcValor();">
									<?php
									for($i=1;$i<=$valor_qtd;$i++)
									{?>
										<option value="<?= $i;?>"><?= $i;?></option>
										<?php
									}?>
								</select>
								<?php
							}else{
								?>
								<select name="qtd" id="qtd" onchange="calcValor();">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
								<?php
							}
						}else{
							if(isset($_POST['qtd_comprada']))
							{
								$valor_qtd = 4 - $_POST['qtd_comprada'];
								if($lug_vaz['lugar_vazios'] >= $valor_qtd)
								{
									?>
									<select name="qtd" id="qtd" onchange="calcValor();">
									<?php
									for($i=1;$i<=$valor_qtd;$i++)
									{?>
										<option value="<?= $i;?>"><?= $i;?></option>
										<?php
									}?>
									</select>
									<?php
								}else{
									?>
									<select name="qtd" id="qtd" onchange="calcValor();">
									<?php
									for($i=1;$i<=$lug_vaz['lugar_vazios'];$i++)
									{?>
										<option value="<?= $i;?>"><?= $i;?></option>
										<?php
									}?>
									</select>
									<?php
								}
							}else{
								?>
								<select name="qtd" id="qtd" onchange="calcValor();">
									<?php
									for($i=1;$i<=$lug_vaz['lugar_vazios'];$i++)
									{?>
										<option value="<?= $i;?>"><?= $i;?></option>
										<?php
									}?>
								</select>
								<?php
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td>Valor</td>
					<td>
						<input style="visibility:hidden; display:none" type="text" id="old_preco" name="old_preco" readonly value="<?= $dados['preco'];?>" size="4"/>
						<div id="valor">
							<span id="novo_preco"><?= $dados['preco'].' €  Para';?></span>
							<?php
							$moeda = mysql_query("SELECT * FROM moeda");
							?>
							<select name="moeda" id="moeda" onchange="calcMoeda();">
								<?php
								while($dados_moeda = mysql_fetch_array($moeda))
								{?>
									<option value="<?= $dados_moeda['moeda'];?>"><?= $dados_moeda['moeda'];?></option>
									<?php
								}?>
							</select>
							<span id="cambio"></span>
						</div>
					</td>
				</tr>
				<tr>
					<td>Receber confirmação Por SMS:</td>
					<td>
						<input type="checkbox" name="sms" value="sms"/>
					</td>
				</tr>
				<tr name="reservar" >
					<td colspan=2>
						<button type="submit">Reservar</button>
					</td>
				</tr>
			</form>
			<tr name="comprar" style="visibility:hidden; display:none">
				<td colspan="2">
					<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="business" value="ricain_1327624829_per@gmail.com">
						<input type="hidden" name="lc" value="EUR">
						<input type="hidden" name="item_name" value="<?= $pr_ou_ev; ?>:<?= $_POST['cod']; ?>:<?= $item_name;?>:<?= $_SESSION['id_vis'];?>">
						<input type="hidden" name="item_number" id="item_number" value="">
						<input type="hidden" name="amount" id="amount" value="">
						<input type="hidden" name="currency_code" value="EUR">
						<input type="hidden" name="button_subtype" value="services">
						<input type="hidden" name="no_note" value="0">
						<input type="hidden" name="cn" value="Add special instructions to the seller">
						<input type="hidden" name="no_shipping" value="1">
						<!-- return da pagina onde vou receber os dados ipn do paypal -->
						<input name="notify_url" type="hidden" value="http://pw-jre.heliohost.org/visitante/paypal/paypal.php" />
						<!-- return da pagina ok -->
						<input name="return" type="hidden" value="http://pw-jre.heliohost.org/visitante/<?= $pr_ou_ev.'s.php';?>" />
						<!-- return da pagina not ok -->
						<input name="cancel_return" type="hidden" value="http://pw-jre.heliohost.org/visitante/<?= $pr_ou_ev.'s.php';?>" />
												
						<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
						<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
				</td>
			</tr>
		</table>
		
		<script>
			calcValor();
		</script>
		
		<!-- inicialize google maps para me dar o tempo do trajeto -->
		<?php
		
		if(!$_SESSION['fim'] && (sizeOf($tempo_array) > 0))
		{
			include 'includes/pontostempo.php';
			?>
			<script>
				calcRoute();
			</script>
			<?php
		}?>
		
		<!-- em baixo -->
		<?php include 'includes/rodape.php';?>
</html>