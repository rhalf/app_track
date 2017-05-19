/*
	Created by 		:		Rhalf Wendel D Caacbay
	Created on 		:		20170430

	Modified by 	:		#
	Modified on 	:		#

	functions 		:		Authentication process.
*/
var app = angular.module('app');

app.run(function (
    $rootScope,
    $templateCache,
    $location,
    authFactory,

    uiFactory,
    flagFactory

    ) {

   
    $rootScope.$on("$routeChangeStart", function (event, next, current) {

        uiFactory.isLoading = true;

        //console.log(event);
        //console.log(next);
        //console.log(current);

        //If route is authenticated, then the user should have access
        if (next.$$route.authenticated) {


            if (!authFactory.getUser()) {
                $location.path('/');
            }

        }
    });

    //$rootScope.$on('$routeChangeSuccess', function (event, next, current) {
    //    // Hide loading message
    //});
});


