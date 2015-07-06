//Google Maps JavaScript API V3
var directionsService = new google.maps.DirectionsService();
var fim = false;

function calcRoute() 
{
	for(var z=0;z<pontostempo.length;z++)
	{
		
		fim = false;
		var partida = new google.maps.LatLng(pontostempo[z]['partida_lat'],pontostempo[z]['partida_lng']);
		var chegada = new google.maps.LatLng(pontostempo[z]['chegada_lat'],pontostempo[z]['chegada_lng']);
		var tempo = pontostempo[z]['tempo'];
		var request = 
		{
			origin:partida,
			destination:chegada,
			travelMode: google.maps.TravelMode["DRIVING"]
		};
		directionsService.route(request, function(result, status) 
		{
			if (status == google.maps.DirectionsStatus.OK) 
			{
				var valortempo = computeTotalTempo(result);
				if(valortempo > tempo)
				{
					alert("O tempo entre as provas/eventos excede o tempo disponível que tem para se deslocar");
					fim = true;
				}
			}	
		});
		if(fim) break;
	}
}
function computeTotalTempo(result) {
  var myroute = result.routes[0];
  var total = 0;
  for (i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].duration.value;
  }
	return total;
}