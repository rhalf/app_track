/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Factory for uiFactory. 
                            Used for managing ui globally.
*/
var app = angular.module('app');


app.factory('uiFactory', function (
    $uibModal,
    
    toolFactory

    ) {
    var uiFactory = {};

    uiFactory.isLoading = true;

    uiFactory.panelLeft = false;
    uiFactory.panelBottom = false;
    uiFactory.panelCollapse = toolFactory.isMobile();
    uiFactory.panelSystem = false;

    uiFactory.panelMode = 0;
    uiFactory.panelModes = [
        { name: 'Tracking' },
        { name: 'Reporting' },
        { name: 'Administrating' },
    ];
    uiFactory.panelModeTemplate = null;

    uiFactory.dateTimePicker = {};
    uiFactory.dateTimePicker.format = ["yyyy-MM-dd HH:mm:ss", "yyyy-MM-dd", "HH:mm:ss"];
    uiFactory.dateTimePicker.options = {
        showWeeks: true
    };

    uiFactory.alert = {};
    uiFactory.alert.show = function (alert) {
        $uibModal.open({
            animation: true,
            templateUrl: 'app/view/form/alert.html',
            controller: 'alertController',
            keyboard: true,
            backdropClick: true,
            size: 'sm',
            resolve: {
                alert: alert
            }
        });
    };


    uiFactory.pagination = {};
    uiFactory.pagination.pageSize = 10;
    uiFactory.pagination.currentPage = 1;
    uiFactory.pagination.maxSize = 5;

    return uiFactory;

});