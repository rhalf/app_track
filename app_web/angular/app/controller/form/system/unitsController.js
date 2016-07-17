var app = angular.module('app');


app.controller('unitsController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    //$uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

   
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
        $scope.units = Unit.query();
        $scope.companies = Company.query();
        $scope.sims = Sim.query();
    };

    $scope.select = function (unit) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/unit_update.html',
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
            templateUrl: 'app/view/form/system/unit_delete.html',
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
            templateUrl: 'app/view/form/system/unit_insert.html',
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
            templateUrl: 'app/view/form/system/user_update_credential.html',
            controller: 'userUpdateCredentialController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: unit
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

