/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for vehicleInsertController. 
                            Used for inserting vehicle.
*/
var app = angular.module('app');


app.controller('vehicleInsertController', function (
        $q,
        $scope,
        $filter,
        $timeout,
        $location,
        $uibModal,
        $uibModalInstance,
    


        authFactory,
        fleetFactory,
        flagFactory,
        uiFactory,
        validationFactory,

        Company,
        Vehicle,
        Unit,
        Driver,

        parent

    ) {

    //Form
    $scope.add = function () {
        $scope.ui.isLoading = true;

        Vehicle.save(
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
        $scope.fleet = fleetFactory;
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.valid = validationFactory;
        $scope.auth = authFactory;

        $scope.ui.dateTimePicker.isOpen = [
         false, //dateTimePicker1
         false  //dateTimePicker2
        ];

        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.vehicle = new Vehicle();
        $scope.vehicle.company = $scope.auth.getCompany();
        $scope.vehicle.dtSubscribed = $filter('date')(new Date(), 'yyyy-MM-dd');

        $scope.units = Unit.getByCompany({ company: $scope.auth.getCompany().id });
        $scope.drivers = Driver.getByCompany({ company: $scope.auth.getCompany().id });

    };

 
    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

