		var map = L.map('mapid');	
		//var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
		var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
		//osmUrl = "http://tile.iosb.fraunhofer.de/tiles/osmde/${z}/${x}/${y}.png";
		var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
		var osm = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 18, attribution: osmAttrib});		
		// start the map in Qatar
		map.setView(new L.LatLng(25.3000,  51.5167),  13);
		map.addLayer(osm);


		$('#side-menu').load('app/template/directive/sideMenu.html');
