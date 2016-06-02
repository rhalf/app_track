var app = angular.module('app');


app.controller('driversController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory


    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getAccessToken();
        $scope.ui = uiFactory;
    };

    $scope.select = function (driver) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/driver_update.html',
            controller: 'driverUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                driver: driver
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/driver_insert.html',
            controller: 'driverInsertController',
            keyboard: true,
            size: 'md'
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
                driver: driver
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

