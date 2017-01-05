var app = angular.module('app');


app.factory('leafletFactory', function (
    $compile,
    $timeout,
    $filter,

    authFactory,
    leafletDataFactory,

    Poi,
    Geofence,
    Area,
    Route
    ) {


    var leafletFactory = {};


    leafletFactory.vehicles = [];
    leafletFactory.pois = [];
    leafletFactory.areas = [];
    leafletFactory.geofences = [];
    leafletFactory.routes = [];


    leafletFactory.vehiclesLayer = new L.markerClusterGroup();

    leafletFactory.poisLayer = new L.LayerGroup();
    leafletFactory.geofencesLayer = new L.LayerGroup();
    leafletFactory.routesLayer = new L.LayerGroup();
    leafletFactory.areasLayer = new L.LayerGroup();

    leafletFactory.center = [25.3000, 51.5167];

    leafletFactory.zoom = 12;
    leafletFactory.zoomMinimap = 14;

    leafletFactory.minZoom = 9;
    leafletFactory.maxZoom = 18;

    leafletFactory.maxBound = [
       [26.641168, 49.732361],
       [23.118733, 52.819519]
    ];

    leafletFactory.isAllowed = function () {
        if (authFactory.getUser().Privilege.Value < 5) {
            return true;
        } else {
            return false;
        }
    };



    leafletFactory.map = null;

    leafletFactory.init = function () {
        leafletFactory.initMap(function () {
            leafletFactory.loadPoi();
            leafletFactory.loadGeofence();
            leafletFactory.loadArea();
            leafletFactory.loadRoute();
        });
    };
    //Initialized map
    leafletFactory.initMap = function (callback) {
        var openCycle = new L.tileLayer(leafletDataFactory.mapLayer.openCycle);
        var openStreet = new L.tileLayer(leafletDataFactory.mapLayer.openStreet)

        // initialize the map
        leafletFactory.map = new L.map('map', {
            center: leafletFactory.center,
            maxBounds: leafletFactory.maxBound,

            zoom: leafletFactory.zoom,
            minZoom: leafletFactory.minZoom,
            maxZoom: leafletFactory.maxZoom,

            layers: [
                openCycle,
                openStreet,

                leafletFactory.vehiclesLayer,
                leafletFactory.poisLayer,
                leafletFactory.geofencesLayer,
                leafletFactory.routesLayer,
                leafletFactory.areasLayer,
            ]
        });



        var mapsLayers = {
            "OpenCycleMap": openCycle,
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


        $timeout(function () {
            leafletFactory.map.invalidateSize();
            callback();
        }, 1000);
    };
    //poi
    leafletFactory.loadPoi = function () {

        leafletFactory.poisLayer.clearLayers();

        Poi.getByCompany(
        { company: authFactory.getUser().Company.Id },
        function (result) {
            leafletFactory.pois = result;
            angular.forEach(leafletFactory.pois, function (poi, index) {
                if (poi.IsVisible) {
                    leafletFactory.createPoi(poi);
                }
            });
        });
    };
    leafletFactory.createPoi = function (poi) {

        //var icon = new L.icon({
        //    iconUrl: leafletDataFactory.icons.pois[0],
        //    iconSize: [32, 32],
        //    iconAnchor: [16, 32],
        //    popupAnchor: [0, 0]
        //});

        var coordinate = new L.latLng(poi.Coordinate.latitude, poi.Coordinate.longitude);

        var marker = new L.marker(coordinate, {
            //icon: icon,
            poi: poi.Id,
            riseOnHover: true

        });

        //marker.bindTooltip(poi.Name, { noHide: true, direction: 'auto', offset: [5, -15] });

        marker.bindPopup(leafletFactory.createPopupForPoi(poi));

        leafletFactory.poisLayer.addLayer(marker);
    };
    leafletFactory.createPopupForPoi = function (poi) {

        //Validation
        if (!poi || !poi.Coordinate) {
            return null;
        }

        var popup =
          "<h4>" + poi.Name + "</h4>" + poi.Desc + "<br />";

        return popup;
    };
    //geofence
    leafletFactory.loadGeofence = function () {

        leafletFactory.geofencesLayer.clearLayers();

        Geofence.getByCompany(
        { company: authFactory.getUser().Company.Id },
        function (result) {
            leafletFactory.geofences = result;
            angular.forEach(leafletFactory.geofences, function (geofence, index) {
                if (geofence.IsVisible) {
                    leafletFactory.createGeofence(geofence);
                }
            });
        });
    };
    leafletFactory.createGeofence = function (geofence) {

        var coordinates = [];
        angular.forEach(geofence.Coordinates, function (coordinate, index) {
            //console.log(coordinate);
            coordinates.push([coordinate.latitude, coordinate.longitude]);
        });

        var polygon = new L.polygon(coordinates);

        polygon.bindPopup(leafletFactory.createPopupForGeofence(geofence));
        //polygon.bindTooltip(geofence.Name, { noHide: true, direction: 'auto', offset: [5, -15] });


        leafletFactory.geofencesLayer.addLayer(polygon);
    };
    leafletFactory.createPopupForGeofence = function (geofence) {

        //Validation
        if (!geofence || !geofence.Coordinates) {
            return null;
        }

        var popup =
          "<h4>" + geofence.Name + "</h4>" +
          "<strong>Light Vehicle</strong><br />" +
          "Speed Min : " + geofence.SpeedMinL + "<br />" +
          "Speed Max : " + geofence.SpeedMaxL + "<br />" +
          "<br />" +
          "<strong>Heavy Vehicle</strong><br />" +
          "Speed Min : " + geofence.SpeedMaxH + "<br />" +
          "Speed Max : " + geofence.SpeedMaxH + "<br />";

        return popup;
    };
    //route
    leafletFactory.loadRoute = function () {

        leafletFactory.routesLayer.clearLayers();

        Route.getByCompany(
        { company: authFactory.getUser().Company.Id },
        function (result) {
            leafletFactory.routes = result;
            angular.forEach(leafletFactory.routes, function (route, index) {
                if (route.IsVisible) {
                    leafletFactory.createRoute(route);
                }
            });
        });
    };
    leafletFactory.createRoute = function (route) {

        var coordinates = [];
        angular.forEach(route.Coordinates, function (coordinate, index) {
            //console.log(coordinate);
            coordinates.push([coordinate.latitude, coordinate.longitude]);
        });

        var polygon = new L.polyline(coordinates, { color: '#00FF88' });

        polygon.bindPopup(leafletFactory.createPopupForRoute(route));
        //polygon.bindTooltip(route.Name, { noHide: true, direction: 'auto', offset: [5, -15] });


        leafletFactory.routesLayer.addLayer(polygon);
    };
    leafletFactory.createPopupForRoute = function (route) {

        //Validation
        if (!route || !route.Coordinates) {
            return null;
        }

        var popup =
          "<h4>" + route.Name + "</h4>" +
          "<strong>Light Vehicle</strong><br />" +
          "Speed Min : " + route.SpeedMinL + "<br />" +
          "Speed Max : " + route.SpeedMaxL + "<br />" +
          "<br />" +
          "<strong>Heavy Vehicle</strong><br />" +
          "Speed Min : " + route.SpeedMaxH + "<br />" +
          "Speed Max : " + route.SpeedMaxH + "<br />";

        return popup;
    };
    //area
    leafletFactory.loadArea = function () {

        leafletFactory.areasLayer.clearLayers();

        Area.query(
         function (result) {
             leafletFactory.areas = result;
             angular.forEach(leafletFactory.areas, function (area, index) {
                 if (area.IsVisible) {
                     leafletFactory.createArea(area);
                 }
             });
         });
    };
    leafletFactory.createArea = function (area) {


        var coordinates = [];
        angular.forEach(area.Coordinates, function (coordinate, index) {
            //console.log(coordinate);
            coordinates.push([coordinate.latitude, coordinate.longitude]);
        });


        var polygon = new L.polygon(coordinates, { color: 'green' });

        polygon.bindPopup(leafletFactory.createPopupForArea(area));
        //polygon.bindTooltip(area.Name, { noHide: true, direction: 'auto', offset: [5, -15] });


        leafletFactory.areasLayer.addLayer(polygon);
    };
    leafletFactory.createPopupForArea = function (area) {

        //Validation
        if (!area || !area.Coordinates) {
            return null;
        }

        var popup =
          "<h4>" + area.Name + "</h4>" +
          "<strong>Light Vehicle</strong><br />" +
          "Speed Min : " + area.SpeedMinL + "<br />" +
          "Speed Max : " + area.SpeedMaxL + "<br />" +
          "<br />" +
          "<strong>Heavy Vehicle</strong><br />" +
          "Speed Min : " + area.SpeedMaxH + "<br />" +
          "Speed Max : " + area.SpeedMaxH + "<br />";

        return popup;
    };
    //Vehicles
    leafletFactory.setVehicle = function (vehicle) {
        object = leafletFactory.getVehicleObject(vehicle);
        if (object == null) {
            leafletFactory.addVehicles(vehicle);
        } else {
            leafletFactory.updateVehicles(vehicle);
        }
    };
    leafletFactory.updateVehicles = function (vehicle) {
        object = leafletFactory.getVehicleObject(vehicle);

        var icon = leafletFactory.createIconForVehicle(vehicle);
        var popup = leafletFactory.createPopupForVehicle(vehicle);
        var coordinate = new L.latLng(vehicle.Unit.UnitData.gps.coordinate.latitude, vehicle.Unit.UnitData.gps.coordinate.longitude);

        if (!icon || !popup) {
            return;
        }

        object.bindPopup(popup);
        object.setLatLng(coordinate);

        console.log("vehicle updated to the layer!");
    };
    leafletFactory.removeVehicle = function (vehicle) {
        object = leafletFactory.getVehicleObject(vehicle);

        if (object) {
            leafletFactory.vehiclesLayer.removeLayer(object);
            leafletFactory.vehicles.splice(object.Id, 1);

            console.log("vehicle removed from the layer!");
        }
    };
    leafletFactory.addVehicles = function (vehicle) {

        var icon = leafletFactory.createIconForVehicle(vehicle);
        var popup = leafletFactory.createPopupForVehicle(vehicle);
        var coordinate = new L.latLng(vehicle.Unit.UnitData.gps.coordinate.latitude, vehicle.Unit.UnitData.gps.coordinate.longitude);

   

        if (!icon || !popup) {
            return;
        }

        var marker = new L.marker(coordinate, {
            rotationAngle: vehicle.Unit.UnitData.gps.coordinate.course,
            icon: icon,
            vehicle: vehicle.Id,
            riseOnHover: true
        });

        marker.bindTooltip(vehicle.Name);
        marker.bindPopup(popup).openPopup();

        leafletFactory.vehiclesLayer.addLayer(marker);
        leafletFactory.vehicles[vehicle.Id] = marker;

        console.log("vehicle added to the layer!");
    };
    //Icon
    leafletFactory.createIconForVehicle = function (vehicle) {
        var iconUrl = null;

        //Validation
        if (!vehicle || !vehicle.Unit || !vehicle.Unit.UnitData) {
            return null;
        }

        //Running
        if (vehicle.Unit.UnitData.io.speed > 0 && vehicle.Unit.UnitData.io.acc == 1) {
            iconUrl = 'img/markers/marker_triangle_50_blue.gif';
        }
            //Idling
        else if (vehicle.Unit.UnitData.io.speed == 0 && vehicle.Unit.UnitData.io.acc == 1) {
            iconUrl = 'img/markers/marker_triangle_50_orange.gif';
        }
        else if (vehicle.Unit.UnitData.io.speed == 0 && vehicle.Unit.UnitData.io.acc == 0) {
            iconUrl = 'img/markers/marker_triangle_50_gray.gif';
        } else {
            iconUrl = 'img/markers/marker_triangle_50_yellow.gif';
        }

        var icon = L.icon({
            iconUrl: iconUrl,
            //iconRetinaUrl: 'my-icon@2x.png',
            iconSize: [24, 24],
            iconAnchor: [12, 12],
            popupAnchor: [0, -12],
            //shadowUrl: 'my-icon-shadow.png',
            //shadowRetinaUrl: 'my-icon-shadow@2x.png',
            //shadowSize: [68, 95],  
            //shadowAnchor: [22, 94]
        });

        return icon;
    };
    leafletFactory.createPopupForVehicle = function (vehicle) {

        //Validation
        if (!vehicle || !vehicle.Unit || !vehicle.Unit.UnitData) {
            return null;
        }

        var popup = L.popup({
            closeButton : false
        })
        .setContent(
        "<h4>" + vehicle.Name + "</h4>" +
        "ServerTime : " + $filter('dateFilter')(vehicle.Unit.UnitData.header.dtServer) + "<br />" +
        "DeviceTime : " + $filter('dateFilter')(vehicle.Unit.UnitData.header.dtClient) + "<br />" +
        "Command : " + vehicle.Unit.UnitData.header.command + "<br />" +
        "Event : " + vehicle.Unit.UnitData.header.event + "<br />" +
        "Length : " + vehicle.Unit.UnitData.header.length + " bytes <br />" +
        "<br /><strong>GPS</strong><br />" +
        "latitude : " + vehicle.Unit.UnitData.gps.coordinate.latitude + "<br />" +
        "longitude : " + vehicle.Unit.UnitData.gps.coordinate.longitude + "<br />" +
        "Altitude : " + vehicle.Unit.UnitData.gps.coordinate.altitude + "<br />" +
        "Course : " + vehicle.Unit.UnitData.gps.coordinate.course + "<br />" +
        "Satellite: " + vehicle.Unit.UnitData.gps.satellite + "<br />" +
        "Status: " + vehicle.Unit.UnitData.gps.status + "<br />" +
        "Accuracy: " + vehicle.Unit.UnitData.gps.accuracy + "<br />" +
        "<br /><strong>GPRS</strong><br />" +
        "Signal : " + vehicle.Unit.UnitData.gprs.signal + "<br />" +
        "Status : " + vehicle.Unit.UnitData.gprs.status + "<br />" +
        "<br /><strong>IO</strong><br />" +
        "Speed : " + vehicle.Unit.UnitData.io.speed + "<br />" +
        "Runtime : " + vehicle.Unit.UnitData.io.runtime + "<br />" +
        "Odometer : " + vehicle.Unit.UnitData.io.odo + " km <br />" +
        "Ignition/Acc : " + vehicle.Unit.UnitData.io.acc + "<br />" +
        "Emergency/Sos: " + vehicle.Unit.UnitData.io.sos + "<br />" +
        "PowerCut/Epc : " + vehicle.Unit.UnitData.io.epc + "<br />" +
        "Battery/Batt : " + vehicle.Unit.UnitData.io.batt + " volts<br />" +
        "Source/Vcc : " + vehicle.Unit.UnitData.io.vcc + " volts<br />" +
        "Tow : " + vehicle.Unit.UnitData.io.tow + "<br />" +
        "Motion : " + vehicle.Unit.UnitData.io.motion + "<br />" +
        "Fuel : " + vehicle.Unit.UnitData.io.fuel + "<br />" +
        "Rpm : " + vehicle.Unit.UnitData.io.rpm + "<br />" +
        "Alarm : " + vehicle.Unit.UnitData.io.alarm + "<br />" +
        "Mode : " + vehicle.Unit.UnitData.io.mode + "<br />" +
        "Pic : " + vehicle.Unit.UnitData.io.pic + "<br />" +
        "Ibutton : " + vehicle.Unit.UnitData.io.ibutton + "<br />" +
        "Weight : " + vehicle.Unit.UnitData.io.weight + "<br />" +
        "Relay1: " + vehicle.Unit.UnitData.io.relay1 + "<br />" +
        "Relay2: " + vehicle.Unit.UnitData.io.relay2 + "<br />" +
        "Relay3: " + vehicle.Unit.UnitData.io.relay3 + "<br />" +
        "Relay4: " + vehicle.Unit.UnitData.io.relay4 + "<br />");

        return popup;

    };
    leafletFactory.getVehicleObject = function (vehicle) {
        var instance = leafletFactory.vehicles[vehicle.Id];
        if (instance) {
            return instance;
        } else {
            return null;
        }
    };



    return leafletFactory;
});