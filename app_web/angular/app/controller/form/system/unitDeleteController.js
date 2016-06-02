var app = angular.module('app');


app.controller('unitDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Unit,
    unit

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getAccessToken();
        $scope.unit = unit;
    }

    $scope.delete = function () {
        Unit.delete({ id: $scope.unit.Id }, function (result) {
            $scope.flag.load('units');
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

