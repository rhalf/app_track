/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Service for objectService. 
                            Use to set and unset to variables those leaflet components.
*/
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