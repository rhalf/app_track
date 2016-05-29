var app = angular.module('app');


app.controller('userUpdateCredentialController', function (
    $q,
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,
    validationFactory,

    User,
    Info,
    Sim,

    user,
    parent

    ) {

    $scope.form = {};


    $scope.form.update = function () {

        if (validationFactory.password.notMatch($scope.User.Password, $scope.User.Password1)) {
            var alert = { type: 'danger', message: 'Password don\'t match...' };
            $scope.alert.addItem(alert);
            return;
        }

        if (validationFactory.password.isShort($scope.User.Password, $scope.User.Password1)) {
            var alert = { type: 'danger', message: 'Password is short...' };
            $scope.alert.addItem(alert);
            return;
        }


        User.setCredential(
                 { id: $scope.User.Id, type: 'credential' },
                 $scope.User,
                 function (result) {
                     var alert = { type: 'success', message: 'This user has been updated.' };
                     $scope.alert.addItem(alert);
                     $timeout(parent.form.load, 200);
                 },
                 function (result) {
                     var alert = { type: 'danger', message: result.data.Message };
                     $scope.alert.addItem(alert);
                 }
         );

    }


    //Alert
    $scope.closeAlert = function (index) {
        $scope.alert.closeItem(index);
    }



    $scope.form.init = function () {
        $scope.form.isDisabled = true;
        $scope.AuthUser = authFactory.getAccessToken();

        uiFactory.alert.items = [];
        $scope.alert = uiFactory.alert;
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

