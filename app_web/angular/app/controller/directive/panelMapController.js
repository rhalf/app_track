/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for panelMapController.
*/
var app = angular.module('app');


app.controller('panelMapController', function (
    $timeout,
    $scope,

    uiFactory,

    leafletFactory) {

    $scope.init = function () {

        $scope.ui = uiFactory;
        leafletFactory.init();
    };

    $scope.log = function (data) {
        console.log(data);
    };

    $scope.init();
});