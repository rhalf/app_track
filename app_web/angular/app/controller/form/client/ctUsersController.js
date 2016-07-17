var app = angular.module('app');


app.controller('ctUsersController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

    User

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.ui = uiFactory;

        $scope.users = User.getByCompany({ company: $scope.authCompany.Id });
    };

    $scope.select = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_user_update.html',
            controller: 'ctUserUpdateController',
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
            templateUrl: 'app/view/form/client/ct_user_delete.html',
            controller: 'ctUserDeleteController',
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
            templateUrl: 'app/view/form/client/ct_user_insert.html',
            controller: 'ctUserInsertController',
            keyboard: true,
            size: 'md'
        });
    };

    $scope.credential = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_user_update_credential.html',
            controller: 'ctUserUpdateCredentialController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: user
            }
        });
    };

    $scope.clear = function () {
        $scope.selected = "";
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

