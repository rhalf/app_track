var app = angular.module('app');


app.controller('simsController', function (
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

    $scope.select = function (sim) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/sim_update.html',
            controller: 'simUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                sim: sim
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/sim_insert.html',
            controller: 'simInsertController',
            keyboard: true,
            size: 'md'
        });
    };

    $scope.delete = function (sim) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/sim_delete.html',
            controller: 'simDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                sim: sim
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

