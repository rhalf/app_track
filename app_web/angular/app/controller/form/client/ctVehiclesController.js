var app = angular.module('app');


app.controller('ctVehiclesController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

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
            templateUrl: 'app/view/form/client/ct_vehicle_update.html',
            controller: 'ctVehicleUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                vehicle: vehicle,
                parent: $scope
            }
        });
    };

    $scope.clear = function () {
        $scope.selected = "";
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

