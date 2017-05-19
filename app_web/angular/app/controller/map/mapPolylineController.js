var app = angular.module('app');


app.controller('mapPolylineController', function (
    $scope,
    $filter,
    $timeout,
    $location,
     $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,

    leafletFactory,
    leafletDataFactory,

    coordinates

    ) {

    $scope.init = function () {


        //var openCycle = new L.tileLayer(leafletDataFactory.mapLayer.openCycle);
        var openStreet = new L.tileLayer(leafletDataFactory.mapLayer.openStreet);

        $scope.minimap = new L.map('minimap', {
            center: leafletFactory.center,
            zoom: leafletFactory.zoom,
            layers: [
                //openCycle,
                openStreet
            ]
        });
        L.control.layers(mapsLayers).addTo($scope.minimap);

        //==========================================================================
        // Initialise the FeatureGroup to store editable layers
        var drawnItems = new L.FeatureGroup();
        $scope.minimap.addLayer(drawnItems);

        // Initialise the draw control and pass it the FeatureGroup of editable layers
        var drawControl = new L.Control.Draw({
            draw: {
                polygon: false,
                rectangle: false,
                circle: false,
                marker: false
            },
            edit: {
                featureGroup: drawnItems
            }
        });
        $scope.minimap.addControl(drawControl);
        //==========================================================================

        var mapsLayers = {
            //"openCycleMap": openCycle,
            "openStreetMap": openStreet
        };

        $scope.minimap.setView(leafletFactory.center, leafletFactory.zoomMinimap);


        //Load polyline if available
        var polyline = null;

        if (coordinates) {
            if (coordinates.length > 0) {
                $scope.coordinates = [];

                angular.forEach(coordinates, function (coordinate, index) {
                    $scope.coordinates.push([coordinate.latitude, coordinate.longitude]);
                });
                polyline = new L.Polyline($scope.coordinates).addTo(drawnItems);

                $scope.minimap.fitBounds(polyline.getBounds());
            }
        }

        //Event Function
        $scope.minimap.on('draw:created', function (e) {
            var type = e.layerType,
                layer = e.layer;
            if (type === 'marker') {
                // Do marker specific actions
            }
            // Do whatever else you need to. (save to db, add to map etc)

            drawnItems.clearLayers();
            $scope.set(drawnItems, layer);
        });
        $scope.minimap.on('draw:edited', function (e) {
            var type = e.layerType,
                layers = e.layers;
            layers.eachLayer(function (layer) {
                //do whatever you want, most likely save back to db
                $scope.set(drawnItems, layer);
            });
        });
        $scope.minimap.on('draw:deleted', function (e) {
            drawnItems.clearLayers();
        });

    };

    $scope.set = function (layergroup, layer) {

        var latLngs = layer.getLatLngs();
        coordinates = [];

        angular.forEach(latLngs, function (coordinate, index) {
            coordinates.push({ "latitude": coordinate.lat, "longitude": coordinate.lng });
        });


        var polyline = new L.Polyline(layer.getLatLngs());
        layergroup.addLayer(polyline);
    };

    $scope.cancel = function () {
        $uibModalInstance.close(coordinates);
    };

    $timeout(function () {
        $scope.init();
    }, 250);
});

