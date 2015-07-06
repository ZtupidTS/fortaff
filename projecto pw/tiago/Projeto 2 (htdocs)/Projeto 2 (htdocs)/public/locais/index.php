<?php
	require_once '../../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
?>
<h1 class="header_h1">
	Locais
</h1>
<div id="mapG" style="height:300px; width:100%;"></div>
<script type="text/javascript">
	map = new createGoogleMaps($("mapG"));
	
	var currentlocation;
	
	function setLocationCenter(lat, lng) {
		map.setCenter(lat, lng);
		map.getMap().setZoom(13);
		currentlocation	= new google.maps.LatLng(lat, lng);
	}
	
</script>
<table id="tableresults" class="tableclass">
	<tr class="rowHeader">
		<th>ID</th>
		<th>Nome</th>
		<th>Lotação</th>
		<th>Localização</th>
		<th></th>
		<th></th>
	</tr>
<?php	
		$locais = localGetByFiltro(null, array('X'));
		$alt = true;
		while ($row = mysql_fetch_array($locais)) {
			$alt = !$alt;
?>		
		<tr class="<?= $alt ? "rowalternative" : "" ?>">
			<td><?= $row["id_local"] ?></td>
			<td title="<?= $row["descricao"] ?>"><?= $row["nome"] ?></td>
			<td><?= $row["num_lugares"] ?></td>
			<td><?= $row['latitude'] . "/" . $row['longitude'] ?></td>
			<td style="text-align:center; width:35px;"> 
				<form action="edit.php" method="post">
					<input type="hidden" name="id_local" value="<?= $row['id_local'] ?>" />
					<input type="image" alt="Edit" src="/pw606/img/view.png" title="Ver informação" onsubmit="submit-form();" />
				</form>
			</td>
			<td style="text-align:center; width:20px; padding-right:8px;">
				<img style="cursor:pointer;" src="/pw606/img/earth_view.png" onclick="setLocationCenter(<?= $row['latitude'] ?>,<?= $row['longitude'] ?>);">
				<script type="text/javascript">
					map.addPoint(<?= $row['latitude'] ?>,<?= $row['longitude'] ?>,"");
				</script>
			</td>
		</tr>
<?php
		}
?>
</table>
<div id="pageNavPosition"></div>
<script type="text/javascript">
        var pager = new Pager('tableresults', <?= $lines_per_table ?>); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);
		
		var imageA = new google.maps.MarkerImage('http://maps.gstatic.com/mapfiles/icon_greenA.png');
		var imageB = new google.maps.MarkerImage('http://maps.gstatic.com/mapfiles/icon_greenB.png');

		google.maps.event.addListener(map.getMap(), 'click', function(event) {
			map.addMarker(event.latLng.lat(), event.latLng.lng(), imageA);
			calcRoute(currentlocation, event.latLng);
		});
		
		function calcRoute(origin, destination) {
			
			var selectedMode = 'DRIVING';
			var request = {
				origin: origin,
				destination: destination,
				travelMode: google.maps.TravelMode[selectedMode]
			};
			map.directionsService.route(request,
				function(result, status) {
					if (status == google.maps.DirectionsStatus.OK) {
						map.directionsDisplay.setDirections(result);
					}
				}
			);
		}
</script>
<?php
	include_once rootPath('includes/sijo/master_footer.php', 1);
?>