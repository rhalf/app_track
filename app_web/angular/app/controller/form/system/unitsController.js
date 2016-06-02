var app = angular.module('app');


app.controller('unitsController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

    Unit

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getAccessToken();
        $scope.ui = uiFactory;
        $scope.selectedCompany = $scope.authUser.Company;
    };

    $scope.select = function (unit) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/unit_update.html',
            controller: 'unitUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                unit: unit
            }
        });
    };

    $scope.delete = function (unit) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/unit_delete.html',
            controller: 'unitDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                unit: unit
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/unit_insert.html',
            controller: 'unitInsertController',
            keyboard: true,
            size: 'md'
        });
    };

    $scope.credential = function (unit) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/user_update_credential.html',
            controller: 'userUpdateCredentialController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: unit
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

