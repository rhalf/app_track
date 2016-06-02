﻿var app = angular.module('app');


app.controller('userInsertController', function (
    $q,
    $scope,
    $filter,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,
    validationFactory,


    User,
    UserInfo
    ) {

    //Form
    $scope.add = function () {

        if (validationFactory.isNullOrEmpty($scope.user.Name)) {
            var alert = { type: 'danger', message: 'Username is null or Empty...' };
            $scope.ui.alert.addItem(alert);
            return;
        }

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




        User.save(
            $scope.user,
            function (result) {
                //Success
                var alert = { type: 'success', message: '1 user has been added successfully.' };
                $scope.ui.alert.addItem(alert);
                $scope.userInfo.User = result.Id;
                UserInfo.save(
                    $scope.userInfo,
                    function (result) {
                        //Success
                        var alert = { type: 'success', message: '1 userinfo has been added successfully.' };
                        $scope.ui.alert.addItem(alert);
                        $scope.flag.load('users');
                    },
                    function (result) {
                        //Failed
                        var alert = { type: 'danger', message: result.data.Message };
                        $scope.ui.alert.addItem(alert);
                        return;
                    });
            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.data.Message };
                $scope.ui.alert.addItem(alert);
                return;
            });
    };


    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    }



    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.authUser = authFactory.getAccessToken();
        $scope.ui = uiFactory;

        $scope.ui.dateTimePicker.isOpen = [
           false, //dateTimePicker1
           false  //dateTimePicker2
        ];

        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.ui.alert.items = [];


        $scope.user = new User();
        $scope.userInfo = new UserInfo();

        $scope.user.DtExpired = $filter('date')(new Date(), 'yyyy-MM-dd');

    };


    $scope.clearSim = function () {
        $scope.unit.Sim = 0;
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

