/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for systemController. 
                            Used for managing system.
*/
var app = angular.module('app');


app.controller('systemController', function (
    $scope,
    $timeout,
    $location,
    $uibModal,
    $uibModalInstance,

    authFactory,
    flagFactory,
    uiFactory,

    Company

    ) {

    $scope.init = function () {
        $scope.flag = flagFactory;

        $scope.authUser = authFactory.getUser();
        $scope.authCompany = authFactory.getCompany();

        $scope.ui = uiFactory;

        $scope.load();
    };

    $scope.load = function () {
        $scope.path = "app/view/form/companies.html";
    };

    $scope.showCompanies = function () {
        $scope.path = "app/view/form/companies.html";
    };
    $scope.showUsersOnline = function () {
        $scope.path = "app/view/form/users_online.html";
    };

   
    $scope.cancel = function () {
        $uibModalInstance.close();
    };

    
    $scope.init();
});

