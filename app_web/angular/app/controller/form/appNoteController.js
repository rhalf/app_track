/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for appNoteController. 
                            Used for showing notes from admin.
*/
var app = angular.module('app');

app.controller('appNoteController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,
    

    appNote

    ) {

    $scope.init = function () {
        $scope.appNote = appNote;
    };

    $scope.cancel = function () {
        $uibModalInstance.close();
    };


    $scope.init();
});

