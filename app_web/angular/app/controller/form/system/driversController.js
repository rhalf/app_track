var app = angular.module('app');


app.controller('driversController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    //$uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Company,
    Driver

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();
        $scope.ui = uiFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.companies = Company.query();
        $scope.drivers = Driver.query();
    };

    $scope.select = function (driver) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/driver_update.html',
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
            templateUrl: 'app/view/form/system/driver_insert.html',
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
            templateUrl: 'app/view/form/system/driver_delete.html',
            controller: 'driverDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                driver: driver,
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

