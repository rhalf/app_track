/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for alertController. 
                            Used for showing alerts in modal mode.
*/
var app = angular.module('app');


app.controller('alertController', function (
    $timeout,
    $scope,
    alert,
    $uibModalInstance

    ) {

    $scope.init = function() {
        $scope.alert = alert;

        $timeout(function () {
            $scope.cancel();
        }, 1500);
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };

 
    $scope.init();
});

