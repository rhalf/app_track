/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for unitsController. 
                            Used for managing units.
*/
var app = angular.module('app');


app.controller('unitsController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,


    authFactory,
    flagFactory,
    uiFactory,
    exportFactory,

   
    Company,
    Unit,
    Sim

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();
        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function () {
        $scope.units = Unit.getByCompany({ company: $scope.authCompany.id });
    };

    $scope.select = function (unit) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/unit_update.html',
            controller: 'unitUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                unit: unit,
                parent: $scope
            }
        });
    };

    $scope.delete = function (unit) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/unit_delete.html',
            controller: 'unitDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                unit: unit,
                parent: $scope
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/unit_insert.html',
            controller: 'unitInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    };

    $scope.credential = function (unit) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/user_update_credential.html',
            controller: 'userUpdateCredentialController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: unit
            }
        });
    };

    $scope.download = function () {
        exportFactory.unitsToCsv($scope.units, $scope.auth.getCompany());
    };

    $scope.init();
});

