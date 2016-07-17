var app = angular.module('app');


app.controller('vehiclesController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    //$uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

    Company,
    Vehicle,
    Unit,
    Driver

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();
        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function() {
        $scope.vehicles = Vehicle.query();
        $scope.companies = Company.query();
        $scope.drivers = Driver.query();
        $scope.units = Unit.query();
    };

    $scope.select = function (vehicle) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/vehicle_update.html',
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
            templateUrl: 'app/view/form/system/vehicle_insert.html',
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
            templateUrl: 'app/view/form/system/vehicle_delete.html',
            controller: 'vehicleDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                vehicle: vehicle,
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

