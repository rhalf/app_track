/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for simUpdateController. 
                            Used for managing sim.
*/
var app = angular.module('app');


app.controller('simUpdateController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,
    


    authFactory,
    flagFactory,
    uiFactory,

    Company,
    Sim,

    sim,
    parent

    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    }

    $scope.update = function () {
        $scope.toggle();

        $scope.ui.isLoading = true;

        Sim.update(
            { id: $scope.sim.id },
            $scope.sim,

            function (result) {
                //Success
                    parent.load();
                    $scope.ui.isLoading = false;
                    var alert = { type: 'success', message: result.message };
                    $scope.ui.alert.show(alert);

            },
            function (result) {
                //Failed
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);

            }
        );
    }

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.auth = authFactory;

        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.ui = uiFactory;
        $scope.ui.dateTimePicker.isOpen = [
            false, //dateTimePicker1
            false  //dateTimePicker2
        ];
        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.sim = sim;

    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };
    
    $scope.init();
});

