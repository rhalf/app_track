/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for driverDeleteController. 
                            Used for deleting driver.
*/
var app = angular.module('app');


app.controller('driverDeleteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,



    authFactory,
    flagFactory,
    uiFactory,

    Driver,

    driver,
    parent

    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;

        $scope.auth = authFactory;

        $scope.driver = driver;
    };

    $scope.delete = function () {
        $scope.ui.isLoading = true;

        Driver.delete({ id: $scope.driver.id },
            function (result) {
                parent.load();
                $scope.cancel();
                $scope.ui.isLoading = false;
                var alert = { type: 'success', message: result.message };
                $scope.ui.alert.show(alert);
            },
            function (result) {
                $scope.ui.isLoading = false;
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };


    $scope.init();
});

