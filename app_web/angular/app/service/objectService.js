var app = angular.module('app');


app.service('objectService', function () {

    var object = {};
    object.poiCoordinate = {};
    object.geofenceCoordinates = [];
    object.areaCoordinates = [];
    object.routeCoordinates = [];


    return {
        setPoiCoordinate: function (poiCoordinate) {
            object.poiCoordinate = poiCoordinate;
        },
        getPoiCoordinate: function () {
            return object.poiCoordinate;
        },

        setGeofenceCoordinates: function (geofenceCoordinates) {
            object.geofenceCoordinates = geofenceCoordinates;
        },
        getGeofenceCoordinates: function () {
            return object.geofenceCoordinates;
        },


        setAreaCoordinates: function (areaCoordinates) {
            object.areaCoordinates = areaCoordinates;
        },
        getAreaCoordinates: function () {
            return object.areaCoordinates;
        }



    }

});