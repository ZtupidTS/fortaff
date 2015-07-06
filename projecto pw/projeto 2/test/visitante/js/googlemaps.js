//Google Maps JavaScript API V3

var map;
var i = 1;
var b = 0;
var rendererOptions = {
  draggable: true
};
var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
var directionsService = new google.maps.DirectionsService();
var partida;
var chegada;
//var tiporota = google.maps.TravelMode["DRIVING"];

function initialize() 
{
	directionsDisplay = new google.maps.DirectionsRenderer();
	var myLatlng = new google.maps.LatLng(51.50190410761811,-0.1318359375);
	var myOptions = 
	{
		zoom: 13,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map($("map_canvas"), myOptions);
	directionsDisplay.setMap(map);
	directionsDisplay.setPanel($("directionsPanel"));
	
	
	//criação dos pontos dos evento e provas
	
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
	//elimina os markers A e B para qunaod se clica em nova rota
	
	//partida.setMap(null);
	//chegada.setMap(null);
	b = 0;
	i = 1;
	
	//criação imangens A e B
	var imageA = new google.maps.MarkerImage('http://maps.gstatic.com/mapfiles/icon_greenA.png');
	var imageB = new google.maps.MarkerImage('http://maps.gstatic.com/mapfiles/icon_greenB.png');
	google.maps.event.addListener(map, 'click', function(event) 
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
}
//meter os pontos ao clicar
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
//calcula a distancia entre os pontos
// DRIVING ou WALKING ou BICYCLING
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
			directionsDisplay.setDirections(result);
			//computeTotalDistance(result);
			//computeTotalTempo(result);
		}	
	});
}
function computeTotalDistance(result) {
  var total = 0;
  var myroute = result.routes[0];
  for (i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].distance.value;
  }
  total = total / 1000;
  $("total").innerHTML = total + " km";
}
function computeTotalTempo(result) {
  var total = 0;
  var myroute = result.routes[0];
  for (i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].duration.value;
  }
}
function setCenter() 
{
	var tipo = $("ponto").value;
	var latilonti = tipo.split(",");
	this.map.setCenter(new google.maps.LatLng(latilonti[0],latilonti[1]));
	this.map.setZoom(16);
}