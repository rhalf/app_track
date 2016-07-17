var app = angular.module('app');


app.controller('driverDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,

    Driver,

    driver,
    parent

    ) {
    

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.driver = driver;
    }

    $scope.delete = function () {
        Driver.delete({ id: $scope.driver.Id }, function (result) {
            parent.load();
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

