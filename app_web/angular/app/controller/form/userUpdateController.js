var app = angular.module('app');


app.controller('userUpdateController', function (
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

    $scope.dateTimePicker = uiFactory.dateTimePicker;
    $scope.dateTimePicker.isOpen = [
        false, //dateTimePicker1
        false  //dateTimePicker2
    ];
    $scope.dateTimePicker.toggle = function (index) {
        $scope.dateTimePicker.isOpen[index] = !$scope.dateTimePicker.isOpen[index];
    };

    $scope.form = {};
    $scope.form.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    };

    $scope.form.update = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
        User.update(
            { id: $scope.User.Id },
            $scope.User,
            function (result) {
                $timeout(parent.form.load, 500);
                $scope.cancel();
            }
            );

    }

    $scope.form.init = function () {
        $scope.form.isDisabled = true;
        $scope.Flag = flagFactory;
        $scope.AuthUser = authFactory.getAccessToken();
    }

    $scope.form.load = function () {
        $scope.User = user;
    }

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.form.init();
    $scope.form.load();
});

