/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for driverUpdateController. 
                            Used for updating driver.
*/
var app = angular.module('app');


app.controller('driverUpdateController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,
    


    authFactory,
    flagFactory,
    uiFactory,

    Company,
    Driver,

    driver,
    parent

    ) {

    $scope.toggle = function () {
        $scope.form.isDisabled = !$scope.form.isDisabled;
    }

    $scope.update = function () {

        $scope.driver.name = $scope.driver.nameLast + ", " + $scope.driver.nameFirst + " " + $scope.driver.nameMiddle;
        $scope.ui.isLoading = true;

        Driver.update(
            { id: $scope.driver.id },
            $scope.driver,

            function (result) {
                //Success
                    parent.load();
                    $scope.toggle();
                    $scope.ui.isLoading = false;
                    var alert = { type: 'success', message: result.message };
                    $scope.ui.alert.show(alert);
            },
            function (result) {
                //Failed
                $scope.toggle();
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            }
        );
    }

    $scope.init = function () {
        $scope.form = {};
        $scope.form.isDisabled = true;

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

        $scope.driver = driver;
    }
    
    $scope.cancel = function () {
        $uibModalInstance.close();
    };


    $scope.init();
});

