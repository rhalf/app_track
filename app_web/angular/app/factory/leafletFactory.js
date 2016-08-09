var app = angular.module('app');


app.factory('leafletFactory', function (
    $compile,
    $timeout
    ) {


    var leafletFactory = {};

    leafletFactory.vehicles = [];

    leafletFactory.vehiclesLayer = new L.markerClusterGroup();
    leafletFactory.poisLayer = new L.LayerGroup();
    leafletFactory.geofencesLayer = new L.LayerGroup();
    leafletFactory.routesLayer = new L.LayerGroup();
    leafletFactory.areaLayer = new L.LayerGroup();

    leafletFactory.center = [25.3000, 51.5167];
    leafletFactory.zoom = 10;
    leafletFactory.map = null;

    //Initialized map
    leafletFactory.init = function () {
        // load a tile layer
        var openCycleMap = L.tileLayer("http://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png", {});
        var openStreetMap = L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {});


        // initialize the map
        this.map = L.map('map', {
            center: this.center,
            zoom: this.zoom,
            layers: [
                openCycleMap,
                openStreetMap,

                this.vehiclesLayer,
                this.poisLayer,
                this.geofencesLayer,
                this.routesLayer,
                this.areaLayer,
            ]
        });

        var mapsLayers = {
            "openCycleMap": openCycleMap,
            "openStreetMap": openStreetMap
        };

        var overlayMaps = {
            "vehiclesLayer": this.vehiclesLayer,
            "poisLayer": this.poisLayer,
            "geofencesLayer": this.geofencesLayer,
            "routesLayer": this.routesLayer,
            "areaLayer": this.areaLayer

        };

        L.control.layers(mapsLayers, overlayMaps).addTo(this.map);

        this.map.setView(this.center, this.zoom);

        $timeout(function () {
            leafletFactory.map.invalidateSize();
        }, 500);
    };
    leafletFactory.setVehicle = function (vehicle) {
        object = this.getVehicleObject(vehicle);
        if (object == null) {
            this.addVehicles(vehicle);
        } else {
            this.updateVehicles(vehicle);
        }
    };
    //Vehicles
    leafletFactory.updateVehicles = function (vehicle) {
        object = this.getVehicleObject(vehicle);
      
        var icon = this.createIcon(vehicle);
        var popup = this.createPopup(vehicle);
        var coordinate = new L.latLng(vehicle.Unit.UnitData.Coordinate.Latitude, vehicle.Unit.UnitData.Coordinate.Longitude);

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

        var icon = this.createIcon(vehicle);
        var popup = this.createPopup(vehicle);
        var coordinate = new L.latLng(vehicle.Unit.UnitData.Coordinate.Latitude, vehicle.Unit.UnitData.Coordinate.Longitude);

        if (!icon || !popup) {
            return;
        }

        var marker = new L.marker(coordinate, {
            rotationAngle: vehicle.Unit.UnitData.Heading,
            icon: icon,
            vehicle: vehicle.Id
        });

        marker.bindPopup(popup, {});

        this.vehiclesLayer.addLayer(marker);
        this.vehicles[vehicle.Id] = marker;

        console.log("vehicle added to the layer!");
    };
    //Icon
    leafletFactory.createIcon = function (vehicle) {
        var iconUrl = null;

        //Validation
        if (!vehicle || !vehicle.Unit || !vehicle.Unit.UnitData) {
            return null;
        }

        //Running
        if (vehicle.Unit.UnitData.Speed > 0 && vehicle.Unit.UnitData.Di[0] == 1) {
            iconUrl = 'img/markers/marker_triangle_50_blue.gif';
        }
            //Idling
        else if (vehicle.Unit.UnitData.Speed == 0 && vehicle.Unit.UnitData.Di[0] == 1) {
            iconUrl = 'img/markers/marker_triangle_50_orange.gif';
        }
        else if (vehicle.Unit.UnitData.Speed == 0 && vehicle.Unit.UnitData.Di[0] == 0) {
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
    leafletFactory.createPopup = function (vehicle) {

        //Validation
        if (!vehicle || !vehicle.Unit || !vehicle.Unit.UnitData) {
            return null;
        }

        var popup =
          "<h4>" + vehicle.Name + "</h4>" +
          "ServerTime : " + vehicle.Unit.UnitData.DtServer + "<br />" +
          "DeviceTime : " + vehicle.Unit.UnitData.DtDevice + "<br />" +

          "Speed : " + vehicle.Unit.UnitData.Speed + " km/s<br />" +
          "Heading : " + vehicle.Unit.UnitData.Heading + "<br />" +
          "Gps Satellite : " + vehicle.Unit.UnitData.GpsSatellite + "<br />" +
          "RunTime : " + vehicle.Unit.UnitData.Time + " s<br />" +
          "Odometer : " + vehicle.Unit.UnitData.Odometer + " m<br />";

        return popup;
    };
    leafletFactory.getVehicleObject = function (vehicle) {
        var instance = this.vehicles[vehicle.Id];
        if (instance) {
            return instance;
        } else {
            return null;
        }
    };

    return leafletFactory;
});