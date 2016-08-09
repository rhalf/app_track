var app = angular.module('app');


app.controller('ctDriversController', function (
    $scope,
    $location,
    $uibModal,
    $uibModalInstance,
    authFactory,
    flagFactory,
    uiFactory,

    Company,
    Driver

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser(); 
        $scope.ui = uiFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.companies = Company.query();
        $scope.drivers = Driver.getByCompany({ company: $scope.authUser.Company.Id });
        //console.log($scope.drivers);
    };

    $scope.select = function (driver) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_driver_update.html',
            controller: 'ctDriverUpdateController',
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
            templateUrl: 'app/view/form/client/ct_driver_insert.html',
            controller: 'ctDriverInsertController',
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
            templateUrl: 'app/view/form/client/ct_driver_delete.html',
            controller: 'ctDriverDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                driver: driver,
                parent: $scope
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

