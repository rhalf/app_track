var app = angular.module('app');

app.controller('iconsController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance
    ) {

    $scope.init = function () {
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    
    $scope.init();
});

