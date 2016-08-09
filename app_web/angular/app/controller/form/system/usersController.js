var app = angular.module('app');


app.controller('usersController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    //$uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

    Company,
    User

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function () {
        $scope.users = User.query();
        $scope.companies = Company.query();
    };

    $scope.select = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/user_update.html',
            controller: 'userUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: user,
                parent : $scope
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
                user: user,
                parent: $scope
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system/user_insert.html',
            controller: 'userInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent : $scope
            }
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

