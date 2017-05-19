/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Factory for toolFactory. 
                            Used for managing random functions.
*/
var app = angular.module('app');


app.factory('toolFactory', function (
    $window,
    GoogleGeocode

    ) {

    var toolFactory = {};

    toolFactory.isMobile = function () {
        var size = $window.innerWidth;
        //console.log(size);
        if (size < 768) {
            return true;
        }
        return false;
    };

    toolFactory.getAddress = function (coordinate, callback) {

        if (!coordinate) {
            callback(null)
            return;
        }
        var parameter = coordinate.latitude + "," + coordinate.longitude;

        GoogleGeocode.get({ latlng: parameter },
        function (result) {
            callback(result.results[0].formatted_address);
        }, function (result) {
            callback(result.data);
        })
    };

    toolFactory.inPolygon = function (coordinates, coordinate) {

        var count = coordinates.length;

        $result = false;

        for (index1 = 0, index2 = count - 1; index1 < count; index2 = index1++) {
            if ((((coordinates[index1].latitude <= coordinate.latitude) && (coordinate.latitude < coordinates[index2].latitude))
                    || ((coordinates[index2].latitude <= coordinate.latitude) && (coordinate.latitude < coordinates[index1].latitude)))
                    && (coordinate.longitude < (coordinates[index2].longitude - coordinates[index1].longitude) * (coordinate.latitude - coordinates[index1].latitude)
                        / (coordinates[index2].latitude - coordinates[index1].latitude) + coordinates[index1].longitude)) {
                $result = !$result;
            }
        }

        return $result;
    }

    return toolFactory;

});