/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for vehicleDeleteController. 
                            Used for deleting vehicle.
*/
var app = angular.module('app');


app.controller('vehicleDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,



    authFactory,
    fleetFactory,
    flagFactory,
    uiFactory,

    Vehicle,

    vehicle,
    parent

    ) {

    $scope.init = function () {
        $scope.fleet = fleetFactory;
        $scope.ui = uiFactory;
        $scope.authUser = authFactory.getUser();

        $scope.vehicle = vehicle;
    }

    $scope.delete = function () {
        $scope.ui.isLoading = true;

        Vehicle.delete({ id: $scope.vehicle.id },
             function (result) {
                 $scope.fleet.loadVehicles(function () {
                     parent.load();
                 });
                 $scope.cancel();
                 $scope.ui.isLoading = false;
                 var alert = { type: 'success', message: result.message };
                 $scope.ui.alert.show(alert);
             },
            function (result) {
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

