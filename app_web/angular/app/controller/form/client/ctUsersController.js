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

        $scope.ui = uiFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.users = User.getByCompany({ company: $scope.authUser.Company.Id });
    };

    $scope.select = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_user_update.html',
            controller: 'ctUserUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: user,
                parent: $scope
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
                user: user,
                parent : $scope
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/client/ct_user_insert.html',
            controller: 'ctUserInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
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

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

