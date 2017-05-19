/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for driversController. 
                            Used for managing drivers.
*/
var app = angular.module('app');


app.controller('driversController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,


    authFactory,
    flagFactory,
    uiFactory,
    exportFactory,

    Company,
    Driver

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.auth = authFactory;
        $scope.ui = uiFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.drivers = Driver.getByCompany({ company: $scope.auth.getCompany().id });
    };

    $scope.select = function (driver) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/driver_update.html',
            controller: 'driverUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                driver: driver,
                parent: $scope
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/driver_insert.html',
            controller: 'driverInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    };

    $scope.delete = function (driver) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/driver_delete.html',
            controller: 'driverDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                driver: driver,
                parent: $scope
            }
        });
    };


    $scope.download = function () {
        exportFactory.driversToCsv($scope.drivers, $scope.auth.getCompany());
    };

    $scope.init();
});

