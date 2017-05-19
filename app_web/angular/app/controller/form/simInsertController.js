/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for simInsertController. 
                            Used for inserting sims.
*/
var app = angular.module('app');


app.controller('simInsertController', function (
    $scope,
    $filter,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,
    

    authFactory,
    flagFactory,
    uiFactory,
    
    Company,
    Sim,

    parent

    ) {

    //Form
    $scope.add = function () {

        $scope.ui.isLoading = true;

        Sim.save($scope.sim,
            //Success
            function (result) {
                parent.load();
                $scope.ui.isLoading = false;
                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);

            },
            //Failed
            function (result) {
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);

            }
        );
    };



    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.auth = authFactory;
        $scope.ui = uiFactory;

        $scope.ui.dateTimePicker.isOpen = [
                 false, //dateTimePicker1
                 false  //dateTimePicker2
        ];

        $scope.ui.dateTimePicker.toggle = function (index) {
            $scope.ui.dateTimePicker.isOpen[index] = !$scope.ui.dateTimePicker.isOpen[index];
        };

        $scope.sim = new Sim();
        $scope.sim.company = $scope.auth.getCompany();
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };
    
    $scope.init();
});

