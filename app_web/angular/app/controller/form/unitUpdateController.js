/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for unitUpdateController. 
                            Used for updating unit.
*/
var app = angular.module('app');


app.controller('unitUpdateController', function (
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
    fleetFactory,

    Company,
    Sim,
    Unit,

    unit,
    parent

    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    };

    $scope.update = function () {
        $scope.toggle();

        $scope.ui.isLoading = true;

        Unit.update(
            { id: $scope.unit.id },
            $scope.unit,
            function (result) {
                //Success
                $scope.fleet.loadVehicles(function () {
                    parent.load();
                });
                $scope.ui.isLoading = false;
                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);

            },
            function (result) {
                //Failed
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });
    };


    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

        $scope.flag = flagFactory;
        $scope.valid = validationFactory;
        $scope.auth = authFactory;
        $scope.fleet = fleetFactory;


        $scope.ui = uiFactory;
        $scope.ui.dateTimePicker.isOpen = [
            false, //dateTimePicker1
            false  //dateTimePicker2
        ];
        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.unit = unit;
        $scope.sims = Sim.getByCompany({ company: $scope.auth.getCompany().id });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

