var app = angular.module('app');


app.controller('ctUserDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    User,
    user

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getAccessToken();
        $scope.user = user;
    }

    $scope.delete = function () {
        User.delete({ id: $scope.user.Id }, function (result) {
            $scope.flag.load('users');
            $scope.cancel();
        });
    };


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

