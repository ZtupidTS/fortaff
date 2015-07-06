<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
?>
<?php
	$update = isset($_POST['id_local']);
	$local = null;
	$id_local = "-1";
	$nome = "";
	$descricao = "";
	$num_lugares = "";
	$latitude = "";
	$longitude = "";	
	
	if ($update) {
		$local = localGet($_POST['id_local']);
		$id_local = $local['id_local'];
		$nome = $local['nome'];
		$descricao = $local['descricao'];
		$num_lugares = $local['num_lugares'];
		$latitude = $local['latitude'];
		$longitude = $local['longitude'];		
	}
	
	$isNew = ($id_local == '-1');
	
?>
<h1 class="header_h1">Locais</h1>
<div style="float: left; margin-right: 50px;">
	<form name="local" action="edit_db.php" method="post">
		<div id="meteo" align="right">
			
		</div>
		<table>
			<tr>
				<td>
					<label for="id">ID:</label>
				</td>
				<td>
					<input type="text" id="id" value="<?= $id_local ?>" disabled="disabled" />
					<input type="hidden" name="id_local" value="<?= $id_local ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label>Nome:</label>
				</td>
				<td>
					<input type="text" name="nome" value="<?= $nome ?>" disabled="disabled"/>
				</td>
			</tr>
			<tr>
				<td>
					<label>Descrição:</label>
				</td>
				<td>
					<textarea name="descricao" rows="7" cols="80" disabled="disabled"><?= $descricao ?> </textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label>Lotação:</label>
				</td>
				<td>
					<input type="text" name="num_lugares" value="<?= $num_lugares ?>" disabled="disabled"/>
				</td>
			</tr>
			<tr>
				<td>
					<label>Latitude:</label>
				</td>
				<td>
					<input type="text" name="latitude" value="<?= $latitude ?>"/>
					<span id="validatorLotacao" class="validatorField" title="A latitude tem de ser um valor numérico!">*</span>
				</td>
			<tr>
			</tr>				
				<td>
					<label>Longitude:</label>
				</td>
				
				<td>
					<input type="text" name="longitude" value="<?= $longitude ?>"/>
					<span id="validatorLotacao" class="validatorField" title="A longitude tem de ser um valor numérico!">*</span>
				</td>
			</tr>			
		</table>
	</form>
<a href="edit_db.php" class="seta-invertida">Voltar</a>
</div>
<div id="mapG" style="height:400px; width:400px;"></div>
<script type="text/javascript">
	map = new createGoogleMaps($("mapG"));
	p = map.addPoint(<?= $latitude ?>, <?= $longitude ?>, "asdsdsd");
	map.setCenter(p.lat(), p.lng());
</script>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>