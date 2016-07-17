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

    unit,
    parent

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
  
        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.unit = unit;
    }

    $scope.delete = function () {
        Unit.delete({ id: $scope.unit.Id }, function (result) {
            parent.load();
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

