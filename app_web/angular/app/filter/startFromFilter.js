/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Filter for startFromFilter. 
                            Used for pagination.
*/
var app = angular.module('app');

app.filter('startFromFilter', function () {
    return function (input, index) {

        if (input == null) {
            return input;
        }

        if (index < (input.length + 1)) {
            return input.slice(index);
        } else {
            return input;
        }
    };
});