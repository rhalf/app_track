var app = angular.module('app');


app.controller('panelMapController', [ "$scope", "leafletData", "leafletBoundsHelpers", function($scope, leafletData, leafletBoundsHelpers) {
    
    var maxbounds = leafletBoundsHelpers.createBoundsFromArray([
                [26.311728, 52.665710],
                [24.365706, 49.985046]
    ]);

    angular.extend($scope, {
        qatar: {
            lat: 25.3000,
            lng: 51.5167,
            zoom: 13
        },
        maxbounds: maxbounds,
        defaults: {
            //tileLayer: "http://{s}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png",
            tileLayer: "http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            minZoom: 10,
            zoomControlPosition: 'topright',
            tileLayerOptions: {
                opacity: 0.9,
                detectRetina: true,
                reuseTiles: true,
            }
            //scrollWheelZoom: false
        }
    });
}]);