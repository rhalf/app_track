var app = angular.module('app');


app.controller('userUpdateController', function (
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
    UserInfo,

    user
    ) {



    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    };

    $scope.update = function () {
        $scope.toggle();

        if (validationFactory.isNullOrEmpty($scope.user.Name)) {
            var alert = { type: 'danger', message: 'Username is null or Empty...' };
            $scope.ui.alert.addItem(alert);
            return;
        }

        UserInfo.update({ id: $scope.userInfo.Id }, $scope.userInfo,
            function (result) {
                //Success
                var alert = { type: 'success', message: '1 userInfo has been updated.' };
                $scope.ui.alert.addItem(alert);
            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.Message };
                $scope.ui.alert.addItem(alert);
            });

        User.update({ id: $scope.user.Id }, $scope.user,
            function (result) {
                //Success
                var alert = { type: 'success', message: '1 user has been updated.' };
                $scope.ui.alert.addItem(alert);
            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.Message };
                $scope.ui.alert.addItem(alert);
            });
    };


    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    };



    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.authUser = authFactory.getAccessToken();

        $scope.ui.dateTimePicker.isOpen = [
        false, //dateTimePicker1
        false  //dateTimePicker2
        ];

        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.ui.alert.items = [];


        $scope.user = user;
        $scope.userInfo = UserInfo.get({ user: user.Id });

    };

    $scope.clearSim = function () {
        $scope.user.Sim = 0;
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

