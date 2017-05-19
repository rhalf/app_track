/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for panelCenterController.
*/
var app = angular.module('app');


app.controller('panelCenterController', function (
    $scope,
    uiFactory) {

    $scope.init = function () {
        $scope.ui = uiFactory;
    };

});