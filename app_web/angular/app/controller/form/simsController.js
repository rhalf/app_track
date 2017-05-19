/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for simsController. 
                            Used for managing sims.
*/
var app = angular.module('app');


app.controller('simsController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,

    authFactory,
    flagFactory,
    uiFactory,
    exportFactory,

    Company,
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
        $scope.sims = Sim.getByCompany({ company: $scope.authCompany.id });
    };

    $scope.select = function (sim) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/sim_update.html',
            controller: 'simUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                sim: sim,
                parent: $scope
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/sim_insert.html',
            controller: 'simInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    };

    $scope.delete = function (sim) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/sim_delete.html',
            controller: 'simDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                sim: sim,
                parent: $scope
            }
        });
    };

    $scope.download = function () {
        exportFactory.simsToCsv($scope.sims, $scope.auth.getCompany());
    };
    $scope.init();
});

