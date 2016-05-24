var app = angular.module('app');


app.controller('usersController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,

    User

    ) {

    $scope.form = {};

    $scope.form.init = function () {
        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();
    }

    $scope.form.load = function () {
        User.query(function (users) {
            $scope.Users = users;
        });
    }

    $scope.select = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/user_update.html',
            controller: 'userUpdateController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: user,
                parent: $scope
            }
        });
    }
    $scope.delete = function (user) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/user_delete.html',
            controller: 'userDeleteController',
            keyboard: true,
            size: 'md',
            resolve: {
                user: user,
                parent: $scope
            }
        });
    }

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/user_insert.html',
            controller: 'userInsertController',
            keyboard: true,
            size: 'md',
            resolve: {
                parent: $scope
            }
        });
    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.form.init();
    $scope.form.load();
});

