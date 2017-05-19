/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for vehicleUpdateController. 
                            Used for updating vehicle.
*/
var app = angular.module('app');


app.controller('vehicleUpdateController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,
    


    authFactory,
    flagFactory,
    fleetFactory,
    uiFactory,
    validationFactory,

    Company,
    Vehicle,
    Unit,
    Driver,


    vehicle,
    parent
    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    };

    $scope.update = function () {
        $scope.toggle();

        $scope.ui.isLoading = true;


        Vehicle.update(
            { id: $scope.vehicle.id },
            $scope.vehicle,
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

        $scope.fleet = fleetFactory;
        $scope.flag = flagFactory;
        $scope.valid = validationFactory;
        $scope.auth = authFactory;

        $scope.ui = uiFactory;
        $scope.ui.dateTimePicker.isOpen = [
            false, //dateTimePicker1
            false  //dateTimePicker2
        ];
        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };


        $scope.vehicle = vehicle;
        $scope.units = Unit.getByCompany({ company: $scope.auth.getCompany().id });
        $scope.drivers = Driver.getByCompany({ company: $scope.auth.getCompany().id });

    };



    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

