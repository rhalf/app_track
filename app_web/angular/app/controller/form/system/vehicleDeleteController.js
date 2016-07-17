var app = angular.module('app');


app.controller('vehicleDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Vehicle,

    vehicle,
    parent

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.vehicle = vehicle;
    }

    $scope.delete = function () {
        Vehicle.delete({ id: $scope.vehicle.Id }, function (result) {
            parent.load();
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

