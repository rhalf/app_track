/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for driverInsertController. 
                            Used for inserting driver.
*/
var app = angular.module('app');


app.controller('driverInsertController', function (
    $scope,
    $filter,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,
    

    authFactory,
    flagFactory,
    uiFactory,
    
    Driver,
    Company,

    parent

    ) {

    //Form
    $scope.add = function () {
      
        $scope.driver.name = $scope.driver.nameLast + ", " + $scope.driver.nameFirst + " " + $scope.driver.nameMiddle;
        $scope.ui.isLoading = true;

        Driver.save($scope.driver,
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

        $scope.driver = new Driver();
        $scope.driver.company = $scope.auth.getCompany();

    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    $scope.init();
});

