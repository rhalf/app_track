/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Routing urls.
*/
var app = angular.module('app');

app.config(function (
    $routeProvider,
    $locationProvider,
    $httpProvider,
    $logProvider) {

    $routeProvider
        .when('/form', {
            templateUrl: 'app/view/directive/panelContainer.html',
            controller: 'panelContainerController',
            authenticated: true,
            resolve: {
                flags: function ($timeout, flagFactory, uiFactory) {
                    flagFactory.init();
                }
            }

        })
        .when('/', {
            templateUrl: 'app/view/form/login.html',
            controller: 'loginController',
        })
        .otherwise({
            redirectTo: '/'
        });


    $logProvider.debugEnabled(false);
});
