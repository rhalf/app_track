var app = angular.module('app');


app.controller('ctUserUpdateCredentialController', function (
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
    user
    ) {

    $scope.update = function () {
        if (validationFactory.password.notMatch($scope.user.Password, $scope.user.Password1)) {
            var alert = { type: 'danger', message: 'Password don\'t match...' };
            $scope.ui.alert.addItem(alert);
            return;
        }

        if (validationFactory.password.isShort($scope.user.Password, $scope.user.Password1)) {
            var alert = { type: 'danger', message: 'Password is short...' };
            $scope.ui.alert.addItem(alert);
            return;
        }

        $scope.ui.isLoading = true;

        User.setCredential(
            { id: $scope.user.Id, type: 'credential' },
            $scope.user,
            function (result) {
                var alert = { type: 'success', message: 'This user has been updated.' };
                $scope.ui.alert.addItem(alert);
                $scope.ui.isLoading = false;
            },
            function (result) {
                var alert = { type: 'danger', message: result.data.Message };
                $scope.ui.alert.addItem(alert);
                $scope.ui.isLoading = false;
            });
    };

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    };

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;
        $scope.authUser = authFactory.getUser();
        $scope.ui = uiFactory;
        $scope.flag = flagFactory;

        uiFactory.alert.items = [];

        $scope.user = user;
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

