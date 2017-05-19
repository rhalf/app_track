/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for panelContainerController.
*/
var app = angular.module('app');

app.controller('panelContainerController', function (
    $scope,
    $interval,
    uiFactory,
    flagFactory,
    authFactory,

    UserOnline
    ) {


    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.auth = authFactory;


        var userOnline = new UserOnline();
        userOnline.user = $scope.auth.getUser();

        UserOnline.save(userOnline);
        $interval(function () {
            UserOnline.save(userOnline);
        }, 300000);//300000);
    };

    $scope.init();
});