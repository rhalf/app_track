/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Events onload.
*/
var app = angular.module('app');

app.controller('appController', function (
    $scope,
    $timeout,
    flagFactory,
    uiFactory,
    leafletFactory

    ) {
    $scope.$on('$viewContentLoaded', function (event) {
        $timeout(function () {
            $scope.ui.isLoading = false;
        }, 1000);  
    });

    $scope.init = function () {
        $scope.ui = uiFactory;
    };

    $scope.init();
});

