var app = angular.module('app');


app.controller('userDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    User,

    user,
    parent

    ) {

    $scope.form = {};


    $scope.form.init = function () {
        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();
    }

    $scope.form.load = function () {
        $scope.User = user;
    }

    $scope.delete = function () {
        User.delete({ id: $scope.User.Id }, function (result) {
            $timeout(parent.form.load, 500);
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.form.init();
    $scope.form.load();
});

