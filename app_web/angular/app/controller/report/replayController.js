var app = angular.module('app');


app.controller('replayController', function (
    $scope,
    $timeout,
    $interval,
    $location,
    $filter,

    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,
    toolFactory,

    leafletFactory,
    leafletDataFactory,
    exportFactory,

    Geofence,
    Area,
    Poi,

    Report,

    param

    ) {

    $scope.report = {};
    $scope.playing = {};
    $scope.playing.speed = 1;

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;

        $scope.param = param;

        $scope.marker = null;

        //$scope.openCycle = new L.tileLayer(leafletDataFactory.mapLayer.openCycle);
        $scope.openStreet = new L.tileLayer(leafletDataFactory.mapLayer.openStreet);

        $scope.routesLayer = new L.layerGroup();
        $scope.vehiclesLayer = new L.layerGroup();
        $scope.geofencesLayer = new L.layerGroup();
        $scope.poisLayer = new L.layerGroup();
        $scope.areasLayer = new L.layerGroup();

        $scope.minimap = new L.map('minimap', {
            center: leafletFactory.center,
            zoom: leafletFactory.zoom,
            layers: [
                 //$scope.openCycle,
                 $scope.openStreet,

                 $scope.routesLayer,
                 $scope.vehiclesLayer,
                 $scope.geofencesLayer,
                 $scope.areasLayer,
                 $scope.poisLayer,
            ]
        });

        var mapsLayers = {
            //"openCycleMap": $scope.openCycle,
            "openStreetMap": $scope.openStreet
        };
        var overlayMaps = {
            "routes": $scope.routesLayer,
            "vehicles": $scope.vehiclesLayer,
            "geofences": $scope.geofencesLayer,
            "areas": $scope.areasLayer,
            "pois": $scope.poisLayer
        };

        L.control.layers(mapsLayers, overlayMaps).addTo($scope.minimap);

        $scope.minimap.setView(leafletFactory.center, leafletFactory.zoomMinimap - 3);

        $scope.ui.isLoading = true;

        $scope.loadGeofences(param.vehicle.company);
        $scope.loadAreas();
        $scope.loadPois(param.vehicle.company);

        Report.generate(
            param,
            function (result) {
                $scope.report = result;
                $scope.ui.isLoading = false;
                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);

                angular.forEach($scope.report.datas, function (data, index) {
                    angular.forEach(leafletFactory.geofences, function (geofence, index) {
                        if (data.geofence == geofence.id) {
                            data.geofence = geofence;
                        }
                    });
                    angular.forEach(leafletFactory.areas, function (area, index) {
                        if (data.area == area.id) {
                            data.area = area;
                        }
                    });
                });

                $scope.loadRoute($scope.report.datas);

                $scope.slider.value = 0;
                $scope.slider.minimum = 0;
                $scope.slider.maximum = result.datas.length - 1;

            },
            function (result) {
                $scope.ui.isLoading = false;

                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });
    };

    $scope.loadGeofences = function (company) {

        $scope.geofencesLayer.clearLayers();

        var geofences = Geofence.getByCompany(company.id, function (result) {
            var coordinates = []
            angular.forEach(geofences, function (geofence, index) {

                var coordinates = [];
                angular.forEach(geofence.coordinates, function (coordinate, index) {
                    coordinates.push([coordinate.latitude, coordinate.longitude]);
                });

                var polygon = new L.polygon(coordinates);

                polygon.bindPopup(leafletFactory.createPopupForGeofence(geofence));
                //polygon.bindTooltip(geofence.name, { noHide: true, direction: 'auto', offset: [5, -15] });

                $scope.geofencesLayer.addLayer(polygon);

            });
        });
    };
    $scope.loadAreas = function () {

        $scope.areasLayer.clearLayers();

        var areas = Area.query(function (result) {
            var coordinates = []
            angular.forEach(areas, function (area, index) {

                var coordinates = [];
                angular.forEach(area.coordinates, function (coordinate, index) {
                    coordinates.push([coordinate.latitude, coordinate.longitude]);
                });

                var polygon = new L.polygon(coordinates, { color: 'green' });

                polygon.bindPopup(leafletFactory.createPopupForArea(area));

                $scope.areasLayer.addLayer(polygon);

            });
        });
    };
    $scope.loadPois = function (company) {

        $scope.poisLayer.clearLayers();

        var pois = Poi.getByCompany(company.id, function (result) {
            var coordinate = null;
            angular.forEach(pois, function (poi, index) {

                var coordinate = new L.latLng(poi.coordinate.latitude, poi.coordinate.longitude);

                var marker = new L.marker(coordinate, {
                    //icon: icon,
                    poi: poi.id,
                    riseOnHover: true

                });

                marker.bindTooltip(poi.name);

                marker.bindPopup(leafletFactory.createPopupForPoi(poi));

                $scope.poisLayer.addLayer(marker);

            });
        });
    };
    $scope.loadRoute = function (unitDatas) {

        $scope.routesLayer.clearLayers();

        var coordinates = [];

        angular.forEach(unitDatas, function (unitData, index) {
            var coordinate = unitData.gps.coordinate;
            coordinates.push([coordinate.latitude, coordinate.longitude]);
        });


        var polyline = new L.polyline(coordinates, { color: '#0000FF' });

        //polyline.bindPopup(leafletFactory.createPopupForRoute(route));
        //polyline.bindTooltip("Route").openTooltip();

        $scope.routesLayer.addLayer(polyline);
    };
    $scope.loadVehicle = function (unitData) {
        $scope.vehiclesLayer.clearLayers();

        var icon = leafletFactory.createVehicleIcon(param.vehicle, unitData);
        var coordinate = new L.latLng(unitData.gps.coordinate.latitude, unitData.gps.coordinate.longitude);

        var marker = new L.marker(coordinate, {
            rotationAngle: unitData.gps.coordinate.course,
            icon: icon,
            riseOnHover: true
        });

        $scope.vehiclesLayer.addLayer(marker);
        $scope.minimap.panTo(marker.getLatLng());
        $scope.marker = marker;
    };
    $scope.setVehicle = function (unitData) {
        if ($scope.marker == null) {
            $scope.loadVehicle(unitData);
        } else {
            $scope.updateVehicle(unitData);
        }
    };
    $scope.updateVehicle = function (unitData) {
        object = $scope.marker;

        var icon = leafletFactory.createVehicleIcon($scope.param.vehicle, unitData);
        //var popup = leafletFactory.createPopupForVehicle(vehicle);
        var coordinate = new L.latLng(unitData.gps.coordinate.latitude, unitData.gps.coordinate.longitude);

        //if (!icon || !popup) {
        //    return;
        //}

        //object.bindPopup(popup);
        object.setLatLng(coordinate);
        object.setIcon(icon);
        object.setRotationAngle(unitData.gps.coordinate.course);

        $scope.minimap.panTo(object.getLatLng());


    };
    $scope.updateUnitData = function () {
        if (!$scope.report) return;
        if (!$scope.report.datas) return;
        if ($scope.report.datas.length == 0) return;

        $scope.data = $scope.report.datas[$scope.slider.value];

        $scope.setVehicle($scope.data);
    };

    //playing
    $scope.playing.stop = function () {
        if ($scope.playing.status == 'stop') return;
        $scope.playing.status = 'stop';
        $scope.slider.value = 0;
    };
    $scope.playing.pause = function () {
        if ($scope.playing.status == 'pause') return;
        $scope.playing.status = 'pause';
    };
    $scope.playing.play = function () {
        if ($scope.playing.status == 'play') return;
        $scope.playing.status = 'play';

         $scope.playing.interval = $interval(function () {
            if ($scope.playing.status == 'play') {
                if ($scope.slider.value < $scope.slider.maximum) {
                    $scope.slider.value += 1;
                    $scope.updateUnitData();
                } else {
                    $interval.cancel($scope.playing.interval);
                    return;
                }
            } else {
                $interval.cancel($scope.playing.interval);
                return;
            }
        }, (4 - $scope.playing.speed) * 250);
    };
    $scope.speedUp = function () {
        if ($scope.playing.speed >= 4) return;
        $scope.playing.speed++;
        if ($scope.playing.status == 'play') {
            $interval.cancel($scope.playing.interval);
            $scope.playing.status = 'stop';
            $scope.playing.play();
        }
    };
    $scope.speedDown = function () {
        if ($scope.playing.speed <= 0) return;
        $scope.playing.speed--;
        if ($scope.playing.status == 'play') {
            $interval.cancel($scope.playing.interval);
            $scope.playing.status = 'stop';
            $scope.playing.play();
        }

    };
    //Others
    $scope.download = function () {

        if (!$scope.report) return;
        if (!$scope.report.datas) return;
        if ($scope.report.datas.length == 0) return;

        exportFactory.historicalToCsv($scope.report);
    };
    $scope.getAddress = function (data) {
        toolFactory.getAddress(data.gps.coordinate, function (address) {
            data.address = address;
        });
    };
    $scope.cancel = function () {
        $uibModalInstance.close();
    };
    $timeout(function () {
        $scope.init();
    }, 250);
});

