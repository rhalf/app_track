/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for vehiclesController. 
                            Used for managing vehicles.
*/
var app = angular.module('app');


app.controller('vehiclesController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,


    authFactory,
    flagFactory,
    uiFactory,
    exportFactory,

    Company,
    Vehicle,
    Unit,
    Driver

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.auth = authFactory;
        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function () {
        $scope.vehicles = Vehicle.getByCompany({ company: $scope.auth.getCompany().id });
    };

    $scope.select = function (vehicle) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/vehicle_update.html',
            controller: 'vehicleUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                vehicle: vehicle,
                parent: $scope
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/vehicle_insert.html',
            controller: 'vehicleInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    };

    $scope.delete = function (vehicle) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/vehicle_delete.html',
            controller: 'vehicleDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                vehicle: vehicle,
                parent: $scope
            }
        });
    };

    $scope.download = function () {
        exportFactory.vehiclesToCsv($scope.vehicles, $scope.auth.getCompany());
    };

    $scope.init();
});

