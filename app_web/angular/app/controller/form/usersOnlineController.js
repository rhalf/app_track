/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for usersOnlineController. 
                            Used for managing usersOnline.
*/
var app = angular.module('app');


app.controller('usersOnlineController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    

    authFactory,
    flagFactory,
    uiFactory,

    Company,
    UserOnline

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;
        $scope.auth = authFactory;
        $scope.ui = uiFactory;
        $scope.load();
    };

    $scope.load = function () {
        UserOnline.getByTime({ time: 5 },
             function (result) {
                 //Success
                 $scope.usersOnline = result;
             },
            function (result) {
                //Failed
                var alert = { type: 'danger', message: result.data.message };
                $scope.ui.alert.show(alert);
            });
    };

    $scope.init();
});

