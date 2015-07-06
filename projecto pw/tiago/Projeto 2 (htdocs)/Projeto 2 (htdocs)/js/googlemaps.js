
function createGoogleMaps(mapCanvas)
{
	this.createOptions = function(zoom, center, mapType) {
		return {
			zoom: zoom,
			center: center,
			mapTypeId: mapType
		};
	}

	this.createRendererOptions = function() {
		return {
			draggable: true
		};
	}
	
	this.directionsDisplay = new google.maps.DirectionsRenderer(this.createRendererOptions);
	this.directionsService = new google.maps.DirectionsService();
	this.center = new google.maps.LatLng(51.50190410761811, -0.1318359375);
	this.options = this.createOptions(13, this.center, google.maps.MapTypeId.ROADMAP);
	this.map = new google.maps.Map(mapCanvas, this.options);
	
	this.directionsDisplay.setMap(this.map);
	//this.directionsDisplay.setPanel(directionPanel);
	
	this.setCenter = function(lat, lon) {
		this.map.setCenter(new google.maps.LatLng(lat, lon));
	}
	
	this.getDirectionsService = function() {
		return this.directionsService;
	}
	
	this.getMap = function() {
		return this.map;
	}
	
	this.addPoint = function(lat, lon, title) {
		var pos = new google.maps.LatLng(lat, lon);
		new google.maps.Marker({
			position: pos,
			map: this.map,
			title: title
		});
		return pos;
	}
	
	this.addMarker = function(lat, lon, iconi) {
		var pos = new google.maps.LatLng(lat, lon);
		new google.maps.Marker({
			position: pos,
			icon: iconi,
			map: this.map
		});
		return pos;
	}

}