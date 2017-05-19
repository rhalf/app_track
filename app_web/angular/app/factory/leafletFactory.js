/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Factory for leafletFactory. 
                            Used for managing leaflet stuffs.
*/
var app = angular.module('app');


app.factory('leafletFactory', function (

    $uibModal,

    $compile,
    $timeout,
    $filter,

    authFactory,
    leafletDataFactory,
    validationFactory,
    toolFactory,

    Poi,
    Geofence,
    Area,
    Route
    ) {

    var user = null;
    var company = null;

    var leafletFactory = {};


    leafletFactory.vehicles = [];
    leafletFactory.pois = [];
    leafletFactory.areas = [];
    leafletFactory.geofences = [];
    leafletFactory.routes = [];


    leafletFactory.vehiclesLayer = new L.markerClusterGroup();
    //leafletFactory.vehiclesLayer = new L.layerGroup();

    leafletFactory.poisLayer = new L.layerGroup();
    leafletFactory.geofencesLayer = new L.layerGroup();
    leafletFactory.routesLayer = new L.layerGroup();
    leafletFactory.areasLayer = new L.layerGroup();

    leafletFactory.center = [25.3000, 51.5167];

    leafletFactory.zoom = 12;
    leafletFactory.zoomMinimap = 14;

    leafletFactory.minZoom = 9;
    leafletFactory.maxZoom = 22;

    leafletFactory.maxBound = [
       [26.641168, 49.732361],
       [23.118733, 52.819519]
    ];




    leafletFactory.map = null;

    leafletFactory.init = function () {
        $timeout(function () {
            leafletFactory.initMap();
        }, 500);
        $timeout(function () {
            leafletFactory.refresh();
        }, 1000);
    };
    //Initialized map
    leafletFactory.initMap = function () {
        //var openCycle = new L.tileLayer(leafletDataFactory.mapLayer.openCycle);
        var openStreet = new L.tileLayer(leafletDataFactory.mapLayer.openStreet)

        // initialize the map
        leafletFactory.map = new L.map('map', {
            center: leafletFactory.center,
            maxBounds: leafletFactory.maxBound,

            zoom: leafletFactory.zoom,
            minZoom: leafletFactory.minZoom,
            maxZoom: leafletFactory.maxZoom,

            layers: [
                //openCycle,
                openStreet,

                leafletFactory.vehiclesLayer,
                leafletFactory.poisLayer,
                leafletFactory.geofencesLayer,
                leafletFactory.routesLayer,
                leafletFactory.areasLayer,
            ]
        });

        var mapsLayers = {
            //"OpenCycleMap": openCycle,
            "OpenStreetMap": openStreet
        };

        var overlayMaps = {
            "Vehicles": leafletFactory.vehiclesLayer,
            "Pois": leafletFactory.poisLayer,
            "Geofences": leafletFactory.geofencesLayer,
            "Routes": leafletFactory.routesLayer,
            "Areas": leafletFactory.areasLayer

        };

        L.control.layers(mapsLayers, overlayMaps).addTo(leafletFactory.map);

        leafletFactory.map.setView(leafletFactory.center, leafletFactory.zoom);

        leafletFactory.load();
    };

    leafletFactory.load = function (callback) {
        leafletFactory.vehicles = [];
        leafletFactory.pois = [];
        leafletFactory.areas = [];
        leafletFactory.geofences = [];
        leafletFactory.routes = [];

        user = authFactory.getUser();
        company = authFactory.getCompany();

        leafletFactory.vehiclesLayer.clearLayers();
        leafletFactory.loadPoi();
        leafletFactory.loadGeofence();
        leafletFactory.loadArea();
        leafletFactory.loadRoute();

        if (typeof (callback) == 'function') {
            callback();
        }
    };

    leafletFactory.refresh = function () {
        leafletFactory.map.invalidateSize();
    };
    //poi
    leafletFactory.loadPoi = function () {

        leafletFactory.poisLayer.clearLayers();

        Poi.getByCompany(
        { company: company.id },
        function (result) {
            leafletFactory.pois = result;
            angular.forEach(leafletFactory.pois, function (poi, index) {
                if (poi.isVisible) {
                    leafletFactory.createPoi(poi);
                }
            });
        });
    };
    leafletFactory.createPoi = function (poi) {

        var icon = new L.icon({
            iconUrl: leafletDataFactory.icons.pois[0],
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, 0]
        });

        var coordinate = new L.latLng(poi.coordinate.latitude, poi.coordinate.longitude);

        var marker = new L.marker(coordinate, {
            icon: icon,
            poi: poi.id,
            riseOnHover: true

        });

        marker.bindTooltip(poi.name);

        marker.bindPopup(leafletFactory.createPopupForPoi(poi));

        leafletFactory.poisLayer.addLayer(marker);
    };
    leafletFactory.createPopupForPoi = function (poi) {

        //Validation
        if (!poi || !poi.coordinate) {
            return null;
        }

        var popup =
          "<h4>" + poi.name + "</h4>" + poi.desc + "<br />";

        return popup;
    };
    //geofence
    leafletFactory.loadGeofence = function () {

        leafletFactory.geofencesLayer.clearLayers();

        Geofence.getByCompany(
        { company: company.id },
        function (result) {
            leafletFactory.geofences = result;

            angular.forEach(leafletFactory.geofences,
                function (geofence, index) {
                    if (geofence.isVisible) {
                        leafletFactory.createGeofence(geofence);
                    }
                });
        });
    };
    leafletFactory.createGeofence = function (geofence) {

        var coordinates = [];
        angular.forEach(geofence.coordinates, function (coordinate, index) {
            //console.log(coordinate);
            coordinates.push([coordinate.latitude, coordinate.longitude]);
        });

        var polygon = new L.polygon(coordinates);

        polygon.bindPopup(leafletFactory.createPopupForGeofence(geofence));
        //polygon.bindTooltip(geofence.name, { noHide: true, direction: 'auto', offset: [5, -15] });


        leafletFactory.geofencesLayer.addLayer(polygon);
    };
    leafletFactory.createPopupForGeofence = function (geofence) {

        //Validation
        if (!geofence || !geofence.coordinates) {
            return null;
        }

        var popup =
          "<h4>" + geofence.name + "</h4>" +
          "<strong>Light Vehicle</strong><br />" +
          "Speed Min : " + geofence.speedMinL + "<br />" +
          "Speed Max : " + geofence.speedMaxL + "<br />" +
          "<br />" +
          "<strong>Heavy Vehicle</strong><br />" +
          "Speed Min : " + geofence.speedMaxH + "<br />" +
          "Speed Max : " + geofence.speedMaxH + "<br />";

        return popup;
    };
    //route
    leafletFactory.loadRoute = function () {

        leafletFactory.routesLayer.clearLayers();

        Route.getByCompany(
        { company: company.id },
        function (result) {
            leafletFactory.routes = result;
            angular.forEach(leafletFactory.routes, function (route, index) {
                if (route.isVisible) {
                    leafletFactory.createRoute(route);
                }
            });
        });
    };
    leafletFactory.createRoute = function (route) {

        var coordinates = [];
        angular.forEach(route.coordinates, function (coordinate, index) {
            //console.log(coordinate);
            coordinates.push([coordinate.latitude, coordinate.longitude]);
        });

        var polyline = new L.polyline(coordinates, { color: '#00FF88' });

        polyline.bindPopup(leafletFactory.createPopupForRoute(route));
        //polyline.bindTooltip(route.name, { noHide: true, direction: 'auto', offset: [5, -15] });


        leafletFactory.routesLayer.addLayer(polyline);
    };
    leafletFactory.createPopupForRoute = function (route) {

        //Validation
        if (!route || !route.coordinates) {
            return null;
        }

        var popup =
          "<h4>" + route.name + "</h4>" +
          "<strong>Light Vehicle</strong><br />" +
          "Speed Min : " + route.speedMinL + "<br />" +
          "Speed Max : " + route.speedMaxL + "<br />" +
          "<br />" +
          "<strong>Heavy Vehicle</strong><br />" +
          "Speed Min : " + route.speedMaxH + "<br />" +
          "Speed Max : " + route.speedMaxH + "<br />";

        return popup;
    };
    //area
    leafletFactory.loadArea = function () {

        leafletFactory.areasLayer.clearLayers();

        Area.query(
         function (result) {
             leafletFactory.areas = result;
             angular.forEach(leafletFactory.areas, function (area, index) {
                 if (area.isVisible) {
                     leafletFactory.createArea(area);
                 }
             });
         });
    };
    leafletFactory.createArea = function (area) {


        var coordinates = [];
        angular.forEach(area.coordinates, function (coordinate, index) {
            //console.log(coordinate);
            coordinates.push([coordinate.latitude, coordinate.longitude]);
        });


        var polygon = new L.polygon(coordinates, { color: 'green' });

        polygon.bindPopup(leafletFactory.createPopupForArea(area));
        //polygon.bindTooltip(area.name, { noHide: true, direction: 'auto', offset: [5, -15] });


        leafletFactory.areasLayer.addLayer(polygon);
    };
    leafletFactory.createPopupForArea = function (area) {

        //Validation
        if (!area || !area.coordinates) {
            return null;
        }

        var popup =
          "<h4>" + area.name + "</h4>" +
          "<strong>Light Vehicle</strong><br />" +
          "Speed Min : " + area.speedMinL + "<br />" +
          "Speed Max : " + area.speedMaxL + "<br />" +
          "<br />" +
          "<strong>Heavy Vehicle</strong><br />" +
          "Speed Min : " + area.speedMaxH + "<br />" +
          "Speed Max : " + area.speedMaxH + "<br />";

        return popup;
    };
    //Icon
    leafletFactory.createVehicleIcon = function (vehicle, unitData) {

        var vehicleIconUrl = null;
        var alertIconUrl = null;

        //Vehicle icon

        //powercut
        //if (unitData.io.epc == 1) {
        //    vehicleIconUrl = 'img/markers/marker_64_yellow.png';
        //}
        //overspeeding
        if (unitData.io.speed >= vehicle.speedMax) {
            vehicleIconUrl = 'img/markers/marker_64_red.png';
        }
            //running
        else if (unitData.io.speed > 0 && unitData.io.acc == 1) {
            vehicleIconUrl = 'img/markers/marker_64_blue.png';
        }
            //idling
        else if (unitData.io.speed == 0 && unitData.io.acc == 1) {
            vehicleIconUrl = 'img/markers/marker_64_orange.png';
        }
            //halt
        else if (unitData.io.speed == 0 && unitData.io.acc == 0) {
            vehicleIconUrl = 'img/markers/marker_64_gray.png';
        }
            //tow
        else if (unitData.io.speed > 0 && unitData.io.acc == 0) {
            vehicleIconUrl = 'img/markers/marker_64_yellow.png';
        }

        //Alert icon
        //late data
        var dtServer = new Date(unitData.header.dtServer);
        var dtClient = new Date(unitData.header.dtClient);

        var resultA = dtServer.getTime() - dtClient.getTime();
        var resultB = Date.now() - dtServer.getTime();

        //console.log(resultB);

        if (resultA > (1000 * 60 * 3) && resultA < (1000 * 60 * 60 * 24)) {
            alertIconUrl = 'img/alerts/alert_64_clock.png';
        } else if (resultB > (1000 * 60 * 60 * 24)) {
            alertIconUrl = 'img/alerts/alert_64_wrench.png';
        } else {
            //Distance Limit
            if (vehicle.maLimit > 0) {
                var current = (unitData.io.odo / 1000) + vehicle.maInitial;
                var limit = vehicle.maLimit;
                if (current > limit) {
                    alertIconUrl = 'img/alerts/alert_64_km.png';
                }
            }

            //extertal power cut
            if (unitData.io.epc != 0) {
                alertIconUrl = 'img/alerts/alert_64_flash.png';
            }
                //no gps
            else if (unitData.gps.status == 0) {
                alertIconUrl = 'img/alerts/alert_64_satellite.png';
            }
                //low gprs
            else if (unitData.gprs.signal < 5) {
                alertIconUrl = 'img/alerts/alert_64_4g.png';
            }
                //sos
            else if (unitData.io.sos == 1) {
                alertIconUrl = 'img/alerts/alert_64_sos.png';
            }
                //battery
            else if (unitData.io.batt < 3.7) {
                alertIconUrl = 'img/alerts/alert_64_battery.png';
            }

                //vehicle expired
            else if (validationFactory.isExpired(vehicle.dtExpired)) {
                alertIconUrl = 'img/alerts/alert_64_car.png';
            }
                //unit expired
            else if (validationFactory.isExpired(vehicle.unit.dtExpired)) {
                alertIconUrl = 'img/alerts/alert_64_monitor.png';
            }

        }



        var icon = L.icon({
            iconUrl: vehicleIconUrl,
            //iconRetinaUrl: 'my-icon@2x.png',
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            shadowUrl: alertIconUrl,
            //shadowRetinaUrl: 'my-icon-shadow@2x.png',
            shadowSize: [24, 24],
            shadowAnchor: [0, 32]
        });

        return icon;
    };
    leafletFactory.createPopupForVehicle = function (vehicle) {

        var content = "<h4>" + vehicle.name + "</h4>" +
        "plateNo : " + vehicle.plate + "<br />" +
        "model : " + vehicle.model + "<br />" +
        "type : " + vehicle.type.name + "<br />" +
        "<hr />" +
        "unitImei : " + vehicle.unit.imei + "<br />" +
        "unitType : " + vehicle.unit.unitType.name + "<br />" +
        "simNumber : " + vehicle.unit.sim.number + "<br />" +
        "<hr />" +
        "acc : " + (vehicle.unit.unitData.io.acc ? "On" : "Off") + "<br />" +
        "speed : " + vehicle.unit.unitData.io.speed + "kph<br />" +
        "<hr />" +
        "address : " + vehicle.address + "<br />";


        //function (param) {
        //    $uibModal.open({
        //        animation: true,
        //        templateUrl: 'app/view/report/option.html',
        //        controller: 'optionController',
        //        keyboard: true,
        //        size: 'md',
        //        resolve: {
        //            vehicle: vehicle
        //        }
        //    });
        //    return 1;
        //}

        var popup = L.popup({
            closeButton: false
        })
      .setContent(content);



        return popup;

    };
    //Vehicles
    leafletFactory.setVehicle = function (vehicle) {

        if (!vehicle) return;
        if (!vehicle.unit) return;
        if (!vehicle.unit.unitData) return;


        var marker = leafletFactory.getVehicleMarker(vehicle);
        if (marker == null) {
            leafletFactory.addVehicles(vehicle);
        } else {
            leafletFactory.updateVehicles(vehicle);
        }
    };
    leafletFactory.updateVehicles = function (vehicle) {

        var marker = leafletFactory.getVehicleMarker(vehicle);
        if (marker == null) return;


        var icon = leafletFactory.createVehicleIcon(vehicle, vehicle.unit.unitData);
        var popup = leafletFactory.createPopupForVehicle(vehicle);
        var coordinate = new L.latLng(vehicle.unit.unitData.gps.coordinate.latitude, vehicle.unit.unitData.gps.coordinate.longitude);

        if (!icon || !popup) {
            return;
        }

  
        //if (marker.getLatLng != coordinate.getLatLng) {
        //    marker.slideTo(coordinate, {
        //        duration: 30000,
        //        keepAtCenter: false
        //    });
        //}

        marker.bindPopup(popup);
        marker.setLatLng(coordinate);
        marker.setIcon(icon);
        marker.setRotationAngle(vehicle.unit.unitData.gps.coordinate.course);

     
        console.log("vehicle updated to the layer!");
    };
    leafletFactory.removeVehicle = function (vehicle) {

        var marker = leafletFactory.getVehicleMarker(vehicle);

        if (marker == null) return;

        leafletFactory.vehiclesLayer.removeLayer(marker);
        leafletFactory.removeVehicleMarker(vehicle);
        console.log("vehicle removed from the layer!");

    };
    leafletFactory.removeVehicles = function () {
        leafletFactory.vehiclesLayer.clearLayers();
        leafletFactory.vehicles = [];
        console.log("vehicles cleared from layer!");

    };
    leafletFactory.addVehicles = function (vehicle) {

        if (!vehicle) { return; }
        if (!vehicle.unit) { return; }
        if (!vehicle.unit.unitData) { return; }

        var icon = leafletFactory.createVehicleIcon(vehicle, vehicle.unit.unitData);
        var popup = leafletFactory.createPopupForVehicle(vehicle);
        var coordinate = new L.latLng(vehicle.unit.unitData.gps.coordinate.latitude, vehicle.unit.unitData.gps.coordinate.longitude);



        if (!icon || !popup) {
            return;
        }

        var marker = new L.marker(coordinate, {
            rotationAngle: vehicle.unit.unitData.gps.coordinate.course,
            icon: icon,
            vehicle: vehicle.id,
            riseOnHover: true
        });

        marker.bindTooltip(vehicle.name);
        marker.bindPopup(popup).openPopup();


        var array = [vehicle.id, marker];
        leafletFactory.vehiclesLayer.addLayer(marker);
        leafletFactory.vehicles.push(array);

        console.log("vehicle added to the layer!");
    };
    leafletFactory.findVehicle = function (vehicle) {
        var marker = leafletFactory.getVehicleMarker(vehicle);

        if (marker == null) return;

        leafletFactory.map.setView(marker.getLatLng());
        marker.openTooltip();
    };
    leafletFactory.getVehicleMarker = function (vehicle) {
        var instance = null;
        angular.forEach(leafletFactory.vehicles, function (array, index) {
            if (array[0] == vehicle.id)
                instance = array[1];
        });
        return instance;
    };
    leafletFactory.removeVehicleMarker = function (vehicle) {
        angular.forEach(leafletFactory.vehicles,
            function (array, index) {
                if (array[0] == vehicle.id) {
                    leafletFactory.vehicles.splice(index, 1);
                    console.log(leafletFactory.vehicles);
                }
            });

    };
    leafletFactory.setGeofence = function (unitData) {
        if (!unitData) return;
        if (!unitData.gps) return;
        angular.forEach(leafletFactory.geofences,
            function (geofence, index) {
                if (toolFactory.inPolygon(geofence.coordinates, unitData.gps.coordinate)) {
                    unitData.geofence = geofence;
                };
            });

    };
    leafletFactory.setArea = function (unitData) {
        if (!unitData) return;
        if (!unitData.gps) return;
        angular.forEach(leafletFactory.areas,
            function (area, index) {
                if (toolFactory.inPolygon(area.coordinates, unitData.gps.coordinate)) {
                    unitData.area = area;
                };
            });

    };
    return leafletFactory;
});