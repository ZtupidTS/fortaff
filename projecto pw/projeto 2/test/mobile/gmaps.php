<?php include 'includes/cabecalho.php';?>
	
	<div data-role="page" class="page-map"> 
		<div data-role="header">
			<h1>Google Maps</h1>
		</div> 
		<div data-role="content"> 
			<div id="map-canvas"></div> 
			<script type="text/javascript" language="javascript" src="../visitante/js/arraypontos.js"></script>
			<script>
			var map;
			var i = 1;
			var b = 0;
			var partida;
			var chegada;
			$('.page-map').live("pagecreate", function() 
			{
				var latlng = new google.maps.LatLng(51.50190410761811,-0.1318359375);
				var myOptions = {
				zoom: 14,
				center: latlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				map = new google.maps.Map(document.getElementById("map-canvas"),myOptions);
				
				for(var z=0;z<pontos.length;z++)
				{
					var pos = new google.maps.LatLng(pontos[z]['lat'],pontos[z]['lng']);
					var myMarker = new google.maps.Marker(
					{
						position: pos,
						map: map,
						title: pontos[z]['title'],
					})	
				}
				var imageA = new google.maps.MarkerImage('http://maps.gstatic.com/mapfiles/icon_greenA.png');
				var imageB = new google.maps.MarkerImage('http://maps.gstatic.com/mapfiles/icon_greenB.png');
				$(map, 'click', function(event) 
				{
					if(b == 0)
					{
						b++;
						placeMarker(event.latLng,imageA);	
					}else{
						placeMarker(event.latLng,imageB);
						b++;
					}		
				});
			});
			
			function placeMarker(location,iconi) 
			{
				var marker = new google.maps.Marker({
					position: location,
					icon: iconi,
					map: map
					
				});
				//document.getElementById('map'+i).innerHTML = ''+location;
				if(i == 1) partida = location;
				if(i == 2)
				{
					chegada = location;
					calcRoute();
				}
				i++;
				map.setCenter(location);
			}
			function calcRoute() 
			{
				var selectedMode = $("mode").value;
				var request = 
				{
					origin:partida,
					destination:chegada,
					travelMode: google.maps.TravelMode[selectedMode]
				};
				directionsService.route(request, function(result, status) 
				{
					if (status == google.maps.DirectionsStatus.OK) 
					{
						//directionsDisplay.setDirections(result);
						//computeTotalDistance(result);
						//computeTotalTempo(result);
					}	
				});
			}
			</script>

<?php include 'includes/rodape.php';?>