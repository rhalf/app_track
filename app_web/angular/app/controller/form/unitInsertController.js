/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for unitInsertController. 
                            Used for inserting unit.
*/
var app = angular.module('app');


app.controller('unitInsertController', function (
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
    fleetFactory,

    Company,
    Sim,
    Unit,

    parent

    ) {

    //Form
    $scope.add = function () {
        $scope.ui.isLoading = true;

        Unit.save(
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
        $scope.flag = flagFactory;
        $scope.valid = validationFactory;
        $scope.auth = authFactory;
        $scope.ui = uiFactory;
        $scope.fleet = fleetFactory;

        $scope.ui.dateTimePicker.isOpen = [
         false, //dateTimePicker1
         false  //dateTimePicker2
        ];

        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };


        $scope.unit = new Unit();
        $scope.unit.company = $scope.auth.getCompany();
        $scope.unit.dtSubscribed = $filter('date')(new Date(), 'yyyy-MM-dd');
        $scope.unit.dtExpired = $filter('date')(new Date(), 'yyyy-MM-dd');
        $scope.unit.sim = null;



        $scope.sims = Sim.getByCompany({ company: $scope.auth.getCompany().id });
    }


    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.clearSim = function () {
        $scope.unit.sim = null;
    }

    $scope.init();
});

