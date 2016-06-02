var app = angular.module('app');


app.controller('usersController', function (
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
        $scope.selectedCompany = $scope.authUser.Company;
    };

    $scope.select = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/user_update.html',
            controller: 'userUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: user
            }
        });
    };
    $scope.delete = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/user_delete.html',
            controller: 'userDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: user
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/user_insert.html',
            controller: 'userInsertController',
            keyboard: true,
            size: 'md'
        });
    };

    $scope.credential = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/user_update_credential.html',
            controller: 'userUpdateCredentialController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: user
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

