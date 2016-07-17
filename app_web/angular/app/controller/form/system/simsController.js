var app = angular.module('app');


app.controller('simsController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    //$uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

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
        $scope.sims = Sim.query();
        $scope.companies = Company.query();
    };

    $scope.select = function (sim) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/sim_update.html',
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
            templateUrl: 'app/view/form/system/sim_insert.html',
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
            templateUrl: 'app/view/form/system/sim_delete.html',
            controller: 'simDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                sim: sim,
                parent: $scope
            }
        });
    };


    $scope.clearCompany = function () {
        $scope.selectedCompany = "";
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

