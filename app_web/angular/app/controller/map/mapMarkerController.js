var app = angular.module('app');


app.controller('mapMarkerController', function (
    $scope,
    $filter,
    $timeout,
    $location,
     $uibModal,$uibModalInstance,
    $uibModalInstance,
    

    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,

    leafletFactory,
    leafletDataFactory,


    coordinate

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
                polyline: false,
                polygon: false,
                rectangle: false,
                circle: false
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

        //Load poi if available
        var poi = null;
        $scope.coordinate = coordinate;
        if ($scope.coordinate) {
            if ($scope.coordinate.latitude && $scope.coordinate.longitude) {
                poi = new L.marker(
                    new L.latLng($scope.coordinate.latitude, $scope.coordinate.longitude), {}).addTo(drawnItems);
                $scope.minimap.setView(poi.getLatLng(), 15);
            } else {
                $scope.coordinate = {};
            }
        } else {
            $scope.coordinate = {};
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
            $scope.coordinate.latitude = null;
            $scope.coordinate.longitude = null;
            drawnItems.clearLayers();
        });

    };

    $scope.set = function (layergroup, layer) {
        var coordinate = layer.getLatLng();

        $scope.coordinate.latitude = coordinate.lat;
        $scope.coordinate.longitude = coordinate.lng;

        layergroup.addLayer(layer);
    };

    $scope.cancel = function () {
        $uibModalInstance.close($scope.coordinate);
    };


    $timeout(function () {
        $scope.init();
    }, 250);
});

