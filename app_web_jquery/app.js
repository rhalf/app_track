// var map = {};
// var layout = {};


// function loadMap(id) {
// 	var map = L.map(id);	
// 	//var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
// 	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
// 	//osmUrl = "http://tile.iosb.fraunhofer.de/tiles/osmde/${z}/${x}/${y}.png";
// 	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
// 	var osm = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 18, attribution: osmAttrib});		
// 	// start the map in Qatar
// 	map.setView(new L.LatLng(25.3000,  51.5167),  13);

// 	map.addLayer(osm);

// 	return map;
// } 

// $.when(

// 	$.get('app/view/directive/layout.html'),
// 	$.get('app/view/directive/menu.html')

// 	).then(function(layout, menu, object) {
// 		$('body').append(layout[0]);
// 		$('body .ui-layout .ui-layout-north').append(menu[0]);

// 		main();
// 	});



// 	function main() {

// 		map = loadMap('map');

// 		layout = $('.ui-layout').layout({ 
// 			applyDemoStyles: true,
// 			showDebugMessages: true,
// 			onopen  : function() {
// 				map.invalidateSize();
// 			},
// 			onclose  : function() {
// 				map.invalidateSize();
// 			},
// 			onshow  : function() {
// 				map.invalidateSize();
// 			},
// 			onhide  : function() {
// 				map.invalidateSize();
// 			},
// 			onresize  : function() {
// 				map.invalidateSize();
// 				return true;
// 			}
// 		});
// 	}

