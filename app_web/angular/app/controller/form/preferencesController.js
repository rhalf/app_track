/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for preferencesController. 
                            Used for managing company related components.
*/
var app = angular.module('app');


app.controller('preferencesController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

    exportFactory,

    Company,
    company

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.auth = authFactory;


        $scope.auth.setCompany(company);
        $scope.ui = uiFactory;

        $scope.active = 0;
        $scope.load();
    };

    $scope.load = function () {
        $scope.path = "app/view/form/users.html";
    };
    $scope.showUsers = function () {
        $scope.path = "app/view/form/users.html";
    };
    $scope.showDrivers = function () {
        $scope.path = "app/view/form/drivers.html";
    };
    $scope.showUnits = function () {
        $scope.path = "app/view/form/units.html";
    };
    $scope.showVehicles = function () {
        $scope.path = "app/view/form/vehicles.html";
    };
    $scope.showSims = function () {
        $scope.path = "app/view/form/sims.html";
    };
    $scope.showCollections = function () {
        $scope.path = "app/view/form/collections.html";
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };


    $scope.init();
});

