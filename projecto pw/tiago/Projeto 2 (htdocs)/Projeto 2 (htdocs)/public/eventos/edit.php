<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
?>
	<script type="text/javascript">
		function validationVote() 
		{
			if (document.evento.apreciacao.value == "-1" || document.evento.nome_utilizador.value == "") {
				return false;
			} else {
				return true;
			}
		}	
	</script>
<?php
	include_once rootPath('includes/sijo/master_header.php', 1);
?>
<?php
	$update = isset($_POST['id_evento']);
	$evento = null;
	$id_evento = "-1";
	$id_local ="";
	$designacao ="";
	$data_hora = "";
	$duracao = "";
	$preco_bilhete = "";
	$lugares_vendidos = "";
	$lugares_reservados = "";
	$status = "V";
	$descricao = "";
	$local_nome = "";
	$num_lugares = "";

	if ($update) {
		$evento = eventosGet($_POST['id_evento']);
		$id_evento = $evento['id_evento'];
		$id_local = $evento['id_local'];
		$designacao = $evento['designacao'];
		$data_hora = $evento['data_hora'];
		$duracao = $evento['duracao'];
		$preco_bilhete =  $evento['preco_bilhete'];
		$lugares_vendidos = $evento['lugares_vendidos'];
		$lugares_reservados = $evento['lugares_reservados'];
		$status = $evento['status'];
		$descricao = $evento['descricao'];
		$local_nome = $evento['local_nome'];
		$num_lugares = $evento['num_lugares'];
	} else {
		header("location: index.php");
		exit();
	}
	
?>
<h1 class="header_h1">Eventos</h1>
<div style="float: left; margin-right: 24px;">
		<table>
			<tr>
				<td>
					<label for="id">ID:</label>
				</td>
				<td>
					<input type="text" id="id" value="<?= $id_evento ?>" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Designação:</label>
				</td>
				<td>
					<input type="text" name="designacao" value="<?= $designacao ?>" readonly="readonly" size="30" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Data/hora:</label>
				</td>
				<td>
					<input type="text" name="data_hora" value="<?= $data_hora ?>" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Duração: [min]</label>
				</td>
				<td>
					<input type="text" name="duracao" value="<?= $duracao ?>" readonly="readonly" />
				</td>
			</tr>	
			<tr>
				<td>
					<label>Preço Bilhete: [€]</label>
				</td>
				<td>
					<input type="text" name="preco_bilhete" value="<?= $preco_bilhete ?>" readonly="readonly" />
				</td>
			</tr>	
			<tr>
				<td>
					<label>Descrição:</label>
				</td>
				<td>
					<textarea name="descricao" readonly="readonly" rows="7" cols="50" ><?= $descricao ?></textarea>
				</td>
			</tr>		
			<tr>
				<td>
					<label>Local:</label>
				</td>
				<td>
					<input type="text" value="<?= $local_nome ?> - <?= $num_lugares ?>" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Lugares Vendidos:</label>
				</td>
				<td>
					<input type="text" name="lugares_vendidos" value="<?= $lugares_vendidos ?>" readonly="readonly" />
				</td>
			</tr>	
			<tr>
				<td>
					<label>Lugares Reservados:</label>
				</td>
				<td>
					<input type="text" name="lugares_reservados" value="<?= $lugares_reservados ?>" readonly="readonly" />
				</td>
			</tr>
<?php
	if ($user_authenticated) {
?>
		<tr>
			<td>
				<label>Bilhetes:</label>
			</td>
			<td>
				<form name="evento" action="/pw606/myacount/ticket/buy.php" method="post">
					<input type="hidden" name="acontecimento" value="E" />
					<input type="hidden" name="id_entidade" value="<?= $id_evento ?>" />
					<input type="hidden" name="nome" value="<?= $designacao ?>" />
					<input type="hidden" name="data" value="<?= $data_hora ?>" />
					<input type="hidden" name="duracao" value="<?= $duracao ?>" />
					<input type="hidden" name="id_local" value="<?= $id_local ?>" />
					<input type="hidden" name="id_visitante" value="<?= $current_user['id_visitante'] ?>" />
					<input type="submit" name="tipo" value="Comprar" />
					<input type="submit" name="tipo" value="Reservar" />
					<input type="hidden" name="preco" value="<?= $preco_bilhete ?>" />
				</form>
			</td>
		</tr>
<?php
		$now_date = new DateTime();
		$obj_data_hora = new DateTime($data_hora);
		if ($obj_data_hora->getTimestamp() < $now_date->getTimestamp() && $user_authenticated) {
			$exist = apreciacaoExist($id_evento, $current_user['id_visitante']);
?>
		<tr>
			<td>
				<label>Apreciação:</label>
			</td>
			<td>
				<form name="evento" action="edit_db.php" method="post">
<?php
			if ($exist) {
			
				$apreciacao = apreciacaoGet($id_evento, $current_user['id_visitante']);
				
				$_SESSION['rating_object']['id'] = 'ratingid' . $id_evento;
				$_SESSION['rating_object']['name'] = 'ratingname' . $id_evento;
				$_SESSION['rating_object']['value'] = $apreciacao["apreciacao"];
				$_SESSION['rating_object']['readonly'] = 'true';
				include rootPath('includes/rating_object.php', 1);
		
			} else {
			
				$_SESSION['rating_object']['id'] = 'inputapreciacao';
				$_SESSION['rating_object']['name'] = 'apreciacao';
				include rootPath('includes/rating_object.php', 1);
?>
					<input type="hidden" name="id_evento" value="<?= $id_evento ?>" />
					<input type="hidden" name="status" value="<?= $status ?>" />
					<input type="hidden" name="id_visitante" value="<?= $current_user['id_visitante'] ?>" />
					<input type="submit" name="votar" value="Votar" onclick="return validationVote();" />
				</form>
<?php
			}
?>
			</td>
		</tr>
<?php
		}
	}
	$local = localGet($id_local);
?>		
	</table>
<a href="edit_db.php" class="seta-invertida">Voltar</a>
</div>
<div id="mapG" style="height:400px; width:400px;"></div>
<script type="text/javascript">
	map = new createGoogleMaps($("mapG"));
	p = map.addPoint(<?= $local['latitude'] ?>, <?= $local['longitude'] ?>, "");
	map.setCenter(p.lat(), p.lng());
</script>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>