/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for panelBottomController.
*/
var app = angular.module('app');


app.controller('panelBottomController', function (
    $scope,
    $interval,
    $timeout,

    authFactory,
    flagFactory,
    uiFactory,
    fleetFactory,
    systemFactory,
    leafletFactory,
    toolFactory
    ) {

    $scope.fleet = null;


    $scope.init = function () {
        $scope.fleet = fleetFactory
        $scope.tool = toolFactory;
    };


    $scope.onClick = function (vehicle) {

        angular.forEach($scope.fleet.vehicles, function (fleetVehicle, index) {
            if (fleetVehicle.id == vehicle.id) {
                fleetVehicle.selected = true;
            } else {
                fleetVehicle.selected = false;
            }
        });

        leafletFactory.findVehicle(vehicle);
        leafletFactory.refresh();
    };
    $scope.onDoubleClick = function (vehicle) {
        $scope.tool.getAddress(vehicle.unit.unitData.gps.coordinate,
            function (address) {
                vehicle.address = address;
            });
    };

    $scope.init();
});