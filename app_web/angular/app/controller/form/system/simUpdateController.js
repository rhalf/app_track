﻿var app = angular.module('app');


app.controller('simUpdateController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,


    authFactory,
    flagFactory,
    uiFactory,

    Sim,

    sim

    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    }

    $scope.update = function () {
        $scope.toggle();

        Sim.update(
            { id: $scope.sim.Id },
            $scope.sim,

            function (result) {
                //Success
                    var alert = { type: 'success', message: '1 sim has been updated successfully.' };
                    $scope.ui.alert.addItem(alert);
                    $scope.flag.load('sims');
            },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.Message };
                $scope.ui.alert.addItem(alert);
            }
        );
    }

    //Alert
    $scope.closeAlert = function (index) {
        $scope.ui.alert.closeItem(index);
    }

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

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

        $scope.sim = sim;
    }
    
    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

