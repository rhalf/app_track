/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Controller for panelMenuController.
*/
var app = angular.module('app');


app.controller('panelMenuController', function (
    $scope,
    $location,
     $uibModal,

    uiFactory,
    authFactory,
    flagFactory,
    systemFactory,
    toolFactory,

    sessionService,

    Company
    ) {

    $scope.logout = function () {
        authFactory.clear();
        $location.path('/')
    };


    //System
    $scope.showSystem = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/system.html',
            controller: 'systemController',
            keyboard: true,
            size: 'lg'
        });
    };
    $scope.showPreferences = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/preferences.html',
            controller: 'preferencesController',
            keyboard: true,
            size: 'lg',
            resolve: {
                company: $scope.auth.getCompany()
            }
        });
    };
    $scope.showMapTools = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/map/map_tools.html',
            controller: 'mapToolsController',
            keyboard: true,
            size: 'lg'
        });
    };
   
    //About
    $scope.showAbouts = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/help/abouts.html',
            controller: 'aboutsController',
            keyboard: true,
            size: 'md'
        });
    };
    //Icons
    $scope.showIcons = function () {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/help/icons.html',
            controller: 'iconsController',
            keyboard: true,
            size: 'md'
        });
    };
    $scope.init = function () {
        $scope.auth = authFactory;
        $scope.flag = flagFactory;
        $scope.ui = uiFactory;
        $scope.system = systemFactory;
        $scope.tool = toolFactory;

    };



    //$scope.openNote = function (appNote) {
    //    $uibModal.open({
    //        animation: true,
    //        templateUrl: 'app/view/form/app_note.html',
    //        controller: 'appNoteController',
    //        keyboard: true,
    //        size: 'md',
    //        resolve: {
    //            appNote: appNote
    //        }
    //    });
    //};

    //$scope.panelModeSelect = function (index) {
    //    $scope.ui.panelMode= index;
    //};

    $scope.init();
});

