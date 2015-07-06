<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
?>
<?php
	include_once rootPath('includes/sijo/master_header.php', 1);
?>
<?php
	$_POST['tipo'] = substr($_POST['tipo'], 0, 1) == 'C' ? 'C' : 'R';

	$b = bilheteGetByFiltro($current_user['id_visitante'], null, array('X'));
	$local = localGet($_POST['id_local']);
	$x = array();
	
	while ($a = foreachRow($b)) {
		$x[] = array('id_bilhete' => $a['id_bilhete'],
					 'acontecmento' => $a['acontecimento'],
					 'acontecimento_tipo' => $a['acontecimento_tipo'],
					 'tipo_descricao' => $a['tipo_descricao'],
					 'id_entidade' => $a['id_entidade'],
					 'acontecimento_data' => strtotime($a['acontecimento_data']),
					 'acontecimento_dataString' => $a['acontecimento_data'],
					 'acontecimento_duracao' => $a['acontecimento_duracao'] * 60,
					 'latitude' => $a['latitude'],
					 'longitude' => $a['longitude'],
					 'acontecimento_designacao' => utf8_encode($a['acontecimento_designacao']));
	}
	
?>
<h1 class="header_h1"><?= $_POST['tipo'] == 'C' ? 'Compra' : 'Reserva' ?> de Bilhete</h1>
<form action="buy_db.php" method="post">
	<table>
		<tr>
			<td>
				<label><?= $_POST['acontecimento'] == 'E' ? 'Evento' : 'Prova' ?>:</label>
			</td>
			<td>
				<input type="text" value="<?= $_POST['nome'] ?>" readonly="readonly" />
			</td>
		</tr>
		<tr>
			<td><label>Data:</label></td>
			<td>
				<input type="text" value="<?= $_POST['data'] ?>" readonly="readonly" />
			</td>
		</tr>
		<tr>
			<td><label>Preço:</label></td>
			<td>
				<select id="preco" name="preco">
					<option value="<?= $_POST['preco'] ?>"><?= ujson_decode(convert($_POST["preco"], 'euro', 'euro'))->rhs; ?></option>
					<option value="<?= $_POST['preco'] ?>"><?= ujson_decode(convert($_POST["preco"], 'euro', 'usd'))->rhs; ?></option>
					<option value="<?= $_POST['preco'] ?>"><?= ujson_decode(convert($_POST["preco"], 'euro', 'pound'))->rhs; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label>Quantidade:</label></td>
			<td>
				<select id="quantidade" name="quantidade" >
	<?php
			for ($i = 1; $i <= 20; $i++) {
	?>
						<option value="<?= $i ?>"><?= $i ?></option>
	<?php	
			}
	?>
				</select>
			</td>
		</tr>
	</table>
	<input type="hidden" name="tipo" value="<?= $_POST['tipo'] ?>" />
	<input type="hidden" name="acontecimento" value="<?= $_POST['acontecimento'] ?>" />
	<input type="hidden" name="id_entidade" value="<?= $_POST['id_entidade'] ?>" />
	<input type="hidden" name="id_visitante" value="<?= $current_user['id_visitante'] ?>" />
	<input type="submit" name="confirm" value="Confirmar" />
</form>
<div id="alertas" style="margin-top: 10px;"></div>
<script type="text/javascript">
	

	$j(document).ready(test);
	
	function test() {
		var bilhetes = eval('(<?= ujson_encode($x) ?>)');
		for (var i = 0; i < bilhetes.length; i++) {
			calcDistance(bilhetes[i], <?= $local['latitude'] ?>, <?= $local['longitude'] ?>);
		}
	}
	
	function calcDistance(bilhete, destinationLat, destinationLng) {
		
		var selectedmode = 'DRIVING'; //bicycling driving walking
		var request = {
			origin: new google.maps.LatLng(destinationLat, destinationLng),
			destination: new google.maps.LatLng(bilhete.latitude, bilhete.longitude),
			travelMode: google.maps.TravelMode["DRIVING"]
		};
		
		directionsService = new google.maps.DirectionsService();
		directionsService.route(request,
			function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					// directionsDisplay.setDirections(result);
					//computeTotalDistance(result);
					computeTotalTempo(bilhete, result);
				}
			}
		);
	}
	
	function computeTotalTempo(bilhete, result) {
		var total = 0;
		var myroute = result.routes[0];
		for (i = 0; i < myroute.legs.length; i++) {
			total += myroute.legs[i].duration.value;
		}
		
		var evento_date = <?= strtotime($_POST['data']) ?>;
		var evento_duracao = <?= $_POST['duracao'] ?>;
		
		if (evento_date < bilhete.acontecimento_data) {
			if ((evento_date + evento_duracao + total) > bilhete.acontecimento_data) {
				alertBilhete(bilhete);
			}
		} else if (bilhete.acontecimento_data < evento_date) {
			if ((bilhete.acontecimento_data + bilhete.acontecimento_duracao + total) > evento_date) {
				alertBilhete(bilhete);
			}
		}
	}
	
	function alertBilhete(bilhete) {
		var message = "Já tem um bilhete para o evento " + bilhete.acontecimento_designacao + " no dia " + bilhete.acontecimento_dataString + " com duração de " + (bilhete.acontecimento_duracao/60) + " minutos, que se sobrepõe ao actual evento que pretende participar!";
		$j('#alertas').append('<div class="informationmsg">' + message + '</div>');
	}

</script>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>
